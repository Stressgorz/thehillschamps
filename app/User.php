<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','role','photo','status','code', 'ib_code','phone', 'dob' ,'email_verified_at', 'firstname' ,'lastname' ,'upline_id' ,'team_id' ,'position_id' ,'points' ,'created_at' ,'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static $status = [
        'active' => '1',
        'inactive' => '9',
        'removed' => '999',
    ];

    public static $role = [
        'active' => 'active',
        'inactive' => 'inactive',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position(){
        return $this->hasOne('App\Models\Position','id','position_id');
    }

    public function team(){
        return $this->hasOne('App\Models\Team','id','team_id');
    }

    public function downlines(){
        return $this->hasMany('App\User','upline_id','id');
    }

    public function upline(){
        return $this->hasOne('App\User','id','upline_id');
    }

    public function sales(){
        return $this->hasMany('App\Models\Sale','user_id','id');
    }

    public function clients(){
        return $this->hasMany('App\Models\Client','user_id','id');
    }
            /**
     * The path of the storage folder to store uploaded files.
     *
     * @var string
     */
    public static $path = 'Profile_Pic';
}
