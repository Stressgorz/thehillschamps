<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    protected $table = 'roadmap';

    protected $fillable = [
        'date', 'position_id', 'usd_amount', 'created_at', 'updated_at'
    ];

    public function position()
    {
        return $this->hasOne('App\Models\Position', 'id', 'position_id');
    }
}
