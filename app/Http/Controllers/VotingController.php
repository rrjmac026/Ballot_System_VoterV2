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
    private function generateTransactionNumber() 
    {
        do {
            $prefix = 'TXN';
            $date = now()->format('Ymd');
            $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $transactionNumber = "{$prefix}-{$date}-{$random}";
        } while (CastedVote::where('transaction_number', $transactionNumber)->exists());
        
        return $transactionNumber;
    }

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
        $voter = Auth::user(); 

        DB::beginTransaction();
        try {
            if (CastedVote::where('voter_id', $voter->voter_id)->exists()) {
                throw new \Exception('You have already voted. Multiple votes are not allowed.');
            }

            $request->validate([
                'votes' => ['required', 'array'],
                'votes.*' => ['required', 'exists:candidates,candidate_id']
            ]);

            $transactionNumber = $this->generateTransactionNumber();

            foreach ($request->votes as $positionId => $candidateId) {
                try {
                    CastedVote::create([
                        'voter_id' => $voter->voter_id,
                        'position_id' => $positionId,
                        'candidate_id' => $candidateId,
                        'vote_hash' => CastedVote::hashVote($candidateId),
                        'voted_at' => now(),
                        'transaction_number' => $transactionNumber
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    throw new \Exception('You can only vote once per position.');
                }
            }

            DB::commit();
            return redirect()->route('voter.voting.confirmation')
                ->with('success', 'Your vote has been successfully submitted!')
                ->with('transaction_number', $transactionNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Voting Error: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
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
