<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable=['name','data', 'status', 'created_at','updated_at'];

    public static $status = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];
}
