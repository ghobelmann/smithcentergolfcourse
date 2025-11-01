<?php

namespace Database\Factories;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TournamentEntry>
 */
class TournamentEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tournament_id' => Tournament::factory(),
            'user_id' => User::factory(),
            'handicap' => fake()->numberBetween(0, 36),
            'entry_fee_paid' => fake()->randomFloat(2, 0, 200),
            'checked_in' => fake()->boolean(20), // 20% chance of being checked in
            'registered_at' => fake()->dateTimeBetween('-1 month', 'now'),
            'starting_hole' => fake()->optional()->numberBetween(1, 18),
            'group_letter' => fake()->optional()->randomElement(['A', 'B']),
            'card_order' => fake()->optional()->numberBetween(1, 4),
        ];
    }

    /**
     * Mark the entry as checked in.
     */
    public function checkedIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'checked_in' => true,
        ]);
    }

    /**
     * Mark the entry as not checked in.
     */
    public function notCheckedIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'checked_in' => false,
        ]);
    }

    /**
     * Set the entry as having paid full entry fee.
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
     * Assign card information.
     */
    public function withCard(int $startingHole = 1, string $groupLetter = 'A', int $cardOrder = 1): static
    {
        return $this->state(fn (array $attributes) => [
            'starting_hole' => $startingHole,
            'group_letter' => $groupLetter,
            'card_order' => $cardOrder,
        ]);
    }
}