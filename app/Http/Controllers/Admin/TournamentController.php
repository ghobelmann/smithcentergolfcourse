<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Course;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tournaments = Tournament::with('course')
            ->orderBy('start_date', 'desc')
            ->paginate(20);
            
        return view('admin.tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.tournaments.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'holes' => 'required|integer|in:9,18',
            'entry_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'format' => 'required|string',
            'status' => 'required|in:upcoming,active,completed',
        ]);

        $tournament = Tournament::create($validated);

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament)
    {
        $tournament->load(['entries.user', 'course']);
        return view('admin.tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament)
    {
        $courses = Course::all();
        return view('admin.tournaments.edit', compact('tournament', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'holes' => 'required|integer|in:9,18',
            'entry_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'format' => 'required|string',
            'status' => 'required|in:upcoming,active,completed',
        ]);

        $tournament->update($validated);

        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        
        return redirect()->route('admin.tournaments.index')
            ->with('success', 'Tournament deleted successfully!');
    }
}
