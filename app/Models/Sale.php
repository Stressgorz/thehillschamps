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
        'active' => 'active',
        'inactive' => 'inactive',
    ];

    public static $sales_status = [
        'approved' => 'approved',
        'pending' => 'pending',
        'reject' => 'reject',
    ];

    public static $broker = [
        'LRX' => 'LRX',
        'FXP' => 'FXP',
        'Goldstone' => 'Goldstone',
    ];
}
