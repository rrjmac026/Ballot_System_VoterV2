<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Voter;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    /**
     * Redirect voter to Google for authentication.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google's callback and validate voter credentials.
     */
    public function handleGoogleCallback()
    {
        try {
            // Get voter details from Google
            $googleUser = Socialite::driver('google')->user();

            // Check if the voter exists in our database
            $voter = Voter::where('email', $googleUser->getEmail())->first();

            if ($voter) {
                // ✅ Voter found → Log them in
                Auth::login($voter);

                // ✅ Update last login timestamp
                $voter->update(['last_login_at' => now()]);

                return redirect()->route('dashboard')->with('success', 'Login successful!');
            } else {
                // ❌ Voter not found → Return with error message
                return redirect()->route('login')->withErrors([
                    'email' => 'Your email is not registered in the voting system.'
                ]);
            }
        } catch (\Exception $e) {
            // ❌ Error handling (e.g., network error, API failure)
            return redirect()->route('login')->withErrors([
                'google_auth' => 'Google authentication failed. Please try again.'
            ]);
        }
    }
}
