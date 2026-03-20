<?php
//app/Models/Performance.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_sales',
        'personal_sales',
        'new_clients',
        'projected_comms',
        'volume_lots',
        'month',
        'year'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to get performance for a specific user and year
    public static function getPerformanceData($userId, $year)
    {
        return self::where('user_id', $userId)
            ->where('year', $year)
            ->get();
    }
}
