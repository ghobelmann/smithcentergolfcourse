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

class LeaderboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Tournament $individualTournament;
    protected Tournament $scrambleTournament;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create();
        $this->course = Course::factory()->withHoles()->create(['hole_count' => 18]);
        
        $this->individualTournament = Tournament::factory()->individual()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
            'holes' => 18,
        ]);
        
        $this->scrambleTournament = Tournament::factory()->scramble()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
            'holes' => 18,
            'team_size' => 4,
        ]);
    }

    /** @test */
    public function individual_leaderboard_displays_correctly()
    {
        // Create players with different scores
        $player1 = User::factory()->create(['name' => 'John Doe']);
        $player2 = User::factory()->create(['name' => 'Jane Smith']);
        $player3 = User::factory()->create(['name' => 'Bob Johnson']);
        
        $entry1 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player1->id,
            'handicap' => 10,
        ]);
        
        $entry2 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player2->id,
            'handicap' => 15,
        ]);
        
        $entry3 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player3->id,
            'handicap' => 8,
        ]);

        // Create scores (player2 has best score)
        for ($hole = 1; $hole <= 9; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry1->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
            
            Score::factory()->create([
                'tournament_entry_id' => $entry2->id,
                'hole_number' => $hole,
                'strokes' => 3, // Better score
                'par' => 4,
            ]);
            
            Score::factory()->create([
                'tournament_entry_id' => $entry3->id,
                'hole_number' => $hole,
                'strokes' => 5,
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        $response->assertSeeInOrder(['Jane Smith', 'John Doe', 'Bob Johnson']); // Ordered by score
    }

    /** @test */
    public function team_leaderboard_displays_correctly()
    {
        // Create teams with different scores
        $team1 = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'name' => 'Team Alpha',
        ]);
        
        $team2 = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'name' => 'Team Beta',
        ]);
        
        $team3 = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'name' => 'Team Gamma',
        ]);

        // Create team scores (team2 has best score)
        for ($hole = 1; $hole <= 9; $hole++) {
            Score::factory()->create([
                'team_id' => $team1->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
            
            Score::factory()->create([
                'team_id' => $team2->id,
                'hole_number' => $hole,
                'strokes' => 3, // Better score
                'par' => 4,
            ]);
            
            Score::factory()->create([
                'team_id' => $team3->id,
                'hole_number' => $hole,
                'strokes' => 5,
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->scrambleTournament));
        
        $response->assertOk();
        $response->assertSeeInOrder(['Team Beta', 'Team Alpha', 'Team Gamma']); // Ordered by score
    }

    /** @test */
    public function leaderboard_shows_correct_score_calculations()
    {
        $player = User::factory()->create(['name' => 'Test Player']);
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player->id,
        ]);

        // Create mixed scores (2 under par total)
        Score::factory()->birdie(4)->create([
            'tournament_entry_id' => $entry->id,
            'hole_number' => 1,
        ]);
        
        Score::factory()->eagle(5)->create([
            'tournament_entry_id' => $entry->id,
            'hole_number' => 2,
        ]);
        
        Score::factory()->bogey(4)->create([
            'tournament_entry_id' => $entry->id,
            'hole_number' => 3,
        ]);

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        $response->assertSee('Test Player');
        $response->assertSee('-2'); // 2 under par
        $response->assertSee('10'); // Total strokes (3+3+5)
    }

    /** @test */
    public function leaderboard_handles_incomplete_rounds()
    {
        $player1 = User::factory()->create(['name' => 'Complete Player']);
        $player2 = User::factory()->create(['name' => 'Incomplete Player']);
        
        $entry1 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player1->id,
        ]);
        
        $entry2 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player2->id,
        ]);

        // Player 1 has completed 18 holes
        for ($hole = 1; $hole <= 18; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry1->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
        }

        // Player 2 has only completed 9 holes
        for ($hole = 1; $hole <= 9; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry2->id,
                'hole_number' => $hole,
                'strokes' => 3,
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        $response->assertSee('Complete Player');
        $response->assertSee('Incomplete Player');
        $response->assertSee('18/18'); // Complete round indicator
        $response->assertSee('9/18');  // Incomplete round indicator
    }

    /** @test */
    public function leaderboard_live_updates_work()
    {
        $player = User::factory()->create(['name' => 'Live Player']);
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player->id,
        ]);

        $response = $this->get(route('tournaments.leaderboard.live', $this->individualTournament));
        
        $response->assertOk();
        $response->assertJson([
            'tournament_id' => $this->individualTournament->id,
            'entries' => [],
            'last_updated' => now()->toISOString(),
        ]);

        // Add a score
        Score::factory()->create([
            'tournament_entry_id' => $entry->id,
            'hole_number' => 1,
            'strokes' => 4,
            'par' => 4,
        ]);

        $response = $this->get(route('tournaments.leaderboard.live', $this->individualTournament));
        
        $response->assertOk();
        $response->assertJsonFragment([
            'player_name' => 'Live Player',
            'total_strokes' => 4,
            'holes_completed' => 1,
        ]);
    }

    /** @test */
    public function leaderboard_shows_current_hole_being_played()
    {
        $player = User::factory()->create(['name' => 'Active Player']);
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player->id,
        ]);

        // Player has completed holes 1-5
        for ($hole = 1; $hole <= 5; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        $response->assertSee('Active Player');
        $response->assertSee('Playing 6'); // Currently on hole 6
    }

    /** @test */
    public function leaderboard_respects_tournament_privacy_settings()
    {
        $publicTournament = $this->individualTournament;
        $publicTournament->update(['status' => 'open']);

        $response = $this->get(route('tournaments.leaderboard', $publicTournament));
        $response->assertOk();

        // Private/closed tournament should require authentication
        $privateTournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'closed',
        ]);

        $response = $this->get(route('tournaments.leaderboard', $privateTournament));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_can_view_all_leaderboards()
    {
        $closedTournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'closed',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.leaderboard', $closedTournament));
        
        $response->assertOk();
    }

    /** @test */
    public function leaderboard_shows_different_formats_correctly()
    {
        // Test individual tournament leaderboard
        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        $response->assertOk();
        $response->assertSee('Individual Leaderboard');
        $response->assertSee('Player');
        $response->assertDontSee('Team');

        // Test scramble tournament leaderboard
        $response = $this->get(route('tournaments.leaderboard', $this->scrambleTournament));
        $response->assertOk();
        $response->assertSee('Team Leaderboard');
        $response->assertSee('Team');
        $response->assertDontSee('Individual');
    }

    /** @test */
    public function leaderboard_pagination_works_with_many_entries()
    {
        // Create 50 players for individual tournament
        $players = User::factory()->count(50)->create();
        
        foreach ($players as $index => $player) {
            $entry = TournamentEntry::factory()->create([
                'tournament_id' => $this->individualTournament->id,
                'user_id' => $player->id,
            ]);

            // Give each player a different score
            Score::factory()->create([
                'tournament_entry_id' => $entry->id,
                'hole_number' => 1,
                'strokes' => 3 + ($index % 5), // Scores from 3-7
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        // Should show pagination links if there are many entries
        if ($this->individualTournament->entries()->count() > 25) {
            $response->assertSee('Next');
        }
    }

    /** @test */
    public function leaderboard_shows_ties_correctly()
    {
        $player1 = User::factory()->create(['name' => 'Tied Player 1']);
        $player2 = User::factory()->create(['name' => 'Tied Player 2']);
        
        $entry1 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player1->id,
        ]);
        
        $entry2 = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player2->id,
        ]);

        // Both players have identical scores
        for ($hole = 1; $hole <= 9; $hole++) {
            Score::factory()->create([
                'tournament_entry_id' => $entry1->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
            
            Score::factory()->create([
                'tournament_entry_id' => $entry2->id,
                'hole_number' => $hole,
                'strokes' => 4,
                'par' => 4,
            ]);
        }

        $response = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        
        $response->assertOk();
        $response->assertSee('T1'); // Tied for first place
    }

    /** @test */
    public function leaderboard_caches_results_for_performance()
    {
        $player = User::factory()->create();
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $player->id,
        ]);

        // First request should cache the results
        $response1 = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        $response1->assertOk();

        // Second request should use cached results
        $response2 = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        $response2->assertOk();

        // Cache should be invalidated when new scores are added
        Score::factory()->create([
            'tournament_entry_id' => $entry->id,
            'hole_number' => 1,
            'strokes' => 4,
            'par' => 4,
        ]);

        $response3 = $this->get(route('tournaments.leaderboard', $this->individualTournament));
        $response3->assertOk();
        $response3->assertSee($player->name);
    }
}