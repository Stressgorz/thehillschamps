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
        'user_id', 'name', 'email','contact','address', 'country', 'city', 'state', 'zip', 'upline_client_id','upline_user_id', 'status', 'created_at' ,'updated_at'
    ];

    public static $status = [
        'active' => '1',
        'pending' => '9',
        'inactive' => '999',
    ];

    public function uplineIb(){
        return $this->hasOne('App\User','id','upline_user_id');
    }

    public function IB(){
        return $this->hasOne('App\User','id','user_id');
    }

    public function uplineClient(){
        return $this->hasOne('App\Models\Client','id','upline_client_id');
    }

    public static function searchClientDownline($user_id){
        
        $users = Client::select('id', 'name')->where('upline_user_id', $user_id)
                        ->where('status', Static::$status['active'])
                        ->get();
        $downline = [];

        foreach ($users as $user) {
            $downline[] = [
                'id' => $user->id,
                'user' => $user->name,
                'downline' => static::clientDownline($user->id)
            ];
        }

        return $downline;
    }

    public static function clientDownline($user_id){
        
        $users = Client::select('id', 'name')->where('upline_client_id', $user_id)
                        ->where('status', Static::$status['active'])
                        ->get();
        $downline = [];

        foreach ($users as $user) {
            $downline[] = [
                'id' => $user->id,
                'user' => $user->name,
                'downline' => static::clientDownline($user->id)
            ];
        }

        return $downline;
    }
}
