<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{

    use Notifiable;

    protected $fillable=['username','password','name','contact','email','status','created_at','updated_at'];

        /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static $status = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];

    public static $role = [
        'admin' => 'admin',
        'sub-admin' => 'sub-admin',
    ];
    
}
