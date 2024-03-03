<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserWallet;

class UserPoint extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'amount', 'created_at' ,'updated_at',
    ];

    public static $type = [
        'credit' => 'credit',
        'debit' => 'debit',
    ];
    
    public static function updateUserPoint($user_id, $type, $transaction_type, $amount, $description){

        $data = '';

        $wallet = UserWallet::$wallet['points'];

        $user_point = UserPoint::create([
            'user_id' => $user_id,
            'type' => $type,
            'amount' => $amount,
        ]);

        if($user_point){
            $data = UserWallet::update_wallet(
                $user_id,
                $type,
                $user_point->id,
                $transaction_type,
                $wallet,
                $amount,
                $description
            );
        }

        return $data;
    }
}
