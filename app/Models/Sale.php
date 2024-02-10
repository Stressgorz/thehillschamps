<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'client_id', 'amount','slip','mt4_id','mt4_password','broker', 'broker2','broker_type', 'remark' ,'type', 'sales_status' ,'status' ,'reason' ,'created_at' ,'updated_at', 'date'
    ];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
    ];

    public static $sales_status = [
        'approved' => 'Approve',
        'pending' => 'Pending',
        'reject' => 'Reject',
    ];

    public static $broker = [
        'LRX' => 'LRX',
        'FXP' => 'FXP',
        'Goldstone' => 'Goldstone',
    ];

        /**
     * The path of the storage folder to store uploaded files.
     *
     * @var string
     */
    public static $path = 'Sales_Slip';

    public static $leaderboard_type = [
        'month' => 'month',
        'year' => 'year',
    ];

    public static $leaderboard_data_type = [
        'team' => 'team',
        'user' => 'user',
    ];
}
