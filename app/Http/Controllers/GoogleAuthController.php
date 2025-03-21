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
            // Get Google User details
            $googleUser = Socialite::driver('google')->user();

            // Check if the voter exists in the VOTERS table
            $voter = Voter::where('email', $googleUser->getEmail())->first();

            if ($voter) {
                // ✅ Ensure that google_id is updated (so voter can log in again next time)
                $voter->update([
                    'google_id' => $googleUser->getId(), // Store Google ID
                    'last_login_at' => now() // Update last login timestamp
                ]);

                // ✅ Log in the voter using the voter guard
                Auth::guard('voter')->login($voter);

                return redirect()->route('dashboard')->with('success', 'Login successful!');
            } else {
                return redirect()->route('login')->withErrors([
                    'email' => 'Your email is not registered in the voter system.'
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google_auth' => 'Google authentication failed. Please try again.'
            ]);
        }
    }

}
