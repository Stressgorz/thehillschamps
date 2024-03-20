<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $table = 'kpi';

    protected $fillable = [
        'position_id', 'type', 'sort','name','status','created_at','updated_at'
    ];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
    ];

    public static $type = [
        'selection' => 'selection',
        'text' => 'text',
        'image' => 'image',
    ];
}
