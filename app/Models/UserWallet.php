<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserWallet extends Model
{
    protected $table = 'user_wallets';

    protected $fillable = [
        'user_id', 'wallet', 'balance', 'created_at' ,'updated_at'
    ];

    public static $type = [
        'credit' => 'credit',
        'debit' => 'debit',
    ];

    public static $wallet = [
        'points' => 'points',
    ];

    public function get_balance($user_id, $wallet = '')
    {

        return $this->get_connection_balance($user_id, $wallet);
    }

    public function get_connection_balance($user_id, $wallet = '')
    {
        if ($wallet) {
            $result = DB::table('user_wallets')
                        ->where('user_id', $user_id)
                        ->where('wallet', $wallet)
                        ->first();
            $balance = $result->balance ?? 0;
        } else {
            $result = DB::table('user_wallets')
                        ->where('user_id', $user_id)
                        ->select('wallet', 'balance')
                        ->get();
            $balance = [];
            foreach ($result as $value) {
                $balance[$value->wallet] = $value->balance;
            }
        }
        
        return $balance;
    }

        /**
     * Update the wallets and insert wallet history for a user.
     *
     * @return \App\UserWalletHistory
     */
    public static function update_wallet($user_id, $type, $transaction_id = 0, $transaction_type = '', $wallet, $amount, $description = '')
    {
        $query = DB::table('user_wallets')
                    ->where('user_id', $user_id)
                    ->where('wallet', $wallet);

        $user_wallet = $query->first();
        // Wallet not exist proceed to create it
        if ($user_wallet === null) {
            $prev_balance = 0;
            $balance = 0;

            if ($type == static::$type['credit']) {
                $balance += $amount;
            } elseif ($type == static::$type['debit']) {
                $balance -= $amount;
            }

            // Since wallet not exist so the type is credit
            UserWallet::create([
                'user_id' => $user_id,
                'wallet' => $wallet,
                'balance' => $balance,
            ]);
        } else {
            $prev_balance = $user_wallet->balance;
            $balance = $user_wallet->balance;
            if ($type == static::$type['credit']) {
                $balance += $amount;
            } elseif ($type == static::$type['debit']) {
                // debit
                $balance -= $amount;
            } 
            // else {
            //     throw ValidationException::withMessages([
            //         'general' => [trans('validation.invalid_user_wallet_history_type')],
            //     ]);
            // }

            $query->update([
                'balance' => $balance,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        $history = UserWalletHistory::create([
            'user_id' => $user_id,
            'transaction_type' => $transaction_type,
            'transaction_id' => $transaction_id,
            'wallet' => $wallet,
            'prev_balance' => $prev_balance,
            'type' => $type,
            'amount' => $amount,
            'balance' => $balance,
            'description' => $description,
        ]);

        return $history;
    }

}
