<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\LeagueMember;
use App\Models\LeagueStanding;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeagueController extends Controller
{
    /**
     * Display a listing of leagues (public view)
     */
    public function index()
    {
        $activeLeagues = League::where('status', 'active')
            ->withCount('members')
            ->orderBy('season_start', 'desc')
            ->get();
        
        $upcomingLeagues = League::where('status', 'draft')
            ->where('season_start', '>', now())
            ->withCount('members')
            ->orderBy('season_start')
            ->get();
        
        $completedLeagues = League::where('status', 'completed')
            ->withCount('members')
            ->orderBy('season_end', 'desc')
            ->limit(10)
            ->get();

        return view('leagues.index', compact('activeLeagues', 'upcomingLeagues', 'completedLeagues'));
    }

    /**
     * Show the form for creating a new league (admin only)
     */
    public function create()
    {
        return view('leagues.create');
    }

    /**
     * Store a newly created league
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:mens,womens,mixed',
            'season_start' => 'required|date',
            'season_end' => 'required|date|after:season_start',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'tee_time' => 'required|date_format:H:i',
            'holes' => 'required|in:9,18',
            'entry_fee_per_week' => 'nullable|numeric|min:0',
            'season_fee' => 'nullable|numeric|min:0',
            'max_members' => 'nullable|integer|min:4',
            'weeks_count_for_championship' => 'nullable|integer|min:1',
            'points_system' => 'required|in:placement,custom',
            'participation_points' => 'boolean',
            'participation_points_value' => 'nullable|integer|min:0',
            'number_of_flights' => 'nullable|integer|min:1|max:5',
            'flight_prizes' => 'boolean',
        ]);

        // Set default points structure if using placement system
        if ($validated['points_system'] === 'placement') {
            $validated['points_structure'] = [
                1 => 10, 2 => 9, 3 => 8, 4 => 7, 5 => 6,
                6 => 5, 7 => 4, 8 => 3, 9 => 2, 10 => 1
            ];
        }

        $league = League::create($validated);

        return redirect()->route('leagues.show', $league)
            ->with('success', 'League created successfully!');
    }

    /**
     * Display the specified league
     */
    public function show(League $league)
    {
        $league->load(['members.user', 'tournaments' => function($query) {
            $query->orderBy('date');
        }]);

        $currentWeek = $league->getCurrentWeek();
        $totalWeeks = $league->getTotalWeeks();
        
        // Get current season standings (top 10 teams)
        $standings = LeagueStanding::where('league_id', $league->id)
            ->with('user')
            ->orderBy('total_points', 'desc')
            ->orderBy('weeks_played', 'desc')
            ->limit(10)
            ->get();

        // Check if current user is a member
        $isMember = auth()->check() && $league->hasMember(auth()->user());
        
        // Get member's team partner if they are a member
        $teamPartner = null;
        if ($isMember) {
            $teamPartner = $this->getTeamPartner($league, auth()->user());
        }

        return view('leagues.show', compact('league', 'currentWeek', 'totalWeeks', 'standings', 'isMember', 'teamPartner'));
    }

    /**
     * Show the form for editing the league
     */
    public function edit(League $league)
    {
        return view('leagues.edit', compact('league'));
    }

    /**
     * Update the league
     */
    public function update(Request $request, League $league)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:mens,womens,mixed',
            'season_start' => 'required|date',
            'season_end' => 'required|date|after:season_start',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'tee_time' => 'required|date_format:H:i',
            'holes' => 'required|in:9,18',
            'entry_fee_per_week' => 'nullable|numeric|min:0',
            'season_fee' => 'nullable|numeric|min:0',
            'max_members' => 'nullable|integer|min:4',
            'weeks_count_for_championship' => 'nullable|integer|min:1',
            'points_system' => 'required|in:placement,custom',
            'participation_points' => 'boolean',
            'participation_points_value' => 'nullable|integer|min:0',
            'number_of_flights' => 'nullable|integer|min:1|max:5',
            'flight_prizes' => 'boolean',
            'status' => 'required|in:draft,active,completed',
        ]);

        $league->update($validated);

        return redirect()->route('leagues.show', $league)
            ->with('success', 'League updated successfully!');
    }

    /**
     * Remove the league
     */
    public function destroy(League $league)
    {
        // Only allow deletion if no tournaments have been played
        if ($league->tournaments()->count() > 0) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'Cannot delete a league with tournaments. Archive it instead.');
        }

        $league->delete();

        return redirect()->route('leagues.index')
            ->with('success', 'League deleted successfully.');
    }

    /**
     * Display league members roster
     */
    public function roster(League $league)
    {
        $members = LeagueMember::where('league_id', $league->id)
            ->with('user')
            ->where('is_active', true)
            ->orderBy('joined_date')
            ->get();

        // Group members into teams (pairs)
        $teams = $this->groupMembersIntoTeams($members);

        return view('leagues.roster', compact('league', 'teams', 'members'));
    }

    /**
     * Display season standings
     */
    public function standings(League $league)
    {
        // Get all standings ordered by points
        $standings = LeagueStanding::where('league_id', $league->id)
            ->with('user')
            ->orderBy('total_points', 'desc')
            ->orderBy('weeks_played', 'desc')
            ->orderBy('best_score', 'asc')
            ->get();

        // Group standings by teams
        $teamStandings = $this->calculateTeamStandings($league, $standings);

        // Get championship standings if applicable
        $championshipStandings = null;
        if ($league->weeks_count_for_championship) {
            $championshipStandings = $this->calculateChampionshipStandings($league);
        }

        return view('leagues.standings', compact('league', 'teamStandings', 'championshipStandings'));
    }

    /**
     * Display weekly standings
     */
    public function weeklyStandings(League $league, $weekNumber)
    {
        $tournament = Tournament::where('league_id', $league->id)
            ->where('week_number', $weekNumber)
            ->first();

        if (!$tournament) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'Week not found.');
        }

        $standings = LeagueStanding::where('league_id', $league->id)
            ->where('week_number', $weekNumber)
            ->with('user')
            ->orderBy('position')
            ->get();

        // Group into teams
        $teamResults = $this->groupWeeklyResultsByTeam($standings);

        return view('leagues.weekly', compact('league', 'tournament', 'weekNumber', 'teamResults'));
    }

    /**
     * Enroll current user in league
     */
    public function enroll(Request $request, League $league)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to join a league.');
        }

        if (!$league->hasSpaceAvailable()) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'This league is full.');
        }

        if ($league->hasMember(auth()->user())) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'You are already enrolled in this league.');
        }

        $validated = $request->validate([
            'handicap' => 'nullable|numeric|min:0|max:54',
            'partner_id' => 'nullable|exists:users,id',
        ]);

        LeagueMember::create([
            'league_id' => $league->id,
            'user_id' => auth()->id(),
            'handicap' => $validated['handicap'] ?? null,
            'is_active' => true,
            'joined_date' => now(),
        ]);

        return redirect()->route('leagues.show', $league)
            ->with('success', 'Successfully enrolled in ' . $league->name . '!');
    }

    /**
     * Unenroll current user from league
     */
    public function unenroll(League $league)
    {
        $member = LeagueMember::where('league_id', $league->id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$member) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'You are not enrolled in this league.');
        }

        // Check if any tournaments have been played
        $weeksPlayed = LeagueStanding::where('league_id', $league->id)
            ->where('user_id', auth()->id())
            ->where('participated', true)
            ->count();

        if ($weeksPlayed > 0) {
            // Deactivate instead of delete to preserve history
            $member->deactivate();
            $message = 'You have been removed from active participation. Your past results will be preserved.';
        } else {
            // Safe to delete if no participation yet
            $member->delete();
            $message = 'Successfully withdrew from ' . $league->name . '.';
        }

        return redirect()->route('leagues.index')
            ->with('success', $message);
    }

    /**
     * Calculate standings after tournament completion
     */
    public function calculateWeekStandings(League $league, Tournament $tournament)
    {
        if (!$tournament->isLeagueTournament() || $tournament->league_id !== $league->id) {
            return redirect()->back()
                ->with('error', 'Tournament does not belong to this league.');
        }

        // Get all teams and their scores
        $teams = $tournament->teams()->with(['members.user', 'scores'])->get();

        if ($teams->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No teams found for this tournament.');
        }

        DB::beginTransaction();
        try {
            // Calculate team positions (already done by tournament system)
            $position = 1;
            foreach ($teams as $team) {
                $teamScore = $team->total_score ?? 0;
                $teamVsPar = $team->score_vs_par ?? 0;

                // Award points to each team member
                foreach ($team->members as $member) {
                    $points = $league->calculatePoints(
                        $position,
                        $teams->count(),
                        true // participated
                    );

                    // Find or create standing record
                    $standing = LeagueStanding::firstOrNew([
                        'league_id' => $league->id,
                        'user_id' => $member->user_id,
                        'week_number' => $tournament->week_number,
                    ]);

                    // Update weekly stats
                    $standing->tournament_id = $tournament->id;
                    $standing->position = $position;
                    $standing->flight = $team->flight;
                    $standing->position_in_flight = $team->position_in_flight ?? null;
                    $standing->total_score = $teamScore;
                    $standing->score_vs_par = $teamVsPar;
                    $standing->points_earned = $points;
                    $standing->participated = true;

                    // Update cumulative stats
                    $previousStandings = LeagueStanding::where('league_id', $league->id)
                        ->where('user_id', $member->user_id)
                        ->where('id', '!=', $standing->id ?? 0)
                        ->get();

                    $standing->total_points = $previousStandings->sum('points_earned') + $points;
                    $standing->weeks_played = $previousStandings->where('participated', true)->count() + 1;

                    $allScores = $previousStandings->where('participated', true)->pluck('total_score')->push($teamScore);
                    $standing->best_score = $allScores->min();
                    $standing->worst_score = $allScores->max();
                    $standing->average_score = $allScores->average();

                    $standing->save();
                }

                $position++;
            }

            DB::commit();

            return redirect()->route('leagues.weekly', [$league, $tournament->week_number])
                ->with('success', 'Week ' . $tournament->week_number . ' standings calculated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error calculating standings: ' . $e->getMessage());
        }
    }

    /**
     * Generate weekly tournaments for entire season
     */
    public function generateWeeklyTournaments(League $league)
    {
        if ($league->tournaments()->count() > 0) {
            return redirect()->route('leagues.show', $league)
                ->with('error', 'Tournaments already exist for this league.');
        }

        $start = Carbon::parse($league->season_start);
        $end = Carbon::parse($league->season_end);
        
        // Find the first occurrence of the league day
        $dayOfWeek = $start->dayOfWeek;
        $targetDay = array_search($league->day_of_week, ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
        
        $firstDay = $start->copy();
        while ($firstDay->dayOfWeek !== $targetDay) {
            $firstDay->addDay();
        }

        $weekNumber = 1;
        $current = $firstDay->copy();

        DB::beginTransaction();
        try {
            while ($current->lte($end)) {
                Tournament::create([
                    'name' => $league->name . ' - Week ' . $weekNumber,
                    'date' => $current->toDateString(),
                    'tee_time' => $league->tee_time,
                    'format' => 'scramble', // 2-man best ball format
                    'holes' => $league->holes,
                    'entry_fee' => $league->entry_fee_per_week,
                    'max_teams' => $league->max_members ? intval($league->max_members / 2) : null,
                    'number_of_flights' => $league->number_of_flights ?? 1,
                    'status' => 'upcoming',
                    'league_id' => $league->id,
                    'week_number' => $weekNumber,
                    'counts_for_championship' => true,
                ]);

                $weekNumber++;
                $current->addWeek();
            }

            DB::commit();

            return redirect()->route('leagues.show', $league)
                ->with('success', 'Generated ' . ($weekNumber - 1) . ' weekly tournaments!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error generating tournaments: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Get team partner for a user
     */
    private function getTeamPartner(League $league, User $user)
    {
        // Find most recent tournament where user played
        $recentTeam = DB::table('team_members')
            ->join('teams', 'team_members.team_id', '=', 'teams.id')
            ->join('tournaments', 'teams.tournament_id', '=', 'tournaments.id')
            ->where('tournaments.league_id', $league->id)
            ->where('team_members.user_id', $user->id)
            ->orderBy('tournaments.date', 'desc')
            ->first();

        if (!$recentTeam) {
            return null;
        }

        // Get partner from that team
        $partnerId = DB::table('team_members')
            ->where('team_id', $recentTeam->team_id)
            ->where('user_id', '!=', $user->id)
            ->value('user_id');

        return $partnerId ? User::find($partnerId) : null;
    }

    /**
     * Helper: Group members into teams
     */
    private function groupMembersIntoTeams($members)
    {
        $teams = [];
        $processed = [];

        foreach ($members as $member) {
            if (in_array($member->user_id, $processed)) {
                continue;
            }

            // Find partner (simplified - you may want more sophisticated team tracking)
            $partner = null;
            foreach ($members as $potentialPartner) {
                if ($potentialPartner->user_id !== $member->user_id && 
                    !in_array($potentialPartner->user_id, $processed)) {
                    $partner = $potentialPartner;
                    $processed[] = $potentialPartner->user_id;
                    break;
                }
            }

            $teams[] = [
                'player1' => $member,
                'player2' => $partner,
            ];

            $processed[] = $member->user_id;
        }

        return $teams;
    }

    /**
     * Helper: Calculate team standings from individual standings
     */
    private function calculateTeamStandings(League $league, $individualStandings)
    {
        // Group by teams and sum their points
        $teamData = [];
        
        foreach ($individualStandings as $standing) {
            $partner = $this->getTeamPartner($league, $standing->user);
            
            if (!$partner) {
                continue;
            }

            $teamKey = $this->getTeamKey($standing->user_id, $partner->id);
            
            if (!isset($teamData[$teamKey])) {
                $teamData[$teamKey] = [
                    'player1' => $standing->user,
                    'player2' => $partner,
                    'total_points' => 0,
                    'weeks_played' => 0,
                    'best_score' => null,
                ];
            }

            $teamData[$teamKey]['total_points'] += $standing->total_points;
            $teamData[$teamKey]['weeks_played'] = max($teamData[$teamKey]['weeks_played'], $standing->weeks_played);
            
            if ($standing->best_score) {
                $teamData[$teamKey]['best_score'] = $teamData[$teamKey]['best_score'] 
                    ? min($teamData[$teamKey]['best_score'], $standing->best_score)
                    : $standing->best_score;
            }
        }

        // Sort by points
        uasort($teamData, function($a, $b) {
            if ($b['total_points'] !== $a['total_points']) {
                return $b['total_points'] <=> $a['total_points'];
            }
            return $a['best_score'] <=> $b['best_score'];
        });

        return collect($teamData)->values();
    }

    /**
     * Helper: Calculate championship standings (best X weeks)
     */
    private function calculateChampionshipStandings(League $league)
    {
        $bestWeeksCount = $league->weeks_count_for_championship;
        $allMembers = $league->members()->where('is_active', true)->with('user')->get();

        $championshipData = [];

        foreach ($allMembers as $member) {
            $weeklyScores = LeagueStanding::where('league_id', $league->id)
                ->where('user_id', $member->user_id)
                ->where('participated', true)
                ->orderBy('points_earned', 'desc')
                ->limit($bestWeeksCount)
                ->get();

            if ($weeklyScores->count() >= $bestWeeksCount) {
                $championshipData[] = [
                    'user' => $member->user,
                    'championship_points' => $weeklyScores->sum('points_earned'),
                    'weeks_counted' => $weeklyScores->count(),
                    'best_weeks' => $weeklyScores->pluck('week_number'),
                ];
            }
        }

        // Sort by championship points
        usort($championshipData, function($a, $b) {
            return $b['championship_points'] <=> $a['championship_points'];
        });

        return collect($championshipData);
    }

    /**
     * Helper: Group weekly results by team
     */
    private function groupWeeklyResultsByTeam($standings)
    {
        $teams = [];
        
        foreach ($standings as $standing) {
            $teams[] = [
                'user' => $standing->user,
                'position' => $standing->position,
                'score' => $standing->total_score,
                'vs_par' => $standing->score_vs_par,
                'points' => $standing->points_earned,
            ];
        }

        return collect($teams);
    }

    /**
     * Helper: Create consistent team key
     */
    private function getTeamKey($userId1, $userId2)
    {
        return $userId1 < $userId2 ? "{$userId1}_{$userId2}" : "{$userId2}_{$userId1}";
    }
}
