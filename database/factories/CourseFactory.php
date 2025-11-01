<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company() . ' Golf Course',
            'description' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'zip_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->optional()->url(),
            'hole_count' => fake()->randomElement([9, 18]),
            'par' => function (array $attributes) {
                return $attributes['hole_count'] === 18 ? fake()->numberBetween(70, 74) : fake()->numberBetween(35, 37);
            },
            'yardage' => function (array $attributes) {
                return $attributes['hole_count'] === 18 ? fake()->numberBetween(6000, 7200) : fake()->numberBetween(3000, 3600);
            },
            'active' => true,
        ];
    }

    /**
     * Create course with 18 holes.
     */
    public function eighteenHoles(): static
    {
        return $this->state(fn (array $attributes) => [
            'hole_count' => 18,
            'par' => fake()->numberBetween(70, 74),
            'yardage' => fake()->numberBetween(6000, 7200),
        ]);
    }

    /**
     * Create course with 9 holes.
     */
    public function nineHoles(): static
    {
        return $this->state(fn (array $attributes) => [
            'hole_count' => 9,
            'par' => fake()->numberBetween(35, 37),
            'yardage' => fake()->numberBetween(3000, 3600),
        ]);
    }

    /**
     * Create the course with holes and tees.
     */
    public function withHoles(): static
    {
        return $this->afterCreating(function (\App\Models\Course $course) {
            // Create holes
            for ($i = 1; $i <= $course->hole_count; $i++) {
                \App\Models\CourseHole::factory()->create([
                    'course_id' => $course->id,
                    'hole_number' => $i,
                ]);
            }

            // Create tees
            $tees = [
                ['name' => 'Championship', 'color' => 'Black', 'rating' => 74.2, 'slope' => 135],
                ['name' => 'Blue', 'color' => 'Blue', 'rating' => 72.1, 'slope' => 125],
                ['name' => 'White', 'color' => 'White', 'rating' => 69.8, 'slope' => 115],
                ['name' => 'Red', 'color' => 'Red', 'rating' => 67.5, 'slope' => 110],
            ];

            foreach ($tees as $teeData) {
                $tee = \App\Models\CourseTee::factory()->create([
                    'course_id' => $course->id,
                    'name' => $teeData['name'],
                    'color' => $teeData['color'],
                    'rating' => $teeData['rating'],
                    'slope' => $teeData['slope'],
                ]);

                // Create yardages for each hole from this tee
                foreach ($course->holes as $hole) {
                    \App\Models\CourseHoleTeeYardage::factory()->create([
                        'course_hole_id' => $hole->id,
                        'course_tee_id' => $tee->id,
                        'yardage' => fake()->numberBetween(100, 600),
                    ]);
                }
            }
        });
    }
}