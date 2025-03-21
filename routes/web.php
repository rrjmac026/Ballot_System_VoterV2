<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VoterDashboardController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;

// ✅ Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Google Authentication (For Voters)
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

// ✅ Protected Routes (Only Authenticated Voters Can Access)
Route::middleware(['auth:voter', 'maintenance'])->group(function () {
    Route::get('/dashboard', [VoterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/voting', [VotingController::class, 'index'])->name('voter.voting');
    Route::post('/voting', [VotingController::class, 'store'])->name('voter.voting.store');
    Route::get('/voting/confirmation', [VotingController::class, 'confirmation'])->name('voter.voting.confirmation');
});


// ✅ Include Authentication Routes (Login, Logout)
require __DIR__.'/auth.php';
