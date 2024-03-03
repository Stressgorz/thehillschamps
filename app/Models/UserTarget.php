<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTarget extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_targets';

    protected $fillable=['target', 'user_id', 'status', 'created_at','updated_at'];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
        'removed' => '999',
    ];
    
}
