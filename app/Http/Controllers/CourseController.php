<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseHole;
use App\Models\CourseTee;
use App\Models\CourseHoleTeeYardage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $courses = Course::withCount(['holes', 'tees'])
            ->where('active', true)
            ->orderBy('name')
            ->paginate(10);

        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'hole_count' => 'required|integer|min:9|max:18',
        ]);

        $course = Course::create($validated);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course created successfully! Now add holes and tees.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): View
    {
        $course->load(['holes', 'tees']);
        
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): View
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:50',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'hole_count' => 'required|integer|min:9|max:18',
            'active' => 'boolean',
        ]);

        $course->update($validated);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Setup holes and tees for a course
     */
    public function setup(Course $course): View
    {
        $course->load(['holes', 'tees.yardages']);
        
        // Ensure we have all holes
        $this->ensureHolesExist($course);
        
        $course->refresh();
        $course->load(['holes', 'tees.yardages']);
        
        return view('courses.setup', compact('course'));
    }

    /**
     * Update course setup (holes, tees, yardages)
     */
    public function updateSetup(Request $request, Course $course): RedirectResponse
    {
        $request->validate([
            'holes.*.par' => 'required|integer|min:3|max:5',
            'holes.*.handicap' => 'required|integer|min:1|max:18',
            'holes.*.name' => 'nullable|string|max:100',
            'tees.*.name' => 'required|string|max:100',
            'tees.*.color' => 'nullable|string|max:50',
            'tees.*.course_rating' => 'nullable|numeric|min:50|max:80',
            'tees.*.slope_rating' => 'nullable|integer|min:55|max:155',
            'tees.*.total_yardage' => 'nullable|integer|min:1000|max:8000',
            'tees.*.gender' => 'required|in:men,women,mixed',
            'new_tees.*.name' => 'required|string|max:100',
            'new_tees.*.color' => 'nullable|string|max:50',
            'new_tees.*.course_rating' => 'nullable|numeric|min:50|max:80',
            'new_tees.*.slope_rating' => 'nullable|integer|min:55|max:155',
            'new_tees.*.total_yardage' => 'nullable|integer|min:1000|max:8000',
            'new_tees.*.gender' => 'required|in:men,women,mixed',
            'yardages.*.*' => 'nullable|integer|min:50|max:800',
        ]);

        DB::transaction(function () use ($request, $course) {
            // Update holes
            if ($request->has('holes')) {
                foreach ($request->holes as $holeId => $holeData) {
                    CourseHole::where('id', $holeId)->update([
                        'par' => $holeData['par'],
                        'handicap' => $holeData['handicap'],
                        'name' => $holeData['name'] ?? null,
                    ]);
                }
            }

            // Update existing tees
            if ($request->has('tees')) {
                foreach ($request->tees as $teeId => $teeData) {
                    // Update existing tee
                    $tee = CourseTee::findOrFail($teeId);
                    $tee->update([
                        'name' => $teeData['name'],
                        'color' => $teeData['color'],
                        'rating' => $teeData['course_rating'] ?? null,
                        'slope' => $teeData['slope_rating'] ?? null,
                        'total_yardage' => $teeData['total_yardage'] ?? null,
                        'gender' => $teeData['gender'],
                    ]);

                    // Update yardages for this tee
                    if ($request->has("yardages")) {
                        foreach ($request->yardages as $holeId => $yardagesByTee) {
                            if (isset($yardagesByTee[$teeId])) {
                                CourseHoleTeeYardage::updateOrCreate(
                                    [
                                        'course_hole_id' => $holeId,
                                        'course_tee_id' => $tee->id,
                                    ],
                                    [
                                        'yardage' => $yardagesByTee[$teeId],
                                    ]
                                );
                            }
                        }
                    }
                }
            }

            // Create new tees
            if ($request->has('new_tees')) {
                foreach ($request->new_tees as $teeData) {
                    CourseTee::create([
                        'course_id' => $course->id,
                        'name' => $teeData['name'],
                        'color' => $teeData['color'] ?? null,
                        'rating' => $teeData['course_rating'] ?? null,
                        'slope' => $teeData['slope_rating'] ?? null,
                        'total_yardage' => $teeData['total_yardage'] ?? null,
                        'gender' => $teeData['gender'],
                    ]);
                }
            }

            // Update course totals
            $course->update([
                'par' => $course->holes()->sum('par'),
            ]);
        });

        return redirect()
            ->route('courses.setup', $course)
            ->with('success', 'Course setup updated successfully!');
    }

    /**
     * Ensure all holes exist for a course
     */
    private function ensureHolesExist(Course $course): void
    {
        for ($holeNumber = 1; $holeNumber <= $course->hole_count; $holeNumber++) {
            CourseHole::firstOrCreate(
                [
                    'course_id' => $course->id,
                    'hole_number' => $holeNumber,
                ],
                [
                    'par' => 4, // Default par
                    'handicap' => $holeNumber, // Default handicap order
                ]
            );
        }
    }
}
