<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TournamentEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $par = fake()->randomElement([3, 4, 5]);
        
        return [
            'tournament_entry_id' => TournamentEntry::factory(),
            'team_id' => null,
            'hole_number' => fake()->numberBetween(1, 18),
            'strokes' => fake()->numberBetween($par - 2, $par + 4), // Eagle to triple bogey
            'par' => $par,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Create score for a team.
     */
    public function forTeam(): static
    {
        return $this->state(fn (array $attributes) => [
            'tournament_entry_id' => null,
            'team_id' => Team::factory(),
        ]);
    }

    /**
     * Create score for an individual entry.
     */
    public function forIndividual(): static
    {
        return $this->state(fn (array $attributes) => [
            'tournament_entry_id' => TournamentEntry::factory(),
            'team_id' => null,
        ]);
    }

    /**
     * Create a birdie score.
     */
    public function birdie(int $par = 4): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => $par,
            'strokes' => $par - 1,
        ]);
    }

    /**
     * Create an eagle score.
     */
    public function eagle(int $par = 5): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => $par,
            'strokes' => $par - 2,
        ]);
    }

    /**
     * Create a par score.
     */
    public function par(int $par = 4): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => $par,
            'strokes' => $par,
        ]);
    }

    /**
     * Create a bogey score.
     */
    public function bogey(int $par = 4): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => $par,
            'strokes' => $par + 1,
        ]);
    }
}