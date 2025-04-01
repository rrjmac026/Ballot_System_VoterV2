<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Voter extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table      = 'voters';
    protected $primaryKey = 'voter_id';
    public $incrementing  = true;
    protected $keyType    = 'int';

    protected $fillable = [
        'name',
        'sex',
        'student_number',
        'email',
        'google_id',
        'college_id',
        'course',
        'year_level',
        'status',
    ];

    protected $hidden = [
        'passkey',
        'remember_token',
    ];

    /**
     * Define authentication field as email (used for Google Login)
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Disable password authentication (Google OAuth users don't have passwords)
     */
    public function getAuthPassword()
    {
        return null; // ✅ Prevents Laravel from looking for a password
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'voter_id'; // Make sure this matches your primary key column
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
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
