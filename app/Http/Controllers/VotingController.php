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

    public function generateTransaction()
    {
        try {
            $transactionNumber = $this->generateTransactionNumber();
            return response()->json(['transaction_number' => $transactionNumber]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $voter = Auth::user();  
        $hasVoted = CastedVote::where('voter_id', $voter->voter_id)->exists();
        $castedVote = CastedVote::where('voter_id', $voter->voter_id)->first();
        $votes = $castedVote ? json_decode($castedVote->votes, true) : [];

        // Get voter's year level as number
        $voterYear = (int)str_replace(['st', 'nd', 'rd', 'th'], '', $voter->year_level);

        // Define position IDs
        $globalPositionIds = [1, 2, 3]; // President, VP, Senator
        $representativePositionIds = [12, 13, 14]; // 2nd, 3rd, 4th Year Representatives
        $collegeOfficerPositionIds = [4, 5, 6, 7, 8, 9, 10, 11]; // Governor to PRO

        // Get global positions
        $globalPositions = Position::whereIn('position_id', $globalPositionIds)
            ->with(['candidates.partylist', 'candidates.organization'])
            ->orderBy('position_id')
            ->get();

        // Get college positions including officers and representatives
        $collegePositions = Position::query()
            ->where(function($query) use ($collegeOfficerPositionIds, $representativePositionIds, $voterYear) {
                // Include college officers (Governor, Vice Gov, etc)
                $query->whereIn('position_id', $collegeOfficerPositionIds);

                // Add representative position based on year level
                if ($voterYear < 4) {
                    $allowedRepId = $voterYear + 11; // Maps to correct representative ID (12, 13, 14)
                    $query->orWhere('position_id', $allowedRepId);
                }
            })
            ->with(['candidates.partylist', 'candidates.organization'])
            ->orderBy('position_id')
            ->get();

        return view('voters.index', compact('globalPositions', 'collegePositions', 'votes', 'hasVoted'));
    }

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
            $votes = [];
            if (!empty($request->votes)) {
                foreach ($request->votes as $positionId => $candidateId) {
                    $votes[$positionId] = $candidateId;
                }
            }

            CastedVote::create([
                'voter_id' => $voter->voter_id,
                'votes' => json_encode($votes),
                'vote_hash' => CastedVote::hashVote($votes),
                'transaction_number' => $transactionNumber,
                'voted_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::commit();
            return redirect()->route('voter.voting.confirmation')
                ->with('success', 'Your ballot has been recorded.')
                ->with('transaction_number', $transactionNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirmation()
    {
        $voter = Auth::user();
        $castedVote = CastedVote::where('voter_id', $voter->voter_id)->first();
        $votes = $castedVote ? json_decode($castedVote->votes, true) : [];

        return view('voters.confirmation', compact('votes'));
    }
}