<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $captain;
    protected User $player1;
    protected User $player2;
    protected User $player3;
    protected Tournament $scrambleTournament;
    protected Tournament $individualTournament;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create();
        $this->captain = User::factory()->create(['email' => 'captain@test.com']);
        $this->player1 = User::factory()->create(['email' => 'player1@test.com']);
        $this->player2 = User::factory()->create(['email' => 'player2@test.com']);
        $this->player3 = User::factory()->create(['email' => 'player3@test.com']);
        
        $course = Course::factory()->withHoles()->create();
        
        $this->scrambleTournament = Tournament::factory()->scramble()->create([
            'course_id' => $course->id,
            'course_tee_id' => $course->tees()->first()->id,
            'status' => 'open',
            'team_size' => 4,
        ]);
        
        $this->individualTournament = Tournament::factory()->individual()->create([
            'course_id' => $course->id,
            'course_tee_id' => $course->tees()->first()->id,
            'status' => 'open',
        ]);
    }

    /** @test */
    public function user_can_register_for_individual_tournament()
    {
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.register', $this->individualTournament), [
                'handicap' => 12,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tournament_entries', [
            'tournament_id' => $this->individualTournament->id,
            'user_id' => $this->captain->id,
            'handicap' => 12,
        ]);
    }

    /** @test */
    public function user_can_create_team_for_scramble_tournament()
    {
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.teams.store', $this->scrambleTournament), [
                'name' => 'Team Golf Masters',
                'description' => 'Best team ever',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('teams', [
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
            'name' => 'Team Golf Masters',
        ]);
    }

    /** @test */
    public function team_captain_is_automatically_added_as_member()
    {
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.teams.store', $this->scrambleTournament), [
                'name' => 'Team Golf Masters',
                'description' => 'Best team ever',
            ]);

        $team = Team::where('captain_id', $this->captain->id)->first();
        
        $this->assertTrue($team->hasMember($this->captain));
        $this->assertEquals(1, $team->getMemberCount());
    }

    /** @test */
    public function captain_can_add_members_to_team()
    {
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);
        
        // Add captain as member first
        $team->members()->attach($this->captain->id, ['handicap' => 10]);

        $response = $this->actingAs($this->captain)
            ->post(route('teams.members.store', $team), [
                'user_id' => $this->player1->id,
                'handicap' => 15,
            ]);

        $response->assertRedirect();
        $this->assertTrue($team->hasMember($this->player1));
        $this->assertEquals(15, $team->members()->where('users.id', $this->player1->id)->first()->pivot->handicap);
    }

    /** @test */
    public function team_cannot_exceed_tournament_team_size()
    {
        $team = Team::factory()->withMembers(4)->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);

        $response = $this->actingAs($this->captain)
            ->post(route('teams.members.store', $team), [
                'user_id' => $this->player3->id,
                'handicap' => 20,
            ]);

        $response->assertSessionHasErrors();
        $this->assertFalse($team->fresh()->hasMember($this->player3));
    }

    /** @test */
    public function user_cannot_join_multiple_teams_in_same_tournament()
    {
        $team1 = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);
        
        $team2 = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->player2->id,
        ]);

        // Add player1 to team1
        $team1->members()->attach($this->player1->id, ['handicap' => 12]);

        // Try to add player1 to team2 (should fail)
        $response = $this->actingAs($this->player2)
            ->post(route('teams.members.store', $team2), [
                'user_id' => $this->player1->id,
                'handicap' => 12,
            ]);

        $response->assertSessionHasErrors();
        $this->assertFalse($team2->fresh()->hasMember($this->player1));
    }

    /** @test */
    public function only_team_captain_can_manage_team_members()
    {
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);

        // Regular team member tries to add someone
        $response = $this->actingAs($this->player1)
            ->post(route('teams.members.store', $team), [
                'user_id' => $this->player2->id,
                'handicap' => 15,
            ]);

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_manage_any_team()
    {
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('teams.members.store', $team), [
                'user_id' => $this->player1->id,
                'handicap' => 15,
            ]);

        $response->assertRedirect();
        $this->assertTrue($team->fresh()->hasMember($this->player1));
    }

    /** @test */
    public function captain_can_remove_team_members()
    {
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);
        
        $team->members()->attach($this->captain->id, ['handicap' => 10]);
        $team->members()->attach($this->player1->id, ['handicap' => 15]);

        $response = $this->actingAs($this->captain)
            ->delete(route('teams.members.destroy', [$team, $this->player1]));

        $response->assertRedirect();
        $this->assertFalse($team->fresh()->hasMember($this->player1));
    }

    /** @test */
    public function captain_cannot_remove_themselves_from_team()
    {
        $team = Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
        ]);
        
        $team->members()->attach($this->captain->id, ['handicap' => 10]);

        $response = $this->actingAs($this->captain)
            ->delete(route('teams.members.destroy', [$team, $this->captain]));

        $response->assertSessionHasErrors();
        $this->assertTrue($team->fresh()->hasMember($this->captain));
    }

    /** @test */
    public function team_registration_creates_correct_database_entries()
    {
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.teams.store', $this->scrambleTournament), [
                'name' => 'Team Golf Masters',
                'description' => 'Best team ever',
            ]);

        $team = Team::where('captain_id', $this->captain->id)->first();
        
        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'tournament_id' => $this->scrambleTournament->id,
            'captain_id' => $this->captain->id,
            'name' => 'Team Golf Masters',
            'checked_in' => false,
            'entry_fee_paid' => 0,
        ]);
        
        $this->assertDatabaseHas('team_members', [
            'team_id' => $team->id,
            'user_id' => $this->captain->id,
        ]);
    }

    /** @test */
    public function team_names_must_be_unique_within_tournament()
    {
        Team::factory()->create([
            'tournament_id' => $this->scrambleTournament->id,
            'name' => 'Team Golf Masters',
        ]);

        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.teams.store', $this->scrambleTournament), [
                'name' => 'Team Golf Masters', // Duplicate name
                'description' => 'Another team',
            ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function users_can_view_tournament_teams()
    {
        $team = Team::factory()->withMembers(3)->create([
            'tournament_id' => $this->scrambleTournament->id,
            'name' => 'Visible Team',
        ]);

        $response = $this->actingAs($this->captain)
            ->get(route('tournaments.teams.index', $this->scrambleTournament));

        $response->assertOk();
        $response->assertSee('Visible Team');
    }

    /** @test */
    public function registration_closes_when_tournament_is_full()
    {
        // Set max participants to 4 (1 team of 4)
        $this->scrambleTournament->update(['max_participants' => 4]);
        
        // Create a full team
        Team::factory()->withMembers(4)->create([
            'tournament_id' => $this->scrambleTournament->id,
        ]);

        // Try to register another team
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.teams.store', $this->scrambleTournament), [
                'name' => 'Full Tournament Team',
            ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function handicap_validation_works_correctly()
    {
        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.register', $this->individualTournament), [
                'handicap' => 50, // Invalid handicap (too high)
            ]);

        $response->assertSessionHasErrors(['handicap']);

        $response = $this->actingAs($this->captain)
            ->post(route('tournaments.register', $this->individualTournament), [
                'handicap' => -5, // Invalid handicap (negative)
            ]);

        $response->assertSessionHasErrors(['handicap']);
    }
}