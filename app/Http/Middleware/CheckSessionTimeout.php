<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionTimeout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            $sessionLifetime = config('session.lifetime') * 60; // Convert minutes to seconds
            
            if ($lastActivity && (time() - $lastActivity > $sessionLifetime)) {
                // Session has expired
                Auth::logout();
                Session::flush();
                Session::regenerate();
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Your session has expired. Please log in again.',
                        'redirect' => route('login')
                    ], 419);
                }
                
                return redirect()->route('login')
                    ->with('error', 'Your session has expired due to inactivity. Please log in again.');
            }
            
            // Update last activity timestamp
            Session::put('last_activity', time());
        }

        return $next($request);
    }
}
