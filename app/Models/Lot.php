<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User; // Make sure to import the User model

class Lot extends Model
{
    use HasFactory;

    protected $table = 'lots';

    // Allow mass-assignment of these fields.
    protected $fillable = [
        'user_id',
        'lots',
        'group',
        'self',
        'lots_date',
    ];

    /**
     * Get the user that owns the lot.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
