<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PositionStep extends Model
{
    protected $table = 'position_steps';

    protected $fillable=['position_id','sort','name', 'amount', 'status','image', 'created_at', 'updated_at'];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
    ];

    public static $path = 'Position_image';
}
