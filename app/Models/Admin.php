<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable=['username','password','name','contact','email','status','created_at','updated_at'];

    public static $status = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];
    
}
