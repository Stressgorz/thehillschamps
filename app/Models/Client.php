<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email','contact','address','upline_client_id','upline_user_id', 'status', 'created_at' ,'updated_at'
    ];

    public static $status = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];
}
