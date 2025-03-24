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
        $prefix = 'TXN';
        $date = now()->format('Ymd');
        $lastTransaction = CastedVote::whereDate('created_at', today())
            ->orderBy('transaction_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->transaction_number, -4));
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return "{$prefix}-{$date}-{$nextNumber}";
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
            // Check if voter already voted
            if (CastedVote::where('voter_id', $voter->voter_id)->exists()) {
                throw new \Exception('You have already voted. Multiple votes are not allowed.');
            }

            $request->validate([
                'votes' => ['required', 'array'],
                'votes.*' => ['required', 'exists:candidates,candidate_id']
            ]);

            // Generate one transaction number for all votes
            $transactionNumber = $this->generateTransactionNumber();
            $now = now();

            // Prepare all votes with the same transaction number
            $votesToInsert = [];
            foreach ($request->votes as $positionId => $candidateId) {
                $votesToInsert[] = [
                    'voter_id' => $voter->voter_id,
                    'position_id' => $positionId,
                    'candidate_id' => $candidateId,
                    'vote_hash' => CastedVote::hashVote($candidateId),
                    'voted_at' => $now,
                    'transaction_number' => $transactionNumber,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // Insert all votes at once
            CastedVote::insert($votesToInsert);

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
