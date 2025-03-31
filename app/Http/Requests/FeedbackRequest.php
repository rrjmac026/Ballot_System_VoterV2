<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change to true to allow all users to submit feedback
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'feedback' => 'required|string|max:255',                // Feedback should not exceed 255 characters
            'rating'   => 'required|integer|in:1,2,3,4,5|not_in:0', // Rating must be a string and only 1-5 allowed
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'feedback.required' => 'Feedback is required',
            'feedback.max'      => 'Feedback must not exceed 255 characters',
            'rating.required'   => 'Rating is required',
            'rating.in'         => 'Rating must be a value between 1 and 5',
            'rating.not_in'     => 'Please select a star to rate',
        ];
    }
}
