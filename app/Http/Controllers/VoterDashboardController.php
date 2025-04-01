<?php
namespace App\Http\Controllers;

use App\Models\CastedVote;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VoterDashboardController extends Controller
{
    public function index(): View
    {
        $voter       = Auth::user();
        $castedVotes = CastedVote::where('voter_id', $voter->voter_id)
            ->with(['position', 'candidate.partylist'])
            ->get();

        $firstVote         = $castedVotes->first();
        $transactionNumber = $firstVote ? $firstVote->transaction_number : null;
        $votedAt           = $firstVote ? Carbon::parse($firstVote->voted_at) : null;

        return view('dashboard', compact('castedVotes', 'transactionNumber', 'votedAt'));
    }
}
