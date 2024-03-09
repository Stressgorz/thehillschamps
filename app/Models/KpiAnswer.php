<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiAnswer extends Model
{
    protected $table = 'kpi_answers';

    protected $fillable = [
        'kpi_id', 'sort','name', 'points', 'status','created_at','updated_at'
    ];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
    ];
}
