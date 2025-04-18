<?php
namespace App\Http\Controllers;

use App\Models\CastedVote;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    private function generateTransactionNumber()
    {
        $voter    = Auth::user();
        $prefix   = 'BUKSU';
        $year     = now()->format('Y');
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
        $voter      = Auth::user();
        $hasVoted   = CastedVote::where('voter_id', $voter->voter_id)->exists();
        $castedVote = CastedVote::where('voter_id', $voter->voter_id)->first();
        $votes      = $castedVote ? json_decode($castedVote->votes, true) : [];

        // Get voter's year level as number
        $voterYear = (int) str_replace(['st', 'nd', 'rd', 'th'], '', $voter->year_level);

                                                                 // Define position IDs
        $globalPositionIds         = [1, 2, 3];                  // President, VP, Senator
        $representativePositionIds = [12, 13, 14];               // 2nd, 3rd, 4th Year Representatives
        $collegeOfficerPositionIds = [4, 5, 6, 7, 8, 9, 10, 11]; // Governor to PRO

        // Get global positions
        $globalPositions = Position::whereIn('position_id', $globalPositionIds)
            ->with(['candidates.partylist', 'candidates.organization'])
            ->orderBy('position_id')
            ->get();

        // Get college positions including officers and representatives
        $collegePositions = Position::query()
            ->where(function ($query) use ($collegeOfficerPositionIds, $representativePositionIds, $voterYear) {
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
        $now   = now();

        DB::beginTransaction();
        try {
            if (CastedVote::where('voter_id', $voter->voter_id)->exists()) {
                throw new \Exception('You have already voted.');
            }

            $transactionNumber = $this->generateTransactionNumber();

            // Get all available positions
            $availablePositions = $this->getAvailablePositions($voter);

            // Initialize votes array if null
            $votes = $request->votes ?? [];

            // Process all positions (voted and abstained)
            foreach ($availablePositions as $positionId) {
                if (! isset($votes[$positionId])) {
                    // Handle abstain vote
                    CastedVote::create([
                        'transaction_number' => $transactionNumber,
                        'voter_id'           => $voter->voter_id,
                        'position_id'        => $positionId,
                        'candidate_id'       => null, // null for abstain
                        'vote_hash'          => CastedVote::hashVote("abstain-{$positionId}"),
                        'voted_at'           => $now,
                        'ip_address'         => $request->ip(),
                        'user_agent'         => $request->userAgent(),
                    ]);
                } else {
                    // Handle actual votes
                    $candidateIds = $votes[$positionId];
                    if ($positionId == 3) { // Senator position
                                                // Handle senator votes (array)
                        $senatorIds = is_array($candidateIds) ? $candidateIds : [];
                        foreach ($senatorIds as $candidateId) {
                            CastedVote::create([
                                'transaction_number' => $transactionNumber,
                                'voter_id'           => $voter->voter_id,
                                'position_id'        => $positionId,
                                'candidate_id'       => $candidateId,
                                'vote_hash'          => CastedVote::hashVote($candidateId),
                                'voted_at'           => $now,
                                'ip_address'         => $request->ip(),
                                'user_agent'         => $request->userAgent(),
                            ]);
                        }
                    } else {
                        // Handle single position votes
                        CastedVote::create([
                            'transaction_number' => $transactionNumber,
                            'voter_id'           => $voter->voter_id,
                            'position_id'        => $positionId,
                            'candidate_id'       => $candidateIds,
                            'vote_hash'          => CastedVote::hashVote($candidateIds),
                            'voted_at'           => $now,
                            'ip_address'         => $request->ip(),
                            'user_agent'         => $request->userAgent(),
                        ]);
                    }
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

    private function getAvailablePositions($voter)
    {
        $globalPositionIds         = [1, 2, 3];                  // President, VP, Senator
        $collegeOfficerPositionIds = [4, 5, 6, 7, 8, 9, 10, 11]; // Governor to PRO

        $positions = collect($globalPositionIds)
            ->merge($collegeOfficerPositionIds);

        // Add year representative position if applicable
        $voterYear = (int) str_replace(['st', 'nd', 'rd', 'th'], '', $voter->year_level);
        if ($voterYear < 4) {
            $positions->push($voterYear + 11); // Maps to correct representative ID
        }

        return $positions->toArray();
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
