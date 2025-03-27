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
        $voter = Auth::user();
        $prefix = 'BUKSU';
        $year = now()->format('Y');
        $paddedId = str_pad($voter->voter_id, 4, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$year}-{$paddedId}";
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

            $transactionNumber = $this->generateTransactionNumber();
            $voterYear = (int)str_replace(['st', 'nd', 'rd', 'th'], '', $voter->year_level);

            // Get all positions available to the voter
            $globalPositionIds = [1, 2, 3]; // President, VP, Senator
            $collegeOfficerPositionIds = [4, 5, 6, 7, 8, 9, 10, 11]; // Governor to PRO
            
            $availablePositions = collect($globalPositionIds)
                ->merge($collegeOfficerPositionIds);
                
            // Add year representative position if applicable
            if ($voterYear < 4) {
                $allowedRepId = $voterYear + 11; // Maps to correct representative ID (12, 13, 14)
                $availablePositions->push($allowedRepId);
            }

            // If no votes submitted, create abstain records for all positions
            if (empty($request->votes)) {
                foreach ($availablePositions as $positionId) {
                    CastedVote::create([
                        'transaction_number' => $transactionNumber,
                        'voter_id' => $voter->voter_id,
                        'position_id' => $positionId,
                        'candidate_id' => null,
                        'vote_hash' => CastedVote::hashVote("abstain-{$positionId}"),
                        'voted_at' => $now,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]);
                }
            } else {
                // For partial voting, create records for both voted and abstained positions
                foreach ($availablePositions as $positionId) {
                    CastedVote::create([
                        'transaction_number' => $transactionNumber,
                        'voter_id' => $voter->voter_id,
                        'position_id' => $positionId,
                        'candidate_id' => $request->votes[$positionId] ?? null,
                        'vote_hash' => CastedVote::hashVote($request->votes[$positionId] ?? "abstain-{$positionId}"),
                        'voted_at' => $now,
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]);
                }
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

    public function confirmation()
    {
        $voter = Auth::user();
        $votes = CastedVote::where('voter_id', $voter->voter_id)
            ->with(['position', 'candidate.partylist'])
            ->get();

        return view('voters.confirmation', compact('votes'));
    }
}