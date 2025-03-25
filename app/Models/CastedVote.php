<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CastedVote extends Model
{
    use HasFactory;

    protected $table = 'casted_votes';
    protected $primaryKey = 'casted_vote_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'voter_id',
        'votes', // Store votes as JSON
        'vote_hash',
        'voted_at',
        'transaction_number'
    ];

    protected $dates = ['voted_at'];

    protected $casts = [
        'votes' => 'array',
    ];

    public static function hashVote($votes)
    {
        return Hash::make(json_encode($votes) . env('APP_KEY'));
    }

    public function voter()
    {
        return $this->belongsTo(Voter::class, 'voter_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
