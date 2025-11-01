<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseHole;
use App\Models\CourseTee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $regularUser;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->admin()->create([
            'email' => 'admin@test.com'
        ]);
        
        $this->regularUser = User::factory()->create([
            'email' => 'user@test.com'
        ]);
    }

    /** @test */
    public function admin_can_view_courses_index()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('courses.index'));

        $response->assertOk();
        $response->assertSee($course->name);
    }

    /** @test */
    public function regular_user_cannot_access_course_management()
    {
        $response = $this->actingAs($this->regularUser)
            ->get(route('courses.index'));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_create_course()
    {
        $courseData = [
            'name' => 'Pine Valley Golf Course',
            'description' => 'Championship golf course',
            'address' => '123 Golf Lane',
            'city' => 'Augusta',
            'state' => 'GA',
            'zip_code' => '30901',
            'phone' => '(706) 555-0123',
            'website' => 'https://pinevalley.com',
            'hole_count' => 18,
            'par' => 72,
            'yardage' => 6800,
            'active' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('courses.store'), $courseData);

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', [
            'name' => 'Pine Valley Golf Course',
            'hole_count' => 18,
            'par' => 72,
        ]);
    }

    /** @test */
    public function course_validation_works_correctly()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('courses.store'), [
                'name' => '', // Missing required field
                'hole_count' => 25, // Invalid hole count
                'par' => -5, // Invalid par
            ]);

        $response->assertSessionHasErrors([
            'name',
            'hole_count',
            'par'
        ]);
    }

    /** @test */
    public function admin_can_update_course()
    {
        $course = Course::factory()->create();

        $updateData = [
            'name' => 'Updated Course Name',
            'description' => 'Updated description',
            'address' => $course->address,
            'city' => $course->city,
            'state' => $course->state,
            'zip_code' => $course->zip_code,
            'phone' => $course->phone,
            'website' => $course->website,
            'hole_count' => $course->hole_count,
            'par' => 73,
            'yardage' => 7000,
            'active' => $course->active,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('courses.update', $course), $updateData);

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Updated Course Name',
            'par' => 73,
            'yardage' => 7000,
        ]);
    }

    /** @test */
    public function admin_can_setup_course_with_holes_and_tees()
    {
        $course = Course::factory()->create(['hole_count' => 18]);

        $setupData = [
            'hole_count' => 18,
            'new_tees' => [
                [
                    'name' => 'Championship',
                    'color' => 'Black',
                    'rating' => 74.2,
                    'slope' => 135,
                    'gender' => 'men',
                ],
                [
                    'name' => 'Blue',
                    'color' => 'Blue',
                    'rating' => 72.1,
                    'slope' => 125,
                    'gender' => 'men',
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('courses.setup', $course), $setupData);

        $response->assertRedirect(route('courses.index'));
        
        // Check that holes were created
        $this->assertEquals(18, $course->holes()->count());
        
        // Check that tees were created
        $this->assertDatabaseHas('course_tees', [
            'course_id' => $course->id,
            'name' => 'Championship',
            'color' => 'Black',
        ]);
        
        $this->assertDatabaseHas('course_tees', [
            'course_id' => $course->id,
            'name' => 'Blue',
            'color' => 'Blue',
        ]);
    }

    /** @test */
    public function admin_can_view_course_setup_page()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('courses.setup', $course));

        $response->assertOk();
        $response->assertSee($course->name);
        $response->assertSee('Course Setup');
    }

    /** @test */
    public function course_setup_creates_holes_based_on_hole_count()
    {
        $course = Course::factory()->create(['hole_count' => 9]);

        $setupData = [
            'hole_count' => 9,
            'new_tees' => [
                [
                    'name' => 'White',
                    'color' => 'White',
                    'rating' => 69.8,
                    'slope' => 115,
                    'gender' => 'mixed',
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('courses.setup', $course), $setupData);

        $response->assertRedirect(route('courses.index'));
        
        // Should create exactly 9 holes
        $this->assertEquals(9, $course->holes()->count());
        
        // Holes should be numbered 1-9
        for ($i = 1; $i <= 9; $i++) {
            $this->assertDatabaseHas('course_holes', [
                'course_id' => $course->id,
                'hole_number' => $i,
            ]);
        }
    }

    /** @test */
    public function tee_validation_works_correctly()
    {
        $course = Course::factory()->create();

        $setupData = [
            'hole_count' => 18,
            'new_tees' => [
                [
                    'name' => '', // Missing name
                    'rating' => 85.0, // Invalid rating
                    'slope' => 200, // Invalid slope
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('courses.setup', $course), $setupData);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function admin_can_delete_course()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'));
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id
        ]);
    }

    /** @test */
    public function deleting_course_cascades_to_holes_and_tees()
    {
        $course = Course::factory()->withHoles()->create();
        $hole = $course->holes()->first();
        $tee = $course->tees()->first();

        $response = $this->actingAs($this->admin)
            ->delete(route('courses.destroy', $course));

        $response->assertRedirect(route('courses.index'));
        
        // Course, holes, and tees should all be deleted
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
        $this->assertDatabaseMissing('course_holes', ['id' => $hole->id]);
        $this->assertDatabaseMissing('course_tees', ['id' => $tee->id]);
    }

    /** @test */
    public function admin_can_view_course_details()
    {
        $course = Course::factory()->withHoles()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('courses.show', $course));

        $response->assertOk();
        $response->assertSee($course->name);
        $response->assertSee($course->description);
    }

    /** @test */
    public function admin_can_edit_existing_course()
    {
        $course = Course::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('courses.edit', $course));

        $response->assertOk();
        $response->assertSee($course->name);
        $response->assertSee('Edit Course');
    }

    /** @test */
    public function guest_cannot_access_course_management()
    {
        $response = $this->get(route('courses.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function course_holes_are_created_with_default_values()
    {
        $course = Course::factory()->create(['hole_count' => 18]);

        $setupData = [
            'hole_count' => 18,
            'new_tees' => [
                [
                    'name' => 'Blue',
                    'color' => 'Blue',
                    'rating' => 72.1,
                    'slope' => 125,
                    'gender' => 'men',
                ],
            ],
        ];

        $this->actingAs($this->admin)
            ->post(route('courses.setup', $course), $setupData);

        // Check that holes have realistic default par values
        $holes = $course->holes;
        $totalPar = $holes->sum('par');
        
        $this->assertTrue($totalPar >= 70 && $totalPar <= 74, 'Total par should be between 70-74');
        
        // Each hole should have a par between 3-5
        foreach ($holes as $hole) {
            $this->assertTrue($hole->par >= 3 && $hole->par <= 5, 'Hole par should be 3-5');
            $this->assertTrue($hole->handicap >= 1 && $hole->handicap <= 18, 'Handicap should be 1-18');
        }
    }
}