<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TournamentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tournaments = Tournament::withCount('entries')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('tournaments.index', compact('tournaments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Tournament::class);
        return view('tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Tournament::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'holes' => 'required|integer|min:9|max:18',
            'format' => 'required|in:individual,scramble',
            'team_size' => 'required_if:format,scramble|nullable|integer|min:1|max:4',
            'entry_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'number_of_flights' => 'required|integer|min:1|max:5',
            'tie_breaking_method' => 'required|in:usga,hc_holes',
        ]);

        $tournament = Tournament::create($validated);

        return redirect()
            ->route('tournaments.show', $tournament)
            ->with('success', 'Tournament created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament): View
    {
        $tournament->load([
            'entries.user', 
            'entries.scores',
            'teams.captain',
            'teams.members'
        ]);
        
        return view('tournaments.show', compact('tournament'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament): View
    {
        $this->authorize('update', $tournament);
        return view('tournaments.edit', compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament): RedirectResponse
    {
        $this->authorize('update', $tournament);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'holes' => 'required|integer|min:9|max:18',
            'format' => 'required|in:individual,scramble',
            'team_size' => 'required_if:format,scramble|nullable|integer|min:1|max:4',
            'entry_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:upcoming,active,completed',
            'number_of_flights' => 'required|integer|min:1|max:5',
            'tie_breaking_method' => 'required|in:usga,hc_holes',
        ]);

        $tournament->update($validated);

        return redirect()
            ->route('tournaments.show', $tournament)
            ->with('success', 'Tournament updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament): RedirectResponse
    {
        $this->authorize('delete', $tournament);
        
        $tournament->delete();

        return redirect()
            ->route('tournaments.index')
            ->with('success', 'Tournament deleted successfully!');
    }

    /**
     * Show tournament leaderboard
     */
    public function leaderboard(Tournament $tournament): View
    {
        if ($tournament->format === 'scramble') {
            // For scramble tournaments, show team leaderboard
            return $this->teamLeaderboard($tournament);
        }
        
        $entries = $tournament->entries()
            ->with(['user', 'scores'])
            ->get()
            ->map(function ($entry) use ($tournament) {
                $entry->total_score = $entry->getTotalScore();
                $entry->score_vs_par = $entry->getScoreRelativeToPar();
                $entry->completed_holes = $entry->getCompletedHoles();
                return $entry;
            })
            ->sort(function ($a, $b) use ($tournament) {
                return $this->compareEntriesWithTieBreaking($a, $b, $tournament);
            })
            ->values(); // Reset array keys

        // Assign flights based on tournament settings
        $entriesWithFlights = $this->assignFlights($entries, $tournament->number_of_flights);

        return view('tournaments.leaderboard', compact('tournament', 'entries', 'entriesWithFlights'));
    }

    /**
     * Show team-based leaderboard with hole-by-hole scoring
     */
    public function teamLeaderboard(Tournament $tournament): View
    {
        if ($tournament->format !== 'scramble') {
            // For individual tournaments, show individual hole-by-hole leaderboard
            return $this->individualHoleByHole($tournament);
        }

        $teams = $tournament->teams()
            ->with(['captain', 'members', 'scores'])
            ->get()
            ->map(function ($team) use ($tournament) {
                // Calculate team totals
                $team->total_score = $team->getTotalScore();
                $team->score_vs_par = $team->getScoreRelativeToPar();
                $team->completed_holes = $team->getCompletedHoles();
                
                // Organize scores by hole number for easy table display
                $team->scoresByHole = $team->scores->keyBy('hole_number');
                
                // Calculate front 9, back 9 totals
                $front9Holes = range(1, min(9, $tournament->holes));
                $back9Holes = range(10, $tournament->holes);
                
                $team->front9_score = $team->scores->whereIn('hole_number', $front9Holes)->sum('strokes');
                $team->front9_par = $team->scores->whereIn('hole_number', $front9Holes)->sum('par');
                $team->back9_score = $team->scores->whereIn('hole_number', $back9Holes)->sum('strokes');
                $team->back9_par = $team->scores->whereIn('hole_number', $back9Holes)->sum('par');
                
                return $team;
            })
            ->sort(function ($a, $b) use ($tournament) {
                return $this->compareTeamsWithTieBreaking($a, $b, $tournament);
            })
            ->values(); // Reset array keys

        // Assign flights based on tournament settings
        $teamsWithFlights = $this->assignFlights($teams, $tournament->number_of_flights);

        return view('tournaments.team-leaderboard', compact('tournament', 'teams', 'teamsWithFlights'));
    }

    /**
     * Show individual hole-by-hole leaderboard
     */
    private function individualHoleByHole(Tournament $tournament): View
    {
        $entries = $tournament->entries()
            ->with(['user', 'scores'])
            ->get()
            ->map(function ($entry) use ($tournament) {
                // Calculate entry totals
                $entry->total_score = $entry->getTotalScore();
                $entry->score_vs_par = $entry->getScoreRelativeToPar();
                $entry->completed_holes = $entry->getCompletedHoles();
                
                // Organize scores by hole number for easy table display
                $entry->scoresByHole = $entry->scores->keyBy('hole_number');
                
                // Calculate front 9, back 9 totals
                $front9Holes = range(1, min(9, $tournament->holes));
                $back9Holes = range(10, $tournament->holes);
                
                $entry->front9_score = $entry->scores->whereIn('hole_number', $front9Holes)->sum('strokes');
                $entry->front9_par = $entry->scores->whereIn('hole_number', $front9Holes)->sum('par');
                $entry->back9_score = $entry->scores->whereIn('hole_number', $back9Holes)->sum('strokes');
                $entry->back9_par = $entry->scores->whereIn('hole_number', $back9Holes)->sum('par');
                
                return $entry;
            })
            ->sort(function ($a, $b) use ($tournament) {
                return $this->compareEntriesWithTieBreaking($a, $b, $tournament);
            })
            ->values(); // Reset array keys

        // Assign flights based on tournament settings
        $entriesWithFlights = $this->assignFlights($entries, $tournament->number_of_flights);

        return view('tournaments.individual-hole-by-hole', compact('tournament', 'entries', 'entriesWithFlights'));
    }

    /**
     * Compare two tournament entries with golf tie-breaking rules
     * 
     * Tie-breaking order depends on tournament settings:
     * USGA Method:
     * 1. Total score (lowest wins)
     * 2. Last 9 holes score
     * 3. Last 6 holes score  
     * 4. Last 3 holes score
     * 5. Last 1 hole score
     * 6. Handicap holes (hardest holes first)
     * 
     * HC Holes Method:
     * 1. Total score (lowest wins)
     * 2. Handicap holes only (hardest holes first)
     */
    private function compareEntriesWithTieBreaking($entryA, $entryB, Tournament $tournament): int
    {
        // First compare total scores
        if ($entryA->total_score !== $entryB->total_score) {
            return $entryA->total_score <=> $entryB->total_score;
        }

        // If tied, apply golf tie-breaking rules based on tournament preference
        $scoresA = $entryA->scores->keyBy('hole_number');
        $scoresB = $entryB->scores->keyBy('hole_number');

        if ($tournament->tie_breaking_method === 'hc_holes') {
            // HC Holes method: Go straight to handicap holes
            return $this->compareByHandicapHoles($scoresA, $scoresB, $tournament);
        }

        // USGA method: Standard progression
        // 1. Compare last 9 holes
        $last9Result = $this->compareLast9Holes($scoresA, $scoresB, $tournament->holes);
        if ($last9Result !== 0) {
            return $last9Result;
        }

        // 2. Compare last 6 holes
        $last6Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 6);
        if ($last6Result !== 0) {
            return $last6Result;
        }

        // 3. Compare last 3 holes
        $last3Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 3);
        if ($last3Result !== 0) {
            return $last3Result;
        }

        // 4. Compare last 1 hole
        $last1Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 1);
        if ($last1Result !== 0) {
            return $last1Result;
        }

        // 5. Compare by handicap holes (hardest holes first)
        return $this->compareByHandicapHoles($scoresA, $scoresB, $tournament);
    }

    /**
     * Compare two teams with golf tie-breaking rules
     */
    private function compareTeamsWithTieBreaking($teamA, $teamB, Tournament $tournament): int
    {
        // First compare total scores
        if ($teamA->total_score !== $teamB->total_score) {
            return $teamA->total_score <=> $teamB->total_score;
        }

        // If tied, apply golf tie-breaking rules using team scores based on tournament preference
        $scoresA = $teamA->scores->keyBy('hole_number');
        $scoresB = $teamB->scores->keyBy('hole_number');

        if ($tournament->tie_breaking_method === 'hc_holes') {
            // HC Holes method: Go straight to handicap holes
            return $this->compareByHandicapHoles($scoresA, $scoresB, $tournament);
        }

        // USGA method: Standard progression
        // 1. Compare last 9 holes
        $last9Result = $this->compareLast9Holes($scoresA, $scoresB, $tournament->holes);
        if ($last9Result !== 0) {
            return $last9Result;
        }

        // 2. Compare last 6 holes
        $last6Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 6);
        if ($last6Result !== 0) {
            return $last6Result;
        }

        // 3. Compare last 3 holes
        $last3Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 3);
        if ($last3Result !== 0) {
            return $last3Result;
        }

        // 4. Compare last 1 hole
        $last1Result = $this->compareLastNHoles($scoresA, $scoresB, $tournament->holes, 1);
        if ($last1Result !== 0) {
            return $last1Result;
        }

        // 5. Compare by handicap holes
        return $this->compareByHandicapHoles($scoresA, $scoresB, $tournament);
    }

    /**
     * Compare last 9 holes scores
     */
    private function compareLast9Holes($scoresA, $scoresB, int $totalHoles): int
    {
        if ($totalHoles <= 9) {
            // For 9-hole tournaments, compare all holes
            return $this->compareLastNHoles($scoresA, $scoresB, $totalHoles, $totalHoles);
        }

        // For 18-hole tournaments, compare holes 10-18
        return $this->compareLastNHoles($scoresA, $scoresB, $totalHoles, 9);
    }

    /**
     * Compare last N holes scores
     */
    private function compareLastNHoles($scoresA, $scoresB, int $totalHoles, int $n): int
    {
        $startHole = max(1, $totalHoles - $n + 1);
        $endHole = $totalHoles;

        $totalA = 0;
        $totalB = 0;

        for ($hole = $startHole; $hole <= $endHole; $hole++) {
            $scoreA = $scoresA->get($hole);
            $scoreB = $scoresB->get($hole);

            if ($scoreA && $scoreB) {
                $totalA += $scoreA->strokes;
                $totalB += $scoreB->strokes;
            } elseif ($scoreA && !$scoreB) {
                // A has score, B doesn't - A is better positioned
                return -1;
            } elseif (!$scoreA && $scoreB) {
                // B has score, A doesn't - B is better positioned  
                return 1;
            }
            // If neither has score for this hole, continue
        }

        return $totalA <=> $totalB;
    }

    /**
     * Compare by handicap holes (hardest holes first)
     * This requires getting hole handicap information from the course
     */
    private function compareByHandicapHoles($scoresA, $scoresB, Tournament $tournament): int
    {
        // Get course holes ordered by handicap (hardest first)
        $course = $tournament->course ?? null;
        if (!$course) {
            // If no course data available, fall back to hole number order
            return 0;
        }

        $holes = $course->holes()->orderBy('handicap')->get();
        
        foreach ($holes as $hole) {
            $scoreA = $scoresA->get($hole->hole_number);
            $scoreB = $scoresB->get($hole->hole_number);

            if ($scoreA && $scoreB) {
                $comparison = $scoreA->strokes <=> $scoreB->strokes;
                if ($comparison !== 0) {
                    return $comparison;
                }
            } elseif ($scoreA && !$scoreB) {
                return -1; // A has score, B doesn't
            } elseif (!$scoreA && $scoreB) {
                return 1; // B has score, A doesn't
            }
            // If neither has score, continue to next handicap hole
        }

        // If still tied after all handicap holes, they're truly tied
        return 0;
    }

    /**
     * Assign flights to entries/teams based on number of flights
     * Divides participants roughly equally, keeping ties together
     */
    private function assignFlights($participants, int $numberOfFlights): array
    {
        if ($numberOfFlights <= 1) {
            return [
                1 => $participants->toArray()
            ];
        }

        $total = $participants->count();
        if ($total === 0) {
            return [];
        }

        $flightsWithParticipants = [];
        $participantsArray = $participants->toArray();
        
        // Calculate target size per flight
        $baseSize = intval($total / $numberOfFlights);
        $remainder = $total % $numberOfFlights;
        
        $currentIndex = 0;
        
        for ($flight = 1; $flight <= $numberOfFlights; $flight++) {
            $flightSize = $baseSize + ($flight <= $remainder ? 1 : 0);
            
            if ($currentIndex >= $total) {
                break;
            }
            
            $flightParticipants = [];
            $added = 0;
            
            // Add participants to this flight
            while ($currentIndex < $total && $added < $flightSize) {
                $participant = $participantsArray[$currentIndex];
                $flightParticipants[] = $participant;
                $currentIndex++;
                $added++;
                
                // If we're at the target size, check for ties
                if ($added >= $flightSize && $currentIndex < $total) {
                    $currentScore = $participant->total_score ?? 0;
                    
                    // Add tied participants to keep ties together
                    while ($currentIndex < $total) {
                        $nextParticipant = $participantsArray[$currentIndex];
                        $nextScore = $nextParticipant->total_score ?? 0;
                        
                        // If scores are tied and we have room in flights, keep them together
                        if ($currentScore === $nextScore) {
                            $flightParticipants[] = $nextParticipant;
                            $currentIndex++;
                            $added++;
                        } else {
                            break;
                        }
                    }
                    break;
                }
            }
            
            if (!empty($flightParticipants)) {
                $flightsWithParticipants[$flight] = $flightParticipants;
            }
        }
        
        // If there are remaining participants (shouldn't happen with proper calculation)
        if ($currentIndex < $total) {
            $lastFlight = count($flightsWithParticipants);
            if ($lastFlight > 0) {
                // Add remaining to last flight
                while ($currentIndex < $total) {
                    $flightsWithParticipants[$lastFlight][] = $participantsArray[$currentIndex];
                    $currentIndex++;
                }
            }
        }
        
        return $flightsWithParticipants;
    }
}
