<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;

Route::get('/health', function () { return response('ok', 200); });

// Test route untuk cek apakah route berfungsi
Route::get('/test-route', function () {
    return response()->json(['message' => 'Route is working!']);
});

// Test route untuk cek user
Route::get('/test-user-simple/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if ($user) {
        return response()->json([
            'user' => $user
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Test route untuk cek users
Route::get('/test-users', function () {
    $users = \App\Models\User::all();
    return response()->json([
        'count' => $users->count(),
        'users' => $users->toArray()
    ]);
});

// Test route untuk cek API edit
Route::get('/test-api-edit/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if ($user) {
        return response()->json([
            'user' => $user
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Simple API route for testing
Route::get('/api/test-user/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if ($user) {
        return response()->json([
            'user' => $user
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Even simpler test route
Route::get('/test-simple/{id}', function ($id) {
    $user = \App\Models\User::find($id);
    if ($user) {
        return response()->json([
            'user' => $user
        ]);
    }
    return response()->json(['error' => 'User not found'], 404);
});

// Test route untuk cek apakah route berfungsi
Route::get('/test-route', function () {
    return response()->json(['message' => 'Route is working!']);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Direct DB promote endpoint (no auth). Remove after use.
Route::get('/dev/promote-admin-direct', function () {
    $email = 'admin@example.com';
    $updated = \App\Models\User::query()->where('email', $email)->update([
        'role' => 'Administrator',
        'status' => 'Active',
        'tier' => 'Tier 3',
    ]);
    return response()->json(['email' => $email, 'updated' => $updated]);
});

// Temporary one-off: promote specific email to Administrator
Route::get('/dev/promote-admin', function () {
    $email = 'admin@example.com';
    $updated = \App\Models\User::query()->where('email', $email)->update(['role' => 'Administrator']);
    return response()->json(['email' => $email, 'updated' => $updated > 0]);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/dashboard'); });
    Route::get('/dashboard', function () { return view('dashboard-project'); });
    // Temporary: promote currently logged-in user to Administrator for full access
    Route::get('/dev/promote-me', function () {
        $user = auth()->user();
        if ($user) { $user->update(['role' => 'Administrator']); }
        return redirect()->back()->with('success', 'Your role is now Administrator');
    });
    
    // Users Management (Administrator and Management only)
    Route::middleware('role:Administrator,Management')->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // Header menu shortcuts
    Route::get('/profile', fn () => view('pages-profile'));
    Route::get('/settings', fn () => view('pages-profile-setting'));
    Route::get('/subscription', fn () => view('pages-pricing'));
    Route::get('/changelog', fn () => view('pages-timeline'));
    Route::get('/team', [UserController::class, 'index'])->name('users.index');
    Route::get('/apps-team-contact', [UserController::class, 'index']);
    Route::get('/apps-team-lead', function () { return view('apps-team-lead'); });
    Route::get('/apps-team-deal', function () { return view('apps-team-deal'); });
    Route::get('/support', fn () => view('pages-faqs'));
    Route::get('{any}', [DashboardController::class, 'index'])->where('any', '.*');
});

// API Routes for Users
Route::prefix('api')->middleware('auth')->group(function () {
    Route::middleware('role:Administrator,Management')->group(function () {
        Route::get('/users/{id}', [UserController::class, 'apiShow']);
        Route::get('/users/{id}/edit', [UserController::class, 'apiEdit']);
    });
});

// Temporary API route without role middleware for testing
Route::get('/api/users/{id}/edit-test', [UserController::class, 'apiEdit'])->middleware('auth');

Route::fallback(function () {
    return redirect('/login');
});

// Temporary local helper to ensure admin user exists (remove in production)
Route::get('/dev/seed-admin', function () {
    $user = \App\Models\User::query()->updateOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Administrator',
            'password' => 'admin12345', // hashed via cast
            'role' => 'Administrator',
            'status' => 'Active',
            'tier' => 'Tier 3',
        ]
    );
    return response()->json(['ok' => true, 'user_id' => $user->id]);
});
