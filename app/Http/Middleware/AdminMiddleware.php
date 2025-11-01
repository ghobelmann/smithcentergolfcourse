<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Authentication required',
                    'redirect' => route('login')
                ], 401);
            }
            
            return redirect()->route('login')
                ->with('error', 'You must be logged in to access this area.');
        }

        $user = Auth::user();
        if (!$user->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Access denied. Administrator privileges required.',
                    'user_id' => $user->id,
                    'is_admin' => $user->is_admin,
                    'debug_info' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'isAdmin_method' => $user->isAdmin()
                    ]
                ], 403);
            }

            // Log the access attempt for debugging
            \Log::warning('Non-admin user attempted to access admin area', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'url' => $request->url()
            ]);

            return redirect()->route('tournaments.index')
                ->with('error', 'Access denied. Only administrators can create tournaments. Current user: ' . $user->email . ' (Admin: ' . ($user->isAdmin() ? 'Yes' : 'No') . ')');
        }

        return $next($request);
    }
}
