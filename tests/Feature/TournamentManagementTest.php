<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TournamentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;
    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create([
            'email' => 'admin@test.com'
        ]);
        
        $this->regularUser = User::factory()->create([
            'email' => 'user@test.com'
        ]);
        
        $this->course = Course::factory()->withHoles()->create();
    }

    /** @test */
    public function admin_can_view_tournaments_index()
    {
        $tournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.index'));

        $response->assertOk();
        $response->assertSee($tournament->name);
    }

    /** @test */
    public function regular_user_cannot_access_tournament_management()
    {
        $response = $this->actingAs($this->regularUser)
            ->get(route('tournaments.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_create_individual_tournament()
    {
        $tee = $this->course->tees()->first();
        
        $tournamentData = [
            'name' => 'Spring Individual Championship',
            'description' => 'Annual spring tournament',
            'start_date' => now()->addDays(30)->toDateString(),
            'end_date' => now()->addDays(30)->toDateString(),
            'holes' => 18,
            'format' => 'individual',
            'team_size' => 1,
            'entry_fee' => 75.00,
            'max_participants' => 50,
            'status' => 'open',
            'course_id' => $this->course->id,
            'course_tee_id' => $tee->id,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.store'), $tournamentData);

        $response->assertRedirect(route('tournaments.index'));
        $this->assertDatabaseHas('tournaments', [
            'name' => 'Spring Individual Championship',
            'format' => 'individual',
            'team_size' => 1,
        ]);
    }

    /** @test */
    public function admin_can_create_scramble_tournament()
    {
        $tee = $this->course->tees()->first();
        
        $tournamentData = [
            'name' => 'Summer Scramble',
            'description' => 'Four-person scramble tournament',
            'start_date' => now()->addDays(45)->toDateString(),
            'end_date' => now()->addDays(45)->toDateString(),
            'holes' => 18,
            'format' => 'scramble',
            'team_size' => 4,
            'entry_fee' => 300.00,
            'max_participants' => 80,
            'status' => 'open',
            'course_id' => $this->course->id,
            'course_tee_id' => $tee->id,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.store'), $tournamentData);

        $response->assertRedirect(route('tournaments.index'));
        $this->assertDatabaseHas('tournaments', [
            'name' => 'Summer Scramble',
            'format' => 'scramble',
            'team_size' => 4,
        ]);
    }

    /** @test */
    public function tournament_validation_works_correctly()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.store'), [
                'name' => '', // Missing required field
                'format' => 'invalid_format', // Invalid format
                'team_size' => 10, // Too large
                'entry_fee' => -50, // Negative fee
            ]);

        $response->assertSessionHasErrors([
            'name',
            'format', 
            'team_size',
            'entry_fee'
        ]);
    }

    /** @test */
    public function admin_can_update_tournament()
    {
        $tournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
        ]);

        $updateData = [
            'name' => 'Updated Tournament Name',
            'description' => 'Updated description',
            'start_date' => $tournament->start_date->toDateString(),
            'end_date' => $tournament->end_date->toDateString(),
            'holes' => $tournament->holes,
            'format' => $tournament->format,
            'team_size' => $tournament->team_size,
            'entry_fee' => 100.00,
            'max_participants' => $tournament->max_participants,
            'status' => $tournament->status,
            'course_id' => $tournament->course_id,
            'course_tee_id' => $tournament->course_tee_id,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('tournaments.update', $tournament), $updateData);

        $response->assertRedirect(route('tournaments.index'));
        $this->assertDatabaseHas('tournaments', [
            'id' => $tournament->id,
            'name' => 'Updated Tournament Name',
            'entry_fee' => 100.00,
        ]);
    }

    /** @test */
    public function admin_can_delete_tournament()
    {
        $tournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('tournaments.destroy', $tournament));

        $response->assertRedirect(route('tournaments.index'));
        $this->assertDatabaseMissing('tournaments', [
            'id' => $tournament->id
        ]);
    }

    /** @test */
    public function admin_can_view_tournament_details()
    {
        $tournament = Tournament::factory()->create([
            'course_id' => $this->course->id,
            'course_tee_id' => $this->course->tees()->first()->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('tournaments.show', $tournament));

        $response->assertOk();
        $response->assertSee($tournament->name);
        $response->assertSee($tournament->description);
    }

    /** @test */
    public function tournament_format_determines_valid_team_size()
    {
        $tee = $this->course->tees()->first();
        
        // Individual tournament with team_size > 1 should fail
        $response = $this->actingAs($this->admin)
            ->post(route('tournaments.store'), [
                'name' => 'Test Tournament',
                'description' => 'Test',
                'start_date' => now()->addDays(30)->toDateString(),
                'end_date' => now()->addDays(30)->toDateString(),
                'holes' => 18,
                'format' => 'individual',
                'team_size' => 4, // Invalid for individual
                'entry_fee' => 75.00,
                'max_participants' => 50,
                'status' => 'open',
                'course_id' => $this->course->id,
                'course_tee_id' => $tee->id,
            ]);

        $response->assertSessionHasErrors(['team_size']);
    }

    /** @test */
    public function guest_cannot_access_tournament_management()
    {
        $response = $this->get(route('tournaments.index'));
        $response->assertRedirect(route('login'));
    }
}