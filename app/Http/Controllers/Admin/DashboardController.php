<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tournament;
use App\Models\League;
use App\Models\TournamentEntry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_tournaments' => Tournament::count(),
            'upcoming_tournaments' => Tournament::where('start_date', '>=', now())->count(),
            'total_leagues' => League::count(),
            'active_leagues' => League::where('status', 'active')->count(),
            'total_entries' => TournamentEntry::count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $upcoming_tournaments = Tournament::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();
        $active_leagues = League::where('status', 'active')
            ->withCount('members')
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'upcoming_tournaments', 'active_leagues'));
    }
}
