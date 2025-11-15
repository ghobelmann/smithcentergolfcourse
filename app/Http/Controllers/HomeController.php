<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get upcoming tournaments for homepage
        $upcomingTournaments = Tournament::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        return view('home', compact('upcomingTournaments'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function facilities()
    {
        return view('pages.facilities');
    }

    public function rates()
    {
        return view('pages.rates');
    }

    public function teeTimes()
    {
        return view('pages.tee-times');
    }

    public function instruction()
    {
        return view('pages.instruction');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
