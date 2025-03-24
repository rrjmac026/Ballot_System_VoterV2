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
     * Generate transaction number via AJAX
     */
    public function generateTransaction()
    {
        try {
            $transactionNumber = $this->generateTransactionNumber();
            return response()->json(['transaction_number' => $transactionNumber]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
        $now = now();

        DB::beginTransaction();
        try {
            if (CastedVote::where('voter_id', $voter->voter_id)->exists()) {
                throw new \Exception('You have already voted.');
            }

            $transactionNumber = $request->transaction_number;

            // Record voter access even without votes
            $baseRecord = [
                'voter_id' => $voter->voter_id,
                'transaction_number' => $transactionNumber,
                'voted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (!empty($request->votes)) {
                $votesToInsert = [];
                foreach ($request->votes as $positionId => $candidateId) {
                    $votesToInsert[] = array_merge($baseRecord, [
                        'position_id' => $positionId,
                        'candidate_id' => $candidateId,
                        'vote_hash' => CastedVote::hashVote($candidateId),
                    ]);
                }
                CastedVote::insert($votesToInsert);
            } else {
                // Create a record with just transaction number for tracking
                CastedVote::create($baseRecord);
            }

            DB::commit();
            return redirect()->route('voter.voting.confirmation')
                ->with('success', 'Your ballot has been recorded.')
                ->with('transaction_number', $transactionNumber);

        } catch (\Exception $e) {
            DB::rollBack();
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
