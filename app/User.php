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

    public static function searchIbDownline($user_id){
        
        $users = User::select('id', 'firstname', 'lastname')->where('upline_id', $user_id)
                        ->where('status', Static::$status['active'])
                        ->where('position_id', '!=', 5)
                        ->get();
        $downline = [];

        foreach ($users as $user) {
            $downline[] = [
                'id' => $user->id,
                'user' => $user->firstname.' '.$user->lastname,
                'downline' => static::searchIbDownline($user->id)
            ];
        }

        return $downline;
    }

    public static function searchMarketerDownline($user_id){
        
        $users = User::select('id', 'firstname', 'lastname')->where('upline_id', $user_id)
                        ->where('status', Static::$status['active'])
                        ->where('position_id', '=', 5)
                        ->get();
        $downline = [];

        foreach ($users as $user) {
            $downline[] = [
                'id' => $user->id,
                'user' => $user->firstname.' '.$user->lastname,
                'downline' => static::searchMarketerDownline($user->id)
            ];
        }

        return $downline;
    }


    public static function getAllIbDownline($user_id){
        if($user_id){
            $level = 0;
            $all_level_downline_member[$level][$user_id] = [$user_id];
            $all_downline_member[] = $user_id;

            do{
                $current_level_downline_member = $all_level_downline_member[$level];

                $level++;

                foreach($current_level_downline_member as $upline_member => $downline_members){
                    foreach($downline_members as $upline => $downline_member){
                        $member_list = User::select('id')
                                ->where('upline_id', $downline_member);

                        $member_list = $member_list
                            ->get();

                        $member_list_array = [];

                        foreach($member_list as $under_affiliate){
                            $member_list_array[] = $under_affiliate->id;
                        }

                        if(!empty($member_list_array)){
                            $all_level_downline_member[$level][$downline_member] = $member_list_array;
                            $all_downline_member = array_merge($all_downline_member , $member_list_array);
                        }
                    }
                }
            }
            while(isset($all_level_downline_member[$level]) && !empty($all_level_downline_member[$level]));
        }

        $data = $all_downline_member;

        return $data;
    }
}
