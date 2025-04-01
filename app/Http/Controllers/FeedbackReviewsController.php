<?php
namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Exception;
use Illuminate\Support\Facades\Auth;

class FeedbackReviewsController extends Controller
{

    public function store(FeedbackRequest $request)
    {
        try {
            // Check if the user has already submitted feedback
            $existingFeedback = Feedback::where('voter_id', Auth::id())->first();

            if ($existingFeedback) {
                return redirect()->route('dashboard')->with('error', 'You already Submitted your Feedback!');
            }

            // Prepare data for feedback
            $data = [
                'voter_id' => Auth::id(),
                'feedback' => $request->feedback,
                'rating'   => $request->rating,
            ];

            // Store feedback in the database
            Feedback::create($data);

            return redirect()->route('dashboard')->with('success', 'Feedback submitted successfully');
        } catch (Exception $e) {
            // Return the error message for debugging
            return redirect()->route('dashboard')->with('error', 'Oops! Something went wrong. Please try again later.');
        }
    }

}
