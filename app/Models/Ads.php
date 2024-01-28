<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ads_sub';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email','contact','bank_acc','bank_num','amount', 'file','status', 'reason' ,'date', 'created_at' ,'updated_at'
    ];

    public static $status = [
        'approved' => '1',
        'pending' => '9',
        'reject' => '999',
    ];
}
