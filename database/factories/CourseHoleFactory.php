<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseHole>
 */
class CourseHoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'hole_number' => fake()->numberBetween(1, 18),
            'par' => fake()->randomElement([3, 4, 5]),
            'handicap' => fake()->numberBetween(1, 18),
            'name' => fake()->optional()->words(2, true),
        ];
    }

    /**
     * Create a par 3 hole.
     */
    public function par3(): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => 3,
        ]);
    }

    /**
     * Create a par 4 hole.
     */
    public function par4(): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => 4,
        ]);
    }

    /**
     * Create a par 5 hole.
     */
    public function par5(): static
    {
        return $this->state(fn (array $attributes) => [
            'par' => 5,
        ]);
    }
}