<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description','content', 'date','status', 'created_at' ,'updated_at'
    ];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
        'removed' => '999',
    ];
}
