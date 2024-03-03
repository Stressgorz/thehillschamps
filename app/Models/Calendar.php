<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'title', 'user_id', 'type', 'start_time', 'end_time', 'created_at' ,'updated_at'
    ];

    public static $bdcontent = 'Happy Birthday!!';

    public static $type = [
        'content' => 'content',
        'birthday' => 'birthday',
    ];

    public static function addUserDOB($user_id, $date){
        $calendar_exists = Calendar::where('user_id', $user_id)->first();
        if($calendar_exists){

            $calendar_exists->update([
                'title' => static::$bdcontent,
                'type' => static::$type['birthday'],
                'start_time' => $date,
            ]);
        }else{
            Calendar::create([
                'user_id' => $user_id,
                'title' => static::$bdcontent,
                'type' => static::$type['birthday'],
                'start_time' => $date,
            ]);
        }
    }
}
