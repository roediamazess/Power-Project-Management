<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/health', function () { return response('ok', 200); });

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', function () { return redirect('/dashboard'); });
    Route::get('/dashboard', function () { return view('dashboard-project'); });
    // Header menu shortcuts
    Route::get('/profile', fn () => view('pages-profile'));
    Route::get('/settings', fn () => view('pages-profile-setting'));
    Route::get('/subscription', fn () => view('pages-pricing'));
    Route::get('/changelog', fn () => view('pages-timeline'));
    Route::get('/team', fn () => view('apps-crm-contact'));
    Route::get('/support', fn () => view('pages-faqs'));
    Route::get('{any}', [DashboardController::class, 'index'])->where('any', '.*');
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
