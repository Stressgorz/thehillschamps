<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User; // Make sure to import the User model

class Wtt extends Model
{
    use HasFactory;

    protected $table = 'wtt';

    // Allow mass-assignment of these fields.
    protected $fillable = [
        'user_id',
        'wtt',
        'wtt_date',
    ];

    /**
     * Get the user that owns the wtt.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
