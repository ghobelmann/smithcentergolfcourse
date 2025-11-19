<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentEntryController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home and main site pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');
Route::get('/rates', [HomeController::class, 'rates'])->name('rates');
Route::get('/tee-times', [HomeController::class, 'teeTimes'])->name('tee-times');
Route::get('/leagues', [HomeController::class, 'leagues'])->name('leagues');
Route::get('/instruction', [HomeController::class, 'instruction'])->name('instruction');
Route::get('/store', [HomeController::class, 'store'])->name('store');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Debug route to check auth status
Route::get('/debug-auth', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return response()->json([
            'logged_in' => true,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'isAdmin_method' => $user->isAdmin(),
        ]);
    } else {
        return response()->json([
            'logged_in' => false,
            'message' => 'Please log in to access admin features'
        ]);
    }
});



// Temporary route to make current user admin
Route::get('/make-me-admin', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $user->update(['is_admin' => true]);
        return redirect()->route('tournaments.create')
            ->with('success', 'You are now an admin! User: ' . $user->email);
    } else {
        return redirect()->route('login')
            ->with('error', 'Please log in first');
    }
})->middleware('auth');

// Quick login helper for testing (remove in production)
Route::get('/quick-login/{email?}', function ($email = 'greghobelmann@gmail.com') {
    $user = App\Models\User::where('email', $email)->first();
    if ($user) {
        Auth::login($user);
        return redirect()->route('tournaments.create')
            ->with('success', 'Logged in as: ' . $user->name . ' (Admin: ' . ($user->isAdmin() ? 'Yes' : 'No') . ')');
    }
    return redirect()->route('login')->with('error', 'User not found: ' . $email);
});

// Session extension and CSRF refresh endpoint
Route::post('/session/extend', function () {
    if (Auth::check()) {
        // Extend session by updating last activity
        Session::put('last_activity', time());
        Session::regenerateToken(); // Generate new CSRF token
        
        return response()->json([
            'success' => true,
            'message' => 'Session extended successfully',
            'csrf_token' => csrf_token(),
            'expires_at' => now()->addMinutes(config('session.lifetime'))->toISOString()
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Authentication required',
        'redirect' => route('login')
    ], 401);
})->middleware('auth')->name('session.extend');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google OAuth routes
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])
    ->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback'])
    ->name('auth.google.callback');

// Tournament routes (public viewing)
Route::get('tournaments', [TournamentController::class, 'index'])->name('tournaments.index');

// Tournament management (admin only) - MUST come before parameterized routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('tournaments.edit');
    Route::put('tournaments/{tournament}', [TournamentController::class, 'update'])->name('tournaments.update');
    Route::delete('tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');
});

// Tournament routes with parameters (must come after specific routes)
Route::get('tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
Route::get('tournaments/{tournament}/leaderboard', [TournamentController::class, 'leaderboard'])
    ->name('tournaments.leaderboard');
Route::get('tournaments/{tournament}/team-leaderboard', [TournamentController::class, 'teamLeaderboard'])
    ->name('tournaments.team-leaderboard');

// Course management (admin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::get('courses/{course}/setup', [App\Http\Controllers\CourseController::class, 'setup'])->name('courses.setup');
    Route::put('courses/{course}/setup', [App\Http\Controllers\CourseController::class, 'updateSetup'])->name('courses.update-setup');
});

// Team routes
Route::get('tournaments/{tournament}/teams', [TeamController::class, 'index'])
    ->name('teams.index');
Route::get('tournaments/{tournament}/teams/create', [TeamController::class, 'create'])
    ->name('tournaments.teams.create')
    ->middleware('auth');
Route::post('tournaments/{tournament}/teams', [TeamController::class, 'store'])
    ->name('tournaments.teams.store')
    ->middleware('auth');
Route::get('tournaments/{tournament}/teams/{team}', [TeamController::class, 'show'])
    ->name('tournaments.teams.show');
Route::get('tournaments/{tournament}/teams/{team}/edit', [TeamController::class, 'edit'])
    ->name('tournaments.teams.edit')
    ->middleware('auth');
