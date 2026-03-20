<?php

// app/Models/Sale.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural form of the model name
    protected $table = 'sales';

    // Specify the fillable columns for mass assignment
    protected $fillable = [
        'user_id', 'client_id', 'amount', 'slip', 'mt4_id', 'mt4_pass', 
        'broker_type', 'remark', 'type', 'sales_status', 'status', 'reason', 'date'
    ];

    // Define any relationships, for example, if you have a User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define relationship with Client if you have a Client model
    // public function client()
    // {
    //     return $this->belongsTo(Client::class);
    // }
}

