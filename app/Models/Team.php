<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable=['name', 'status', 'created_at','updated_at'];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
        'removed' => '999',
    ];
}
