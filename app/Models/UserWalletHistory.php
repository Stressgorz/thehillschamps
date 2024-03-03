<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletHistory extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_wallet_history';

    protected $fillable = [
        'user_id', 'transaction_type', 'transaction_id', 'wallet' ,'prev_balance', 'type', 'amount', 'balance', 'description', 'created_at', 'updated_at'
    ];

    public static $transaction_type = [
        'admin_transfer' => 'admin_transfer',
        'kpi_transfer' => 'kpi_transfer',
    ];
    
}
