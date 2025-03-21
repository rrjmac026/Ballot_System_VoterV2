<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Voter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'voters';
    protected $primaryKey = 'voter_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'student_number',
        'email',
        'college_id',
        'course',
        'year_level',
        'status',
        'passkey'
    ];

    protected $hidden = [
        'passkey',
        'remember_token',
    ];

    /**
     * Get the password for authentication.
     */
    public function getAuthPassword()
    {
        return $this->passkey;  // Changed from attributes['passkey']
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the login username to be used by the controller.
     */
    public function username()
    {
        return 'student_number';
    }

    /**
     * Override the default password column name
     */
    public function getAuthPasswordName()
    {
        return 'passkey';
    }

    /**
     * Mutator to automatically hash the passkey
     */
    public function setPasskeyAttribute($value)
    {
        $this->attributes['passkey'] = bcrypt($value);
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }

    public function candidate()
    {
        return $this->hasOne(Candidate::class, 'voter_id');
    }

    public function castedVotes()
    {
        return $this->hasMany(CastedVote::class, 'voter_id');
    }
}
