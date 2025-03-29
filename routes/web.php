<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\VoterDashboardController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LogoutController;

// ✅ Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// ✅ Google Authentication (For Voters)
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
Route::get('auth/google/switch', [GoogleAuthController::class, 'switchAccount'])->name('google.switch-account');

// ✅ Protected Routes (Only Authenticated Voters Can Access)
Route::middleware(['auth:voter', 'maintenance'])->group(function () {
    Route::get('/dashboard', [VoterDashboardController::class, 'index'])->name('dashboard');
    Route::get('/voting', [VotingController::class, 'index'])->name('voter.voting');
    Route::post('/voting', [VotingController::class, 'store'])->name('voter.voting.store');
    Route::get('/voting/confirmation', [VotingController::class, 'confirmation'])->name('voter.voting.confirmation');
    Route::get('/voting/generate-transaction', [VotingController::class, 'generateTransaction'])->name('voter.generate-transaction');
    Route::get('/force-logout', [LogoutController::class, 'logout'])->name('logout');
});

// ✅ Include Authentication Routes (Login, Logout)
require __DIR__.'/auth.php';
