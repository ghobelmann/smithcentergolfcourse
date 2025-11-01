<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseTee>
 */
class CourseTeeFactory extends Factory
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
            'name' => fake()->randomElement(['Championship', 'Blue', 'White', 'Red', 'Gold', 'Senior']),
            'color' => fake()->randomElement(['Black', 'Blue', 'White', 'Red', 'Gold', 'Green']),
            'rating' => fake()->randomFloat(1, 65.0, 76.0),
            'slope' => fake()->numberBetween(100, 155),
            'total_yardage' => fake()->numberBetween(5000, 7500),
            'gender' => fake()->randomElement(['men', 'women', 'mixed']),
        ];
    }

    /**
     * Create championship tees.
     */
    public function championship(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Championship',
            'color' => 'Black',
            'rating' => fake()->randomFloat(1, 73.0, 76.0),
            'slope' => fake()->numberBetween(130, 155),
            'total_yardage' => fake()->numberBetween(6800, 7500),
            'gender' => 'men',
        ]);
    }

    /**
     * Create men's tees.
     */
    public function mens(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Blue',
            'color' => 'Blue',
            'rating' => fake()->randomFloat(1, 70.0, 73.0),
            'slope' => fake()->numberBetween(120, 135),
            'total_yardage' => fake()->numberBetween(6200, 6800),
            'gender' => 'men',
        ]);
    }

    /**
     * Create women's tees.
     */
    public function womens(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Red',
            'color' => 'Red',
            'rating' => fake()->randomFloat(1, 65.0, 70.0),
            'slope' => fake()->numberBetween(110, 125),
            'total_yardage' => fake()->numberBetween(5000, 5800),
            'gender' => 'women',
        ]);
    }
}