<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Team',
            'captain_id' => User::factory(),
            'tournament_id' => Tournament::factory(),
            'description' => fake()->optional()->sentence(),
            'entry_fee_paid' => fake()->randomFloat(2, 0, 500),
            'checked_in' => fake()->boolean(20), // 20% chance of being checked in
            'registered_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Mark the team as checked in.
     */
    public function checkedIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'checked_in' => true,
        ]);
    }

    /**
     * Mark the team as not checked in.
     */
    public function notCheckedIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'checked_in' => false,
        ]);
    }

    /**
     * Set the team as having paid entry fee.
     */
    public function paid(): static
    {
        return $this->state(function (array $attributes) {
            $tournament = Tournament::find($attributes['tournament_id']) ?? Tournament::factory()->create();
            return [
                'entry_fee_paid' => $tournament->entry_fee,
            ];
        });
    }

    /**
     * Create team with members.
     */
    public function withMembers(int $count = 4): static
    {
        return $this->afterCreating(function (\App\Models\Team $team) use ($count) {
            $members = User::factory()->count($count - 1)->create(); // -1 because captain is already a member
            
            // Add captain as member
            $team->members()->attach($team->captain_id, [
                'handicap' => fake()->numberBetween(0, 36)
            ]);
            
            // Add other members
            foreach ($members as $member) {
                $team->members()->attach($member->id, [
                    'handicap' => fake()->numberBetween(0, 36)
                ]);
            }
        });
    }
}