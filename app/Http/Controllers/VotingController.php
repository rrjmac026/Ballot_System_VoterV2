<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Candidate;
use App\Models\CastedVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    /**
     * Show the voting page.
     */
    public function index()
    {
        // Ensure user is authenticated
        $voter = Auth::user();  // ✅ No need for guard('voter')

        // Check if voter has already voted
        $hasVoted = CastedVote::where('voter_id', $voter->voter_id)->exists();

        // Get all positions with their candidates (Eager Loading for efficiency)
        $positions = Position::with(['candidates.partylist', 'candidates.organization'])->get();

        return view('voters.index', compact('positions', 'hasVoted')); // ✅ Corrected View Path
    }

    /**
     * Store voter's votes.
     */
    public function store(Request $request)
    {
        $voter = Auth::user(); // ✅ Ensure authenticated user

        // ✅ Prevent duplicate voting
        if (CastedVote::where('voter_id', $voter->voter_id)->exists()) {
            return back()->with('error', 'You have already voted. Multiple votes are not allowed.');
        }

        // ✅ Validate the request
        $request->validate([
            'votes' => ['required', 'array'],
            'votes.*' => ['required', 'exists:candidates,candidate_id']
        ]);

        // ✅ Begin transaction to ensure atomicity
        DB::beginTransaction();
        try {
            foreach ($request->votes as $positionId => $candidateId) {
                CastedVote::create([
                    'voter_id' => $voter->voter_id,
                    'position_id' => $positionId,
                    'candidate_id' => $candidateId,
                    'vote_hash' => CastedVote::hashVote($candidateId),
                    'voted_at' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('voters.confirmation')->with('success', 'Your vote has been successfully submitted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while casting your vote. Please try again.');
        }
    }

    /**
     * Show vote confirmation page.
     */
    public function confirmation()
    {
        return view('voters.confirmation');
    }
}
