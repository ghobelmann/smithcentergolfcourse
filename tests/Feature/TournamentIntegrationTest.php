<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Score;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $player1;
    protected User $player2;
    protected User $player3;
    protected User $player4;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create([
            'email' => 'admin@golfclub.com',
            'name' => 'Tournament Director'
        ]);
        
        $this->player1 = User::factory()->create([
            'email' => 'player1@test.com',
            'name' => 'Alice Johnson',
            'handicap' => 12
        ]);
        
        $this->player2 = User::factory()->create([
            'email' => 'player2@test.com',
            'name' => 'Bob Smith',
            'handicap' => 8
        ]);
        
        $this->player3 = User::factory()->create([
            'email' => 'player3@test.com',
            'name' => 'Carol Davis',
            'handicap' => 15
        ]);
        
        $this->player4 = User::factory()->create([
            'email' => 'player4@test.com',
            'name' => 'David Wilson',
            'handicap' => 20
        ]);
    }

    /** @test */
    public function complete_individual_tournament_workflow()
    {
        // Step 1: Admin creates a course
        $this->actingAs($this->admin);
        
        $courseResponse = $this->post(route('courses.store'), [
            'name' => 'Pebble Beach Golf Links',
            'description' => 'World famous golf course',
            'address' => '1700 17 Mile Dr',
            'city' => 'Pebble Beach',
            'state' => 'CA',
            'zip_code' => '93953',
            'phone' => '(831) 624-3811',
            'website' => 'https://pebblebeach.com',
            'hole_count' => 18,
            'par' => 72,
            'yardage' => 6828,
            'active' => true,
        ]);
        
        $courseResponse->assertRedirect(route('courses.index'));
        $this->course = Course::where('name', 'Pebble Beach Golf Links')->first();
        $this->assertNotNull($this->course);

        // Step 2: Admin sets up course with holes and tees
        $setupResponse = $this->post(route('courses.setup', $this->course), [
            'hole_count' => 18,
            'new_tees' => [
                [
                    'name' => 'Championship',
                    'color' => 'Black',
                    'rating' => 75.2,
                    'slope' => 142,
                    'gender' => 'men',
                ],
                [
                    'name' => 'Blue',
                    'color' => 'Blue',
                    'rating' => 72.8,
                    'slope' => 135,
                    'gender' => 'men',
                ],
                [
                    'name' => 'White',
                    'color' => 'White',
                    'rating' => 70.1,
                    'slope' => 128,
                    'gender' => 'mixed',
                ],
            ],
        ]);
        
        $setupResponse->assertRedirect(route('courses.index'));
        $this->assertEquals(18, $this->course->holes()->count());
        $this->assertEquals(3, $this->course->tees()->count());

        // Step 3: Admin creates a tournament
        $blueTee = $this->course->tees()->where('name', 'Blue')->first();
        
        $tournamentResponse = $this->post(route('tournaments.store'), [
            'name' => 'Spring Championship',
            'description' => 'Annual spring golf championship',
            'start_date' => now()->addDays(30)->toDateString(),
            'end_date' => now()->addDays(30)->toDateString(),
            'holes' => 18,
            'format' => 'individual',
            'team_size' => 1,
            'entry_fee' => 125.00,
            'max_participants' => 50,
            'status' => 'open',
            'course_id' => $this->course->id,
            'course_tee_id' => $blueTee->id,
        ]);
        
        $tournamentResponse->assertRedirect(route('tournaments.index'));
        $tournament = Tournament::where('name', 'Spring Championship')->first();
        $this->assertNotNull($tournament);

        // Step 4: Players register for the tournament
        $this->actingAs($this->player1);
        $registerResponse1 = $this->post(route('tournaments.register', $tournament), [
            'handicap' => 12,
        ]);
        $registerResponse1->assertRedirect();

        $this->actingAs($this->player2);
        $registerResponse2 = $this->post(route('tournaments.register', $tournament), [
            'handicap' => 8,
        ]);
        $registerResponse2->assertRedirect();

        $this->actingAs($this->player3);
        $registerResponse3 = $this->post(route('tournaments.register', $tournament), [
            'handicap' => 15,
        ]);
        $registerResponse3->assertRedirect();

        $this->actingAs($this->player4);
        $registerResponse4 = $this->post(route('tournaments.register', $tournament), [
            'handicap' => 20,
        ]);
        $registerResponse4->assertRedirect();

        // Verify all players are registered
        $this->assertEquals(4, $tournament->entries()->count());

        // Step 5: Admin assigns cards and starting positions
        $this->actingAs($this->admin);
        $entries = $tournament->entries()->get();
        
        $cardResponse = $this->post(route('tournaments.cards.assign', $tournament), [
            'assignments' => [
                $entries[0]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1,
                ],
                $entries[1]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 2,
                ],
                $entries[2]->id => [
                    'starting_hole' => 10,
                    'group_letter' => 'B',
                    'card_order' => 1,
                ],
                $entries[3]->id => [
                    'starting_hole' => 10,
                    'group_letter' => 'B',
                    'card_order' => 2,
                ],
            ]
        ]);
        
        $cardResponse->assertRedirect();

        // Step 6: Admin prints scorecards with QR codes
        $scorecardResponse = $this->get(route('tournaments.scorecards.print', $tournament));
        $scorecardResponse->assertOk();
        $scorecardResponse->assertSee('Spring Championship');
        $scorecardResponse->assertSee('Alice Johnson');
        $scorecardResponse->assertSee('QR Code');

        // Step 7: Players enter scores via mobile using QR codes
        $entry1 = $entries->where('user_id', $this->player1->id)->first();
        $qrToken1 = $entry1->id . '-' . hash('sha256', $entry1->id . $entry1->tournament_id);
        
        // Player 1 plays first 9 holes
        for ($hole = 1; $hole <= 9; $hole++) {
            $courseHole = $this->course->holes()->where('hole_number', $hole)->first();
            $strokes = rand($courseHole->par - 1, $courseHole->par + 2); // Random score near par
            
            $scoreResponse = $this->post(route('mobile.score.store', ['token' => $qrToken1]), [
                'hole_number' => $hole,
                'strokes' => $strokes,
                'par' => $courseHole->par,
            ]);
            
            $scoreResponse->assertRedirect();
        }

        // Player 2 also plays first 9 holes with better scores
        $entry2 = $entries->where('user_id', $this->player2->id)->first();
        $qrToken2 = $entry2->id . '-' . hash('sha256', $entry2->id . $entry2->tournament_id);
        
        for ($hole = 1; $hole <= 9; $hole++) {
            $courseHole = $this->course->holes()->where('hole_number', $hole)->first();
            $strokes = $courseHole->par - 1; // All birdies for better leaderboard position
            
            $scoreResponse = $this->post(route('mobile.score.store', ['token' => $qrToken2]), [
                'hole_number' => $hole,
                'strokes' => $strokes,
                'par' => $courseHole->par,
            ]);
            
            $scoreResponse->assertRedirect();
        }

        // Step 8: Check live leaderboard updates
        $leaderboardResponse = $this->get(route('tournaments.leaderboard', $tournament));
        $leaderboardResponse->assertOk();
        $leaderboardResponse->assertSeeInOrder(['Bob Smith', 'Alice Johnson']); // Bob should be leading

        // Step 9: Check live leaderboard API
        $liveResponse = $this->get(route('tournaments.leaderboard.live', $tournament));
        $liveResponse->assertOk();
        $liveResponse->assertJsonStructure([
            'tournament_id',
            'entries' => [
                '*' => [
                    'player_name',
                    'total_strokes',
                    'holes_completed',
                    'score_to_par',
                ]
            ],
            'last_updated',
        ]);

        // Step 10: Players complete their rounds
        for ($hole = 10; $hole <= 18; $hole++) {
            $courseHole = $this->course->holes()->where('hole_number', $hole)->first();
            
            // Player 1 finishes
            $this->post(route('mobile.score.store', ['token' => $qrToken1]), [
                'hole_number' => $hole,
                'strokes' => $courseHole->par,
                'par' => $courseHole->par,
            ]);
            
            // Player 2 finishes
            $this->post(route('mobile.score.store', ['token' => $qrToken2]), [
                'hole_number' => $hole,
                'strokes' => $courseHole->par,
                'par' => $courseHole->par,
            ]);
        }

        // Step 11: Admin marks tournament as completed
        $this->actingAs($this->admin);
        $updateResponse = $this->put(route('tournaments.update', $tournament), [
            'name' => $tournament->name,
            'description' => $tournament->description,
            'start_date' => $tournament->start_date->toDateString(),
            'end_date' => $tournament->end_date->toDateString(),
            'holes' => $tournament->holes,
            'format' => $tournament->format,
            'team_size' => $tournament->team_size,
            'entry_fee' => $tournament->entry_fee,
            'max_participants' => $tournament->max_participants,
            'status' => 'completed',
            'course_id' => $tournament->course_id,
            'course_tee_id' => $tournament->course_tee_id,
        ]);
        
        $updateResponse->assertRedirect();

        // Step 12: Verify final results
        $finalLeaderboard = $this->get(route('tournaments.leaderboard', $tournament));
        $finalLeaderboard->assertOk();
        $finalLeaderboard->assertSee('Tournament Complete');
        
        // Verify scores are saved correctly
        $player1Scores = Score::where('tournament_entry_id', $entry1->id)->count();
        $player2Scores = Score::where('tournament_entry_id', $entry2->id)->count();
        
        $this->assertEquals(18, $player1Scores);
        $this->assertEquals(18, $player2Scores);
        
        // Player 2 should have the better score
        $player1Total = Score::where('tournament_entry_id', $entry1->id)->sum('strokes');
        $player2Total = Score::where('tournament_entry_id', $entry2->id)->sum('strokes');
        
        $this->assertLessThan($player1Total, $player2Total);
    }

    /** @test */
    public function complete_scramble_tournament_workflow()
    {
        // Create course first
        $this->course = Course::factory()->withHoles()->create();
        
        // Step 1: Admin creates scramble tournament
        $this->actingAs($this->admin);
        
        $tournament = Tournament::factory()->scramble()->create([
            'name' => 'Annual Scramble Tournament',
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
            'team_size' => 4,
        ]);

        // Step 2: Player 1 creates a team
        $this->actingAs($this->player1);
        $teamResponse = $this->post(route('tournaments.teams.store', $tournament), [
            'name' => 'Team Thunder',
            'description' => 'Best team in the tournament',
        ]);
        
        $teamResponse->assertRedirect();
        $team = Team::where('name', 'Team Thunder')->first();
        $this->assertNotNull($team);

        // Step 3: Captain adds team members
        $memberResponse2 = $this->post(route('teams.members.store', $team), [
            'user_id' => $this->player2->id,
            'handicap' => 8,
        ]);
        $memberResponse2->assertRedirect();

        $memberResponse3 = $this->post(route('teams.members.store', $team), [
            'user_id' => $this->player3->id,
            'handicap' => 15,
        ]);
        $memberResponse3->assertRedirect();

        $memberResponse4 = $this->post(route('teams.members.store', $team), [
            'user_id' => $this->player4->id,
            'handicap' => 20,
        ]);
        $memberResponse4->assertRedirect();

        // Verify team is complete
        $this->assertEquals(4, $team->fresh()->getMemberCount());

        // Step 4: Admin assigns team card
        $this->actingAs($this->admin);
        $cardResponse = $this->post(route('tournaments.cards.assign', $tournament), [
            'team_assignments' => [
                $team->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1,
                ],
            ]
        ]);
        
        $cardResponse->assertRedirect();

        // Step 5: Team plays and enters scores
        $qrToken = 'team-' . $team->id . '-' . hash('sha256', 'team-' . $team->id . $team->tournament_id);
        
        // Enter team scramble scores (should be good since it's best ball)
        for ($hole = 1; $hole <= 18; $hole++) {
            $courseHole = $this->course->holes()->where('hole_number', $hole)->first();
            $teamScore = max(2, $courseHole->par - 1); // Team scores well (eagle or birdie)
            
            $scoreResponse = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
                'hole_number' => $hole,
                'strokes' => $teamScore,
                'par' => $courseHole->par,
            ]);
            
            $scoreResponse->assertRedirect();
        }

        // Step 6: Verify team leaderboard
        $leaderboardResponse = $this->get(route('tournaments.leaderboard', $tournament));
        $leaderboardResponse->assertOk();
        $leaderboardResponse->assertSee('Team Thunder');
        $leaderboardResponse->assertSee('Team Leaderboard');

        // Verify team scores are saved correctly
        $teamScores = Score::where('team_id', $team->id)->count();
        $this->assertEquals(18, $teamScores);
        
        // Team should have good total score
        $teamTotal = Score::where('team_id', $team->id)->sum('strokes');
        $coursePar = $this->course->holes()->sum('par');
        $this->assertLessThan($coursePar, $teamTotal);
    }

    /** @test */
    public function tournament_handles_error_conditions_gracefully()
    {
        $this->course = Course::factory()->withHoles()->create();
        $tournament = Tournament::factory()->individual()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
        ]);

        // Test 1: Duplicate registration
        $this->actingAs($this->player1);
        $this->post(route('tournaments.register', $tournament), ['handicap' => 12]);
        
        $duplicateResponse = $this->post(route('tournaments.register', $tournament), ['handicap' => 12]);
        $duplicateResponse->assertSessionHasErrors();

        // Test 2: Invalid QR token
        $invalidTokenResponse = $this->get(route('mobile.scoring', ['token' => 'invalid-token']));
        $invalidTokenResponse->assertStatus(404);

        // Test 3: Score for non-existent hole
        $entry = TournamentEntry::where('user_id', $this->player1->id)
                               ->where('tournament_id', $tournament->id)
                               ->first();
        $qrToken = $entry->id . '-' . hash('sha256', $entry->id . $entry->tournament_id);
        
        $invalidScoreResponse = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 99, // Invalid hole
            'strokes' => 4,
            'par' => 4,
        ]);
        $invalidScoreResponse->assertSessionHasErrors();

        // Test 4: Regular user trying to access admin functions
        $adminResponse = $this->get(route('tournaments.cards', $tournament));
        $adminResponse->assertForbidden();
    }

    /** @test */
    public function tournament_statistics_and_reporting_work()
    {
        $this->course = Course::factory()->withHoles()->create();
        $tournament = Tournament::factory()->individual()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
        ]);

        // Register multiple players
        foreach ([$this->player1, $this->player2, $this->player3, $this->player4] as $player) {
            $this->actingAs($player);
            $this->post(route('tournaments.register', $tournament), [
                'handicap' => $player->handicap,
            ]);
        }

        // Some players complete rounds, others don't
        $entries = $tournament->entries()->get();
        
        // Player 1 completes full round
        $entry1 = $entries->where('user_id', $this->player1->id)->first();
        for ($hole = 1; $hole <= 18; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry1->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
        }

        // Player 2 completes only 9 holes
        $entry2 = $entries->where('user_id', $this->player2->id)->first();
        for ($hole = 1; $hole <= 9; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry2->id,
                'hole_number' => $hole,
                'strokes' => 3,
                'par' => 4,
            ]);
        }

        // Check tournament statistics
        $this->actingAs($this->admin);
        $tournamentView = $this->get(route('tournaments.show', $tournament));
        $tournamentView->assertOk();
        $tournamentView->assertSee('4 Registered'); // Total registered
        $tournamentView->assertSee('1 Complete'); // Completed rounds
        $tournamentView->assertSee('1 In Progress'); // In progress rounds
        
        // Check leaderboard shows different completion statuses
        $leaderboardView = $this->get(route('tournaments.leaderboard', $tournament));
        $leaderboardView->assertOk();
        $leaderboardView->assertSee('18/18'); // Complete round
        $leaderboardView->assertSee('9/18');  // Incomplete round
    }
}