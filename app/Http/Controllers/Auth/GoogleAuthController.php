<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback()
    {
        try {
            // Check if Google returned an error
            if (request()->has('error')) {
                \Log::error('Google OAuth returned error: ' . request('error'));
                \Log::error('Error description: ' . request('error_description', 'No description'));
                return redirect('/login')->with('error', 'Unable to login with Google: ' . request('error_description', request('error')));
            }

            $googleUser = Socialite::driver('google')->user();
            
            // Find or create user
            $user = User::where('google_id', $googleUser->getId())
                       ->orWhere('email', $googleUser->getEmail())
                       ->first();

            if ($user) {
                // Update existing user with Google info if needed
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(24)), // Random password for security
                    'email_verified_at' => now(), // Auto-verify email for Google users
                ]);
            }

            // Log the user in
            Auth::login($user, true);

            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . $user->name . '!');
            
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect('/login')->with('error', 'Unable to login with Google. Please try again. Error: ' . $e->getMessage());
        }
    }
}
