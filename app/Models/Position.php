<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable=['name','data','step1', 'step2', 'step3', 'step4', 'step5', 'kpi', 'step1_img','step2_img','step3_img','step4_img','step5_img', 'status', 'created_at','updated_at'];

    public static $status = [
        'active' => '1',
        'inactive' => '9',
    ];

            /**
     * The path of the storage folder to store uploaded files.
     *
     * @var string
     */
    public static $path = 'Position_image';
}
