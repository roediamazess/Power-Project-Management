<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserController;

Route::get('/health', function () { return response('ok', 200); });

// Test route untuk cek users
Route::get('/test-users', function () {
    $users = \App\Models\User::all();
    return response()->json([
        'count' => $users->count(),
        'users' => $users->toArray()
    ]);
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/dashboard'); });
    Route::get('/dashboard', function () { return view('dashboard-project'); });
    
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
    Route::get('/apps-crm-contact', function() {
        $users = [];
        try {
            $users = \App\Models\User::all()->toArray();
        } catch (\Exception $e) {
            $users = [];
        }
        return view('apps-crm-contact-test', ['users' => $users]);
    });
    Route::get('/support', fn () => view('pages-faqs'));
    Route::get('{any}', [DashboardController::class, 'index'])->where('any', '.*');
});

// API Routes for Users
Route::prefix('api')->middleware('auth')->group(function () {
    Route::middleware('role:Administrator,Management')->group(function () {
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::get('/users/{user}/edit', [UserController::class, 'edit']);
    });
});

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
        ]
    );
    return response()->json(['ok' => true, 'user_id' => $user->id]);
});
