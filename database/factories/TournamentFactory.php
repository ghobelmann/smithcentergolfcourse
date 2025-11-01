<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseTee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Golf Tournament',
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+2 months'),
            'holes' => fake()->randomElement([9, 18]),
            'format' => fake()->randomElement(['individual', 'scramble']),
            'team_size' => function (array $attributes) {
                return $attributes['format'] === 'scramble' ? fake()->numberBetween(2, 4) : 1;
            },
            'entry_fee' => fake()->randomFloat(2, 25, 150),
            'max_participants' => fake()->numberBetween(20, 100),
            'status' => fake()->randomElement(['upcoming', 'open', 'closed', 'completed']),
        ];
    }

    /**
     * Indicate that the tournament is a scramble format.
     */
    public function scramble(): static
    {
        return $this->state(fn (array $attributes) => [
            'format' => 'scramble',
            'team_size' => fake()->numberBetween(2, 4),
        ]);
    }

    /**
     * Indicate that the tournament is individual format.
     */
    public function individual(): static
    {
        return $this->state(fn (array $attributes) => [
            'format' => 'individual',
            'team_size' => 1,
        ]);
    }

    /**
     * Indicate that the tournament is 18 holes.
     */
    public function eighteenHoles(): static
    {
        return $this->state(fn (array $attributes) => [
            'holes' => 18,
        ]);
    }

    /**
     * Indicate that the tournament is 9 holes.
     */
    public function nineHoles(): static
    {
        return $this->state(fn (array $attributes) => [
            'holes' => 9,
        ]);
    }

    /**
     * Set the tournament status to open for registration.
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
        ]);
    }

    /**
     * Configure the tournament after creation to set course and tee.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (\App\Models\Tournament $tournament) {
            if (!$tournament->course_id) {
                $course = Course::factory()->withHoles()->create();
                $tee = $course->tees()->first();
                
                $tournament->update([
                    'course_id' => $course->id,
                    'course_tee_id' => $tee?->id,
                ]);
            }
        });
    }
}