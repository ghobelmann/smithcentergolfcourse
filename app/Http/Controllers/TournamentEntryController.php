<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentEntry;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TournamentEntryController extends Controller
{
    /**
     * Register a user for a tournament
     */
    public function store(Request $request, Tournament $tournament): RedirectResponse
    {
        $request->validate([
            'handicap' => 'nullable|integer|min:0|max:54',
        ]);

        // Check if user is already registered
        if ($tournament->entries()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You are already registered for this tournament.');
        }

        // Check if tournament has space
        if (!$tournament->hasSpaceAvailable()) {
            return back()->with('error', 'This tournament is full.');
        }

        // Check if tournament is still open for registration
        if (!$tournament->isUpcoming()) {
            return back()->with('error', 'Registration for this tournament is closed.');
        }

        TournamentEntry::create([
            'tournament_id' => $tournament->id,
            'user_id' => Auth::id(),
            'handicap' => $request->handicap ?? Auth::user()->handicap,
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Successfully registered for the tournament!');
    }

    /**
     * Remove a user from a tournament
     */
    public function destroy(Tournament $tournament): RedirectResponse
    {
        $entry = $tournament->entries()->where('user_id', Auth::id())->first();

        if (!$entry) {
            return back()->with('error', 'You are not registered for this tournament.');
        }

        // Don't allow withdrawal if tournament has started
        if (!$tournament->isUpcoming()) {
            return back()->with('error', 'Cannot withdraw from an active or completed tournament.');
        }

        $entry->delete();

        return back()->with('success', 'Successfully withdrawn from the tournament.');
    }

    /**
     * Check in a tournament entry
     */
    public function checkIn(Tournament $tournament, TournamentEntry $entry): RedirectResponse
    {
        $this->authorize('update', $entry);

        $entry->update(['checked_in' => true]);

        return back()->with('success', 'Player checked in successfully.');
    }

    /**
     * Assign cards to tournament entries
     */
    public function assignCards(Tournament $tournament, Request $request): RedirectResponse
    {
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.entry_id' => 'required|exists:tournament_entries,id',
            'assignments.*.starting_hole' => 'required|integer|between:1,18',
            'assignments.*.group_letter' => 'required|in:A,B',
            'assignments.*.card_order' => 'nullable|integer|min:1',
        ]);

        foreach ($request->assignments as $assignment) {
            TournamentEntry::where('id', $assignment['entry_id'])
                ->update([
                    'starting_hole' => $assignment['starting_hole'],
                    'group_letter' => $assignment['group_letter'],
                    'card_order' => $assignment['card_order'] ?? null,
                ]);
        }

        return back()->with('success', 'Card assignments updated successfully.');
    }
}