Route::put('tournaments/{tournament}/teams/{team}', [TeamController::class, 'update'])
    ->name('tournaments.teams.update')
    ->middleware('auth');
Route::delete('tournaments/{tournament}/teams/{team}', [TeamController::class, 'destroy'])
    ->name('tournaments.teams.destroy')
    ->middleware('auth');

// Team member management
Route::post('tournaments/{tournament}/teams/{team}/members', [TeamController::class, 'addMember'])
    ->name('teams.add-member')
    ->middleware('auth');
Route::delete('tournaments/{tournament}/teams/{team}/members/{user}', [TeamController::class, 'removeMember'])
    ->name('teams.remove-member')
    ->middleware('auth');

// Simple team routes (without tournament parameter)
Route::get('teams/create', [TeamController::class, 'createSimple'])
    ->name('teams.create')
    ->middleware('auth');
Route::post('teams', [TeamController::class, 'storeSimple'])
    ->name('teams.store')
    ->middleware('auth');
Route::get('teams/{team}', [TeamController::class, 'showSimple'])
    ->name('teams.show');
Route::get('teams/{team}/edit', [TeamController::class, 'edit'])
    ->name('teams.edit')
    ->middleware('auth');
Route::put('teams/{team}', [TeamController::class, 'update'])
    ->name('teams.update')
    ->middleware('auth');

// Team join/leave actions
Route::post('teams/{team}/join', [TeamController::class, 'join'])
    ->name('teams.join')
    ->middleware('auth');
Route::delete('teams/{team}/leave', [TeamController::class, 'leave'])
    ->name('teams.leave')
    ->middleware('auth');

// Tournament entry routes
Route::post('tournaments/{tournament}/register', [TournamentEntryController::class, 'store'])
    ->name('tournaments.register')
    ->middleware('auth');
Route::delete('tournaments/{tournament}/withdraw', [TournamentEntryController::class, 'destroy'])
    ->name('tournaments.withdraw')
    ->middleware('auth');
Route::patch('tournaments/{tournament}/entries/{entry}/check-in', [TournamentEntryController::class, 'checkIn'])
    ->name('tournament-entries.check-in')
    ->middleware('auth');

// Card assignment routes (admin only)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('tournaments/{tournament}/assign-cards', [TournamentEntryController::class, 'assignCards'])
        ->name('tournaments.assign-cards');
});

// Score routes (accessible by entry owners and admins)
Route::get('entries/{entry}/scorecard', [ScoreController::class, 'show'])
    ->name('scores.show')
    ->middleware('auth');
Route::get('entries/{entry}/scores/edit', [ScoreController::class, 'edit'])
    ->name('scores.edit')
    ->middleware('auth');
Route::get('entries/{entry}/scores/mobile', [ScoreController::class, 'mobile'])
    ->name('scores.mobile')
    ->middleware('auth');
Route::put('entries/{entry}/scores', [ScoreController::class, 'update'])
    ->name('scores.update')
    ->middleware('auth');
Route::delete('scores/{score}', [ScoreController::class, 'destroy'])
    ->name('scores.destroy')
    ->middleware('auth');

// Printable scorecard routes (no auth required for printing)
Route::get('entries/{entry}/scorecard/print', [ScoreController::class, 'printable'])
    ->name('scores.print');
Route::get('entries/{entry}/qr', [ScoreController::class, 'qrCode'])
    ->name('scores.qr');
Route::get('tournaments/{tournament}/scorecards/print-all', [ScoreController::class, 'printAll'])
    ->name('tournaments.print-all-scorecards');
Route::get('tournaments/{tournament}/scorecards/combined', [ScoreController::class, 'combinedScorecard'])
    ->name('tournaments.combined-scorecard');

require __DIR__.'/auth.php';

// Session management routes
Route::post('/session/extend', function () {
    return response()->json(['success' => true, 'message' => 'Session extended']);
})->middleware('auth')->name('session.extend');

Route::get('/session/test', function () {
    return view('session-test');
})->middleware('auth')->name('session.test');
