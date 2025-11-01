<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Tournament $tournament): View
    {
        $teams = $tournament->teams()->with(['captain', 'members'])->get();
        
        return view('teams.index', compact('tournament', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tournament $tournament = null): View
    {
        if ($tournament && !$tournament->isScramble()) {
            abort(404);
        }

        return view('teams.create', compact('tournament'));
    }

    /**
     * Show the form for creating a new team (simplified route)
     */
    public function createSimple(): View
    {
        $tournament = null;
        return view('teams.create', compact('tournament'));
    }    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tournament $tournament): RedirectResponse
    {
        if (!$tournament->isScramble()) {
            return redirect()->route('tournaments.show', $tournament)
                ->with('error', 'This tournament does not support teams.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Check if tournament has space
        if (!$tournament->hasSpaceAvailable()) {
            return back()->with('error', 'This tournament is full.');
        }

        // Check if tournament is still open for registration
        if (!$tournament->isUpcoming()) {
            return back()->with('error', 'Registration for this tournament is closed.');
        }

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'captain_id' => Auth::id(),
            'tournament_id' => $tournament->id,
            'registered_at' => now(),
        ]);

        // Add captain as first team member
        $team->members()->attach(Auth::id(), [
            'handicap' => Auth::user()->handicap
        ]);

        return redirect()->route('tournaments.teams.show', [$tournament, $team])
            ->with('success', 'Team created successfully! Add more players to complete your team.');
    }

    /**
     * Store a team without tournament context (simplified route)
     */
    public function storeSimple(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tournament_id' => 'required|exists:tournaments,id',
            'description' => 'nullable|string|max:500',
        ]);

        $tournament = Tournament::findOrFail($validated['tournament_id']);

        // Check if tournament format is scramble
        if ($tournament->format !== 'scramble') {
            return back()->with('error', 'Teams can only be created for scramble tournaments.');
        }

        // Check if tournament has space
        if (!$tournament->hasSpaceAvailable()) {
            return back()->with('error', 'This tournament is full.');
        }

        // Check if tournament is still open for registration
        if (!$tournament->isUpcoming()) {
            return back()->with('error', 'Registration for this tournament is closed.');
        }

        // Check if user is already on a team for this tournament
        $existingTeam = $tournament->teams()->whereHas('members', function($query) {
            $query->where('users.id', Auth::id());
        })->first();
        
        if ($existingTeam) {
            return redirect()->route('teams.show', $existingTeam)
                ->with('error', 'You are already on a team for this tournament.');
        }

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'captain_id' => Auth::id(),
            'tournament_id' => $tournament->id,
            'registered_at' => now(),
        ]);

        // Add captain as first team member
        $team->members()->attach(Auth::id(), [
            'handicap' => Auth::user()->handicap
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', 'Team created successfully! Add more players to complete your team.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tournament $tournament = null, Team $team = null): View
    {
        // Handle simplified route where $tournament is actually the team
        if ($tournament instanceof Team && $team === null) {
            $team = $tournament;
            $tournament = $team->tournament;
        }

        $team->load(['captain', 'members', 'scores', 'tournament']);

        return view('teams.show', compact('tournament', 'team'));
    }

    /**
     * Display the specified team (simplified route)
     */
    public function showSimple(Team $team): View
    {
        $team->load(['captain', 'members', 'scores', 'tournament']);
        $tournament = $team->tournament;

        return view('teams.show', compact('tournament', 'team'));
    }

    /**
     * Show the form for editing the specified resource.
     */    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tournament $tournament, Team $team): View
    {
        $this->authorize('update', $team);
        
        return view('teams.edit', compact('tournament', 'team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tournament $tournament, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $team->update($validated);

        return redirect()->route('teams.show', [$tournament, $team])
            ->with('success', 'Team updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tournament $tournament, Team $team): RedirectResponse
    {
        $this->authorize('delete', $team);

        $team->delete();

        return redirect()->route('tournaments.show', $tournament)
            ->with('success', 'Team deleted successfully.');
    }

    /**
     * Add a member to the team
     */
    public function addMember(Request $request, Tournament $tournament, Team $team): RedirectResponse
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'handicap' => 'nullable|integer|min:0|max:54',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Check if team is full
        if (!$team->canAddMembers()) {
            return back()->with('error', 'Team is already full.');
        }

        // Check if user is already on the team
        if ($team->hasMember($user)) {
            return back()->with('error', 'Player is already on this team.');
        }

        // Check if user is already registered for this tournament
        if ($tournament->isScramble()) {
            $existingTeam = $tournament->teams()->whereHas('members', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->first();
            
            if ($existingTeam) {
                return back()->with('error', 'Player is already registered on another team for this tournament.');
            }
        }

        $team->members()->attach($user->id, [
            'handicap' => $validated['handicap'] ?? $user->handicap
        ]);

        return back()->with('success', "Added {$user->name} to the team!");
    }

    /**
     * Remove a member from the team
     */
    public function removeMember(Tournament $tournament, Team $team, User $user): RedirectResponse
    {
        $this->authorize('update', $team);

        // Can't remove the captain
        if ($team->isCaptain($user)) {
            return back()->with('error', 'Cannot remove the team captain.');
        }

        $team->members()->detach($user->id);

        return back()->with('success', "Removed {$user->name} from the team.");
    }

    /**
     * Join a team
     */
    public function join(Team $team): RedirectResponse
    {
        $user = Auth::user();

        // Check if team is full
        if (!$team->canAddMembers()) {
            return back()->with('error', 'Team is already full.');
        }

        // Check if user is already on the team
        if ($team->hasMember($user)) {
            return back()->with('error', 'You are already on this team.');
        }

        // Check if user is already registered for this tournament
        if ($team->tournament->isScramble()) {
            $existingTeam = $team->tournament->teams()->whereHas('members', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->first();
            
            if ($existingTeam) {
                return back()->with('error', 'You are already registered on another team for this tournament.');
            }
        }

        // Check if tournament is still open for registration
        if (!$team->tournament->isUpcoming()) {
            return back()->with('error', 'Registration for this tournament is closed.');
        }

        $team->members()->attach($user->id, [
            'handicap' => $user->handicap
        ]);

        return redirect()->route('teams.show', $team)
            ->with('success', "Successfully joined {$team->name}!");
    }

    /**
     * Leave a team
     */
    public function leave(Team $team): RedirectResponse
    {
        $user = Auth::user();

        // Check if user is on the team
        if (!$team->hasMember($user)) {
            return back()->with('error', 'You are not on this team.');
        }

        // Check if tournament is still open for changes
        if (!$team->tournament->isUpcoming()) {
            return back()->with('error', 'Cannot leave team after tournament has started.');
        }

        // If captain is leaving, either transfer captaincy or delete team
        if ($team->isCaptain($user)) {
            $otherMembers = $team->members()->where('users.id', '!=', $user->id)->get();
            
            if ($otherMembers->count() > 0) {
                // Transfer captaincy to first member
                $newCaptain = $otherMembers->first();
                $team->update(['captain_id' => $newCaptain->id]);
                $team->members()->detach($user->id);
                
                return redirect()->route('tournaments.show', $team->tournament)
                    ->with('success', "Left {$team->name}. Captaincy transferred to {$newCaptain->name}.");
            } else {
                // No other members, delete the team
                $tournamentName = $team->tournament->name;
                $team->delete();
                
                return redirect()->route('tournaments.show', $team->tournament)
                    ->with('success', "Left and deleted {$team->name} since you were the only member.");
            }
        } else {
            // Regular member leaving
            $team->members()->detach($user->id);
            
            return redirect()->route('tournaments.show', $team->tournament)
                ->with('success', "Successfully left {$team->name}.");
        }
    }
}
