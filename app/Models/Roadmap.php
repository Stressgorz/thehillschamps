<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    use HasFactory;

    protected $table = 'roadmap';

    // Allow mass-assignment of these fields.
    protected $fillable = [
        'date',
        'position_id',
        'usd_amount',
    ];

}
