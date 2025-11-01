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

class MobileScoringTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $player;
    protected User $teamCaptain;
    protected Tournament $individualTournament;
    protected Tournament $scrambleTournament;
    protected TournamentEntry $entry;
    protected Team $team;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create();
        $this->player = User::factory()->create(['email' => 'player@test.com']);
        $this->teamCaptain = User::factory()->create(['email' => 'captain@test.com']);
        
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
        
        $this->entry = TournamentEntry::factory()->create([
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $this->player->id,
            'handicap' => 12,
        ]);
        
        $this->team = Team::factory()->withMembers(4)->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->teamCaptain->id,
        ]);
    }

    /** @test */
    public function player_can_access_mobile_scoring_via_qr_code()
    {
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee($this->player->name);
        $response->assertSee($this->individualTournament->name);
        $response->assertSee('Mobile Scoring');
    }

    /** @test */
    public function team_captain_can_access_team_scoring_via_qr_code()
    {
        $qrToken = 'team-' . $this->team->id . '-' . hash('sha256', 'team-' . $this->team->id . $this->team->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee($this->team->name);
        $response->assertSee($this->scrambleTournament->name);
        $response->assertSee('Team Scoring');
    }

    /** @test */
    public function invalid_qr_token_is_rejected()
    {
        $response = $this->get(route('mobile.scoring', ['token' => 'invalid-token']));
        
        $response->assertStatus(404);
    }

    /** @test */
    public function player_can_enter_score_for_hole()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 4,
            'par' => $hole->par,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('scores', [
            'tournament_entry_id' => $this->entry->id,
            'hole_number' => 1,
            'strokes' => 4,
            'par' => $hole->par,
        ]);
    }

    /** @test */
    public function team_member_can_enter_team_score()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $qrToken = 'team-' . $this->team->id . '-' . hash('sha256', 'team-' . $this->team->id . $this->team->tournament_id);
        
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 3,
            'par' => $hole->par,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('scores', [
            'team_id' => $this->team->id,
            'hole_number' => 1,
            'strokes' => 3,
            'par' => $hole->par,
        ]);
    }

    /** @test */
    public function player_can_update_existing_score()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $score = Score::factory()->create([
            'tournament_entry_id' => $this->entry->id,
            'hole_number' => 1,
            'strokes' => 5,
            'par' => $hole->par,
        ]);
        
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 4,
            'par' => $hole->par,
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('scores', [
            'id' => $score->id,
            'strokes' => 4,
        ]);
    }

    /** @test */
    public function score_validation_works_correctly()
    {
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        // Test invalid hole number
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 25, // Invalid hole number
            'strokes' => 4,
            'par' => 4,
        ]);
        
        $response->assertSessionHasErrors(['hole_number']);
        
        // Test invalid strokes
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 0, // Invalid strokes
            'par' => 4,
        ]);
        
        $response->assertSessionHasErrors(['strokes']);
    }

    /** @test */
    public function mobile_scoring_displays_current_scores()
    {
        Score::factory()->count(9)->create([
            'tournament_entry_id' => $this->entry->id,
        ]);
        
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee('9'); // Should show completed holes count
    }

    /** @test */
    public function player_can_add_notes_to_score()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 4,
            'par' => $hole->par,
            'notes' => 'Great approach shot',
        ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('scores', [
            'tournament_entry_id' => $this->entry->id,
            'hole_number' => 1,
            'notes' => 'Great approach shot',
        ]);
    }

    /** @test */
    public function mobile_interface_shows_hole_information()
    {
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        
        // Should show hole information
        foreach ($this->course->holes as $hole) {
            $response->assertSee("Hole {$hole->hole_number}");
            $response->assertSee("Par {$hole->par}");
        }
    }

    /** @test */
    public function mobile_scoring_calculates_running_totals()
    {
        // Create scores for first 9 holes
        for ($i = 1; $i <= 9; $i++) {
            Score::factory()->create([
                'tournament_entry_id' => $this->entry->id,
                'hole_number' => $i,
                'strokes' => 4,
                'par' => 4,
            ]);
        }
        
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee('36'); // Total strokes for 9 holes
        $response->assertSee('Even'); // Even par
    }

    /** @test */
    public function team_scoring_shows_all_team_members()
    {
        $qrToken = 'team-' . $this->team->id . '-' . hash('sha256', 'team-' . $this->team->id . $this->team->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        
        // Should show all team members
        foreach ($this->team->members as $member) {
            $response->assertSee($member->name);
        }
    }

    /** @test */
    public function mobile_scoring_works_offline_with_form_caching()
    {
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        
        // Check that the page includes offline capabilities
        $response->assertSee('service-worker'); // Service worker registration
        $response->assertSee('cache'); // Caching capabilities
    }

    /** @test */
    public function score_submission_provides_immediate_feedback()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->post(route('mobile.score.store', ['token' => $qrToken]), [
            'hole_number' => 1,
            'strokes' => 3, // Birdie on par 4
            'par' => 4,
        ]);
        
        $response->assertSessionHas('success');
        $response->assertRedirect();
        
        // Follow redirect to see the updated page
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        $response->assertSee('Birdie'); // Should show score description
    }

    /** @test */
    public function admin_can_edit_any_score_via_mobile()
    {
        $hole = $this->course->holes()->where('hole_number', 1)->first();
        $score = Score::factory()->create([
            'tournament_entry_id' => $this->entry->id,
            'hole_number' => 1,
            'strokes' => 5,
            'par' => $hole->par,
        ]);
        
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->actingAs($this->admin)
            ->post(route('mobile.score.store', ['token' => $qrToken]), [
                'hole_number' => 1,
                'strokes' => 4,
                'par' => $hole->par,
            ]);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('scores', [
            'id' => $score->id,
            'strokes' => 4,
        ]);
    }

    /** @test */
    public function mobile_scoring_handles_different_course_tees()
    {
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee($this->individualTournament->courseTee->name);
        
        // Should show yardages from the selected tee
        foreach ($this->course->holes as $hole) {
            $yardage = $hole->getYardageForTee($this->individualTournament->courseTee);
            if ($yardage) {
                $response->assertSee($yardage . ' yds');
            }
        }
    }

    /** @test */
    public function completed_tournament_scores_are_read_only()
    {
        $this->individualTournament->update(['status' => 'completed']);
        
        $qrToken = $this->entry->id . '-' . hash('sha256', $this->entry->id . $this->entry->tournament_id);
        
        $response = $this->get(route('mobile.scoring', ['token' => $qrToken]));
        
        $response->assertOk();
        $response->assertSee('Tournament Complete');
        $response->assertDontSee('Submit Score'); // No score submission form
    }
}