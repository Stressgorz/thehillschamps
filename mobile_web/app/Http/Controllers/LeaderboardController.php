<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        // Get selected month from query string; default to current month (two-digit string)
        $selectedMonth = $request->query('month', Carbon::now()->format('m'));

        // For this example, we'll use the current year. Adjust if you require a year filter.
        $year = Carbon::now()->year;

        // Convert selected month to an integer
        $monthInt = (int)$selectedMonth;

        // Define start and end date for the selected month
        $startDate = Carbon::create($year, $monthInt, 1)->startOfMonth();
        $endDate   = Carbon::create($year, $monthInt, 1)->endOfMonth();

        // Query the 'sales' table to aggregate approved sales per user within the given month
        $aggregatedSales = DB::table('sales')
            ->select(DB::raw('SUM(amount) as total_sales, user_id'))
            ->where('sales_status', 'Approve')
            ->whereBetween('sales.date', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderBy('total_sales', 'desc')
            ->limit(30)
            ->get();

        $salesPerformance = [];

        // For each aggregated record, fetch user info and build an entry for the leaderboard
        foreach ($aggregatedSales as $record) {
            // Fetch the corresponding user from the 'users' table
            $user = DB::table('users')->where('id', $record->user_id)->first();
            if (!$user) {
                continue;
            }

            // Build the user's full name
            $fullName = $user->firstname . ' ' . $user->lastname;

            // Map the user's position_id to a role name
            $roles = [
                1 => 'IB',
                2 => 'Senior',
                3 => 'Leader',
                4 => 'Director',
                5 => 'Marketer',
            ];
            $role = isset($roles[$user->position_id]) ? $roles[$user->position_id] : 'Unknown';

            // Prepare an entry for this user
            $salesPerformance[] = [
                'name'   => $fullName,
                'role'   => $role,
                'amount' => $record->total_sales,
                'photo'  => $user->photo,
            ];

            
        }

        // Pass the leaderboard data and the selected month to the view
        return view('leaderboard.leaderboard', compact('salesPerformance', 'selectedMonth'));
    }
}
