<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentEntry;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScoreController extends Controller
{
    use AuthorizesRequests;
    /**
     * Show scorecard for a tournament entry
     */
    public function show(TournamentEntry $entry): View
    {
        $this->authorize('view', $entry);
        
        $entry->load(['tournament', 'user', 'scores']);
        
        // Create array of scores by hole number
        $scoresByHole = $entry->scores->keyBy('hole_number');
        
        return view('scores.show', compact('entry', 'scoresByHole'));
    }

    /**
     * Show form to enter scores
     */
    public function edit(TournamentEntry $entry): View
    {
        $this->authorize('update', $entry);
        
        $entry->load(['tournament', 'user', 'scores']);
        
        // Create array of scores by hole number
        $scoresByHole = $entry->scores->keyBy('hole_number');
        
        return view('scores.edit', compact('entry', 'scoresByHole'));
    }

    /**
     * Update scores for a tournament entry
     */
    public function update(Request $request, TournamentEntry $entry): RedirectResponse
    {
        $this->authorize('update', $entry);

        $tournament = $entry->tournament;
        
        // Validate scores for each hole
        $rules = [];
        for ($hole = 1; $hole <= $tournament->holes; $hole++) {
            $rules["scores.{$hole}.strokes"] = 'nullable|integer|min:1|max:15';
            $rules["scores.{$hole}.par"] = 'required|integer|min:3|max:5';
            $rules["scores.{$hole}.notes"] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        // Update or create scores
        foreach ($validated['scores'] as $holeNumber => $scoreData) {
            if (!empty($scoreData['strokes'])) {
                Score::updateOrCreate(
                    [
                        'tournament_entry_id' => $entry->id,
                        'hole_number' => $holeNumber,
                    ],
                    [
                        'strokes' => $scoreData['strokes'],
                        'par' => $scoreData['par'],
                        'notes' => $scoreData['notes'] ?? null,
                    ]
                );
            }
        }

        return redirect()
            ->route('scores.show', $entry)
            ->with('success', 'Scores updated successfully!');
    }

    /**
     * Delete a specific score
     */
    public function destroy(Score $score): RedirectResponse
    {
        $this->authorize('delete', $score);
        
        $entry = $score->tournamentEntry;
        $score->delete();

        return redirect()
            ->route('scores.edit', $entry)
            ->with('success', 'Score deleted successfully!');
    }

    /**
     * Show mobile scoring interface
     */
    public function mobile(TournamentEntry $entry): View
    {
        $this->authorize('update', $entry);
        
        $entry->load(['tournament', 'user', 'scores']);
        
        // Create array of scores by hole number
        $scoresByHole = $entry->scores->keyBy('hole_number');
        
        return view('scores.mobile', compact('entry', 'scoresByHole'));
    }

    /**
     * Show printable scorecard with QR code
     */
    public function printable(TournamentEntry $entry): View
    {
        $entry->load(['tournament', 'user', 'scores']);
        
        // Create array of scores by hole number
        $scoresByHole = $entry->scores->keyBy('hole_number');
        
        // Generate QR code URL for mobile scoring
        $mobileUrl = route('scores.mobile', $entry);
        
        return view('scores.printable', compact('entry', 'scoresByHole', 'mobileUrl'));
    }

    /**
     * Generate QR code for mobile scoring
     */
    public function qrCode(TournamentEntry $entry)
    {
        $mobileUrl = route('scores.mobile', $entry);
        
        // Simple QR code implementation using Google Charts API
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($mobileUrl);
        
        return response()->json([
            'url' => $mobileUrl,
            'qr_image' => $qrUrl
        ]);
    }

    /**
     * Print all scorecards for a tournament
     */
    public function printAll(Tournament $tournament)
    {
        $entries = $tournament->entries()->with(['user', 'scores'])->get();
        
        return view('scores.print-all', compact('tournament', 'entries'));
    }

    /**
     * Show combined scorecard for a tournament
     */
    public function combinedScorecard(Tournament $tournament)
    {
        // Load tournament with entries and scores
        $tournament->load([
            'entries.user', 
            'entries.scores',
            'teams.members',
            'teams.scores'
        ]);
        
        return view('scores.combined-scorecard', compact('tournament'));
    }
}
