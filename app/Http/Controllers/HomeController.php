<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get upcoming tournaments for homepage
        $upcomingTournaments = Tournament::where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc')
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

    public function leagues()
    {
        return view('pages.leagues');
    }

    public function instruction()
    {
        return view('pages.instruction');
    }

    public function store()
    {
        return view('pages.store');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        // Honeypot check - if the hidden "website" field is filled, it's a bot
        if ($request->filled('website')) {
            return back()->with('success', 'Thank you for your message!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Send email notification to the course
            \Mail::send('emails.contact-form', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => $validated['subject'],
                'contactMessage' => $validated['message'],
            ], function($msg) use ($validated) {
                $msg->to('smithcentergolfcourse@gmail.com')
                    ->subject('Contact Form: ' . $validated['subject'])
                    ->replyTo($validated['email'], $validated['name']);
            });

            return back()->with('success', 'Thank you for contacting us! We will respond to your message shortly.');
        } catch (\Exception $e) {
            \Log::error('Contact form email failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Sorry, there was an error sending your message. Please call us at (785) 282-3812. Error: ' . $e->getMessage());
        }
    }
}
