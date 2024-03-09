<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKpi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_kpi';

    protected $fillable = [
        'user_id', 'type', 'data','final_data','status','remarks','attachment', 'created_at' ,'updated_at'
    ];

    public static $type = [
        'IB' => 'IB',
        'Senior' => 'Senior',
        'Leader' => 'Leader',
        'Director' => 'Director',
        'Marketer' => 'Marketer',
    ];

    public static $status = [
        'active' => 1,
        'pending' => 9,
        'removed' => 999,
    ];

            /**
     * The path of the storage folder to store uploaded files.
     *
     * @var string
     */
    public static $path = 'User_Kpi';
    
}
