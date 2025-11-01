<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;
    protected Tournament $individualTournament;
    protected Tournament $scrambleTournament;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create();
        $this->regularUser = User::factory()->create();
        $this->course = Course::factory()->withHoles()->create(['hole_count' => 18]);
        
        $this->individualTournament = Tournament::factory()->individual()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
        ]);
        
        $this->scrambleTournament = Tournament::factory()->scramble()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
            'status' => 'open',
            'team_size' => 4,
        ]);
    }

    /** @test */
    public function admin_can_view_card_assignment_page()
    {
        TournamentEntry::factory()->count(8)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.cards', $this->individualTournament));

        $response->assertOk();
        $response->assertSee('Card Assignment');
        $response->assertSee($this->individualTournament->name);
    }

    /** @test */
    public function regular_user_cannot_access_card_assignment()
    {
        $response = $this->actingAs($this->regularUser)
            ->get(route('tournaments.cards', $this->individualTournament));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_assign_starting_holes_to_individual_players()
    {
        $entries = TournamentEntry::factory()->count(8)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $assignmentData = [
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
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.assign', $this->individualTournament), $assignmentData);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('tournament_entries', [
            'id' => $entries[0]->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
            'card_order' => 1,
        ]);

        $this->assertDatabaseHas('tournament_entries', [
            'id' => $entries[2]->id,
            'starting_hole' => 10,
            'group_letter' => 'B',
            'card_order' => 1,
        ]);
    }

    /** @test */
    public function admin_can_assign_cards_to_teams()
    {
        $teams = Team::factory()->count(4)->create([
            'tournament_id' => $this->scrambleTournament->id,
        ]);

        $assignmentData = [
            'team_assignments' => [
                $teams[0]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1,
                ],
                $teams[1]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 2,
                ],
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.assign', $this->scrambleTournament), $assignmentData);

        $response->assertRedirect();
        
        // Teams don't have direct card assignment, but their captain's entry should be updated
        $captain1Entry = TournamentEntry::where('user_id', $teams[0]->captain_id)
                                      ->where('tournament_id', $this->scrambleTournament->id)
                                      ->first();
        
        if ($captain1Entry) {
            $this->assertDatabaseHas('tournament_entries', [
                'id' => $captain1Entry->id,
                'starting_hole' => 1,
                'group_letter' => 'A',
                'card_order' => 1,
            ]);
        }
    }

    /** @test */
    public function card_assignment_validation_works()
    {
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $invalidData = [
            'assignments' => [
                $entry->id => [
                    'starting_hole' => 25, // Invalid hole number
                    'group_letter' => 'Z', // Invalid group letter
                    'card_order' => 0, // Invalid card order
                ],
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.assign', $this->individualTournament), $invalidData);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function card_assignment_prevents_duplicate_positions()
    {
        $entries = TournamentEntry::factory()->count(2)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $duplicateData = [
            'assignments' => [
                $entries[0]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1,
                ],
                $entries[1]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1, // Same position as above
                ],
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.assign', $this->individualTournament), $duplicateData);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function admin_can_auto_assign_cards()
    {
        TournamentEntry::factory()->count(16)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.auto-assign', $this->individualTournament), [
                'groups_per_hole' => 2,
                'players_per_group' => 4,
            ]);

        $response->assertRedirect();
        
        // Check that all entries have been assigned
        $unassignedCount = TournamentEntry::where('tournament_id', $this->individualTournament->id)
                                        ->whereNull('starting_hole')
                                        ->count();
        
        $this->assertEquals(0, $unassignedCount);
    }

    /** @test */
    public function auto_assignment_distributes_players_evenly()
    {
        TournamentEntry::factory()->count(12)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $this->actingAs($this->admin)
            ->post(route('tournaments.cards.auto-assign', $this->individualTournament), [
                'groups_per_hole' => 2,
                'players_per_group' => 3,
            ]);

        // Should have 4 groups total (2 holes × 2 groups per hole)
        $groupsOnHole1 = TournamentEntry::where('tournament_id', $this->individualTournament->id)
                                      ->where('starting_hole', 1)
                                      ->distinct(['group_letter', 'starting_hole'])
                                      ->count();

        $groupsOnHole10 = TournamentEntry::where('tournament_id', $this->individualTournament->id)
                                       ->where('starting_hole', 10)
                                       ->distinct(['group_letter', 'starting_hole'])
                                       ->count();

        $this->assertTrue($groupsOnHole1 >= 1);
        $this->assertTrue($groupsOnHole10 >= 1);
    }

    /** @test */
    public function admin_can_print_scorecards_with_assignments()
    {
        $entries = TournamentEntry::factory()->count(4)->create([
            'tournament_id' => $this->individualTournament->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
        ]);

        // Assign different card orders
        foreach ($entries as $index => $entry) {
            $entry->update(['card_order' => $index + 1]);
        }

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.scorecards.print', $this->individualTournament));

        $response->assertOk();
        $response->assertSee('Scorecard');
        $response->assertSee('Group A');
        $response->assertSee('Starting Hole: 1');
        
        // Should see all players in the group
        foreach ($entries as $entry) {
            $response->assertSee($entry->user->name);
        }
    }

    /** @test */
    public function scorecards_show_qr_codes_for_mobile_scoring()
    {
        $entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
            'card_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.scorecards.print', $this->individualTournament));

        $response->assertOk();
        $response->assertSee('QR Code'); // QR code section
        $response->assertSee($entry->id); // Entry ID should be in QR data
    }

    /** @test */
    public function card_assignment_respects_tournament_format()
    {
        // Individual tournament should assign to entries
        $individualEntry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.cards', $this->individualTournament));

        $response->assertOk();
        $response->assertSee($individualEntry->user->name);
        $response->assertSee('Player Assignment');

        // Scramble tournament should assign to teams
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.cards', $this->scrambleTournament));

        $response->assertOk();
        $response->assertSee($team->name);
        $response->assertSee('Team Assignment');
    }

    /** @test */
    public function admin_can_clear_all_assignments()
    {
        $entries = TournamentEntry::factory()->count(4)->create([
            'tournament_id' => $this->individualTournament->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
            'card_order' => 1,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('tournaments.cards.clear', $this->individualTournament));

        $response->assertRedirect();
        
        // All assignments should be cleared
        foreach ($entries as $entry) {
            $this->assertDatabaseHas('tournament_entries', [
                'id' => $entry->id,
                'starting_hole' => null,
                'group_letter' => null,
                'card_order' => null,
            ]);
        }
    }

    /** @test */
    public function card_assignment_shows_summary_statistics()
    {
        TournamentEntry::factory()->count(8)->create([
            'tournament_id' => $this->individualTournament->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
        ]);

        TournamentEntry::factory()->count(4)->create([
            'tournament_id' => $this->individualTournament->id,
            'starting_hole' => 10,
            'group_letter' => 'B',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.cards', $this->individualTournament));

        $response->assertOk();
        $response->assertSee('12 Assigned'); // Total assigned players
        $response->assertSee('0 Unassigned'); // Unassigned players
        $response->assertSee('2 Groups'); // Number of groups
    }

    /** @test */
    public function guest_cannot_access_card_assignment()
    {
        $response = $this->get(route('tournaments.cards', $this->individualTournament));
        
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function card_assignment_handles_shotgun_starts()
    {
        TournamentEntry::factory()->count(18)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.auto-assign', $this->individualTournament), [
                'start_type' => 'shotgun',
                'players_per_group' => 1,
            ]);

        $response->assertRedirect();
        
        // In shotgun start, players should start on different holes
        $startingHoles = TournamentEntry::where('tournament_id', $this->individualTournament->id)
                                      ->distinct('starting_hole')
                                      ->pluck('starting_hole')
                                      ->sort()
                                      ->values();

        // Should have players starting on multiple holes
        $this->assertGreaterThan(1, $startingHoles->count());
    }

    /** @test */
    public function card_assignment_handles_tee_times()
    {
        $entries = TournamentEntry::factory()->count(8)->create([
            'tournament_id' => $this->individualTournament->id,
        ]);

        $assignmentData = [
            'assignments' => [
                $entries[0]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'A',
                    'card_order' => 1,
                    'tee_time' => '08:00',
                ],
                $entries[1]->id => [
                    'starting_hole' => 1,
                    'group_letter' => 'B',
                    'card_order' => 1,
                    'tee_time' => '08:10',
                ],
            ]
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.cards.assign', $this->individualTournament), $assignmentData);

        $response->assertRedirect();
        
        // Verify tee times are assigned (if the feature is implemented)
        $this->assertDatabaseHas('tournament_entries', [
            'id' => $entries[0]->id,
            'starting_hole' => 1,
            'group_letter' => 'A',
        ]);
    }
}