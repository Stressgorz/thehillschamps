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
        'ib' => 'ib',
        'senior' => 'senior',
        'leader' => 'leader',
        'director' => 'director',
    ];

    public static $status = [
        'active' => 1,
        'pending' => 9,
        'removed' => 999,
    ];


    public static $kpi = [
        'ib' => [
            'q1' => [
                'ib_q1_answer1' => '10',
                'ib_q1_answer2' => '20',
                'ib_q1_answer3' => '30',
                'ib_q1_answer4' => '40',
            ],
            'q1' => [
                'ib_q1_answer1' => '20',
                'ib_q1_answer2' => '25',
                'ib_q1_answer3' => '30',
                'ib_q1_answer4' => '35',
            ],
        ],
        'senior' => [
            'q1' => [
                'senior_q1_answer1' => '5',
                'senior_q1_answer2' => '10',
                'senior_q1_answer3' => '15',
                'senior_q1_answer4' => '20',
            ],
            'q1' => [
                'senior_q1_answer1' => '20',
                'senior_q1_answer2' => '30',
                'senior_q1_answer3' => '35',
                'senior_q1_answer4' => '50',
            ],
        ],
    ];
    
}
