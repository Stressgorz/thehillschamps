<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mar_sub';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'email','contact', 'remarks','bank_name','bank_acc','upline_id','status', 'reason' ,'date', 'created_at' ,'updated_at'
    ];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
        'removed' => '999',
    ];
}
