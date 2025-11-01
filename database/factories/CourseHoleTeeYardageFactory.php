<?php

namespace Database\Factories;

use App\Models\CourseHole;
use App\Models\CourseTee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseHoleTeeYardage>
 */
class CourseHoleTeeYardageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_hole_id' => CourseHole::factory(),
            'course_tee_id' => CourseTee::factory(),
            'yardage' => fake()->numberBetween(100, 600),
        ];
    }

    /**
     * Create yardage for a par 3 hole.
     */
    public function par3(): static
    {
        return $this->state(fn (array $attributes) => [
            'yardage' => fake()->numberBetween(100, 220),
        ]);
    }

    /**
     * Create yardage for a par 4 hole.
     */
    public function par4(): static
    {
        return $this->state(fn (array $attributes) => [
            'yardage' => fake()->numberBetween(250, 450),
        ]);
    }

    /**
     * Create yardage for a par 5 hole.
     */
    public function par5(): static
    {
        return $this->state(fn (array $attributes) => [
            'yardage' => fake()->numberBetween(450, 600),
        ]);
    }
}