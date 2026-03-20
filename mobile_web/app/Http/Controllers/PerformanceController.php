<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {

        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user

        if ($loggedUser->position_id == 4 || $loggedUser->position_id == 2) {
            // Get the selected IB (user id) from the query parameter.
            $selectedIbId = $request->get('ib'); // Might be empty string or null

            // Only override if the parameter is not null and not an empty string.
            if ($selectedIbId !== null && trim($selectedIbId) !== '') {
                $selectedUser = DB::table('users')
                    ->where('id', $selectedIbId)
                    ->first();

                if ($selectedUser) {
                    $user = $selectedUser;
                }
            }
        }



        // Get the selected year from the query string, default to current year
        $year = $request->query('year', Carbon::now()->year);
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // For the current year: process months from January up to current month.
        // For previous years: process all 12 months.
        $monthRange = ($year == $currentYear) ? range(1, $currentMonth) : range(1, 12);

        // Initialize array to store performance data (in ascending order)
        $performanceData = [];

        foreach ($monthRange as $m) {
            // Determine the start and end dates for the month
            $startDate = Carbon::create($year, $m, 1)->startOfMonth();
            $endDate   = Carbon::create($year, $m, 1)->endOfMonth();

            // Query for personal Approve sales for current user
            $personalSales = DB::table('sales')
                ->where('user_id', $user->id)
                ->where('sales_status', 'Approve')
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('amount');

            // Query for new clients for current user (count distinct client IDs)
            $newClients = DB::table('clients')
                ->where('user_id', $user->id) // Ensure the client is linked to the current user
                ->whereBetween('created_at', [$startDate, $endDate])
                ->distinct('id')
                ->count();

            // For Senior view (position_id == 2/4), query team sales (only Approve)
            if ($user->position_id == 2 || $user->position_id == 4) {
                $teamSales = DB::table('sales')
                    ->join('users', 'sales.user_id', '=', 'users.id')
                    ->where('users.team_id', $user->team_id)
                    ->where('sales.sales_status', 'Approve')
                    ->whereBetween('sales.date', [$startDate, $endDate])
                    ->sum('sales.amount');
            } else {
                $teamSales = null;
            }

            // Calculate projected commissions as 30% of personal sales
            $projectedComm = $personalSales * 0.3;

            // Query for volume (lots) from the lots table for the current user
            $volumeLots = DB::table('lots')
                ->where('user_id', $user->id)
                ->whereBetween('lots_date', [$startDate, $endDate])
                ->sum('lots');

             // Query for volume (lots) from the lots table for the current user
            $volumeGroups = DB::table('lots')
                ->where('user_id', $user->id)
                ->whereBetween('lots_date', [$startDate, $endDate])
                ->sum('group');
            
             // Query for volume (lots) from the lots table for the current user
            $volumeSelfs = DB::table('lots')
                ->where('user_id', $user->id)
                ->whereBetween('lots_date', [$startDate, $endDate])
                ->sum('self');

            // Get the month name (e.g., "January", "February", etc.)
            $monthName = Carbon::createFromDate(null, $m, 1)->format('F');

            // Save raw values for percentage calculations along with formatted values
            $performanceData[$m] = [
                'month_name'          => $monthName,
                'personal_sales_raw'  => $personalSales,
                'new_clients_raw'     => $newClients,
                'team_sales_raw'      => $teamSales,
                'volume_lots_raw'     => $volumeLots,
                'volume_groups_raw'   => $volumeGroups,
                'volume_selfs_raw'    => $volumeSelfs,
                'personal_sales'      => '$' . number_format($personalSales, 2),
                'new_clients'         => $newClients,
                'team_sales'          => $user->position_id == 2 ? '$' . number_format($teamSales, 2) : null,
                'projected_comm'      => $projectedComm,
                'volume_lots'         => $volumeLots,
                'volume_groups'       => $volumeGroups,
                'volume_selfs'        => $volumeSelfs,
                // Placeholder for percentage change (to be filled below)
                'percentage_change'   => [
                    'personal_sales' => '0%',
                    'new_clients'    => '0%',
                    'team_sales'     => $user->position_id == 2 ? '0%' : null,
                    'volume'         => '0%',
                ],
            ];
        }

        // Calculate percentage changes for each month (except the first month in the range)
        foreach ($performanceData as $m => &$data) {
            if ($m == min($monthRange)) {
                // No previous month data for the first month.
                $data['percentage_change'] = [
                    'personal_sales' => '0%',
                    'new_clients'    => '0%',
                    'team_sales'     => $user->position_id == 2 ? '0%' : null,
                    'volume_lots'         => '0%',
                    'volume_groups'         => '0%',
                    'volume_selfs'         => '0%',
                ];
            } else {
                // Get previous month's data
                $prev = $performanceData[$m - 1];

                $personalChange = $this->calculatePercentageChange($prev['personal_sales_raw'], $data['personal_sales_raw']);
                $newClientsChange = $this->calculatePercentageChange($prev['new_clients_raw'], $data['new_clients_raw']);
                $teamChange = $user->position_id == 2
                    ? $this->calculatePercentageChange($prev['team_sales_raw'], $data['team_sales_raw'])
                    : null;
                $volumeChange = $this->calculatePercentageChange($prev['volume_lots_raw'], $data['volume_lots_raw']);
                $groupChange = $this->calculatePercentageChange($prev['volume_groups_raw'], $data['volume_groups_raw']);
                $selfChange = $this->calculatePercentageChange($prev['volume_selfs_raw'], $data['volume_selfs_raw']);

                $data['percentage_change'] = [
                    'personal_sales' => $personalChange,
                    'new_clients'    => $newClientsChange,
                    'team_sales'     => $teamChange,
                    'volume_lots'         => $volumeChange,
                    'volume_groups'         => $groupChange,
                    'volume_selfs'         => $selfChange,
                ];
            }
        }
        unset($data); // Clear reference

        // Reverse the array to display the latest month first
        $performanceData = array_reverse($performanceData, true);

        // Prepare a list of years for the dropdown (current year and two previous years)
        $years = range(Carbon::now()->year, Carbon::now()->year - 2);

        // Retrieve all active users (status = 1) for the dropdown,
        // filtering for position_id in [1, 2, 3, 4] and sorted by firstname.
        // if NOT a Director (position_id ≠ 4) limit to their own team

        // base query
    $activeUsersQuery = DB::table('users')
        ->where('status', 1)
        ->whereIn('position_id', [1, 2, 3, 4]);

        if ($loggedUser->position_id !== 4) {
            $activeUsersQuery->where('team_id', $loggedUser->team_id);
        }

        $activeUsers = $activeUsersQuery
            ->orderBy('firstname', 'asc')
            ->get();



        return view('performance.performance', compact('year', 'years', 'performanceData', 'user', 'activeUsers'));
    }

    /**
     * Calculate percentage change between previous and current values.
     *
     * @param float|int $previous The value from the previous month.
     * @param float|int $current  The value from the current month.
     * @return string Formatted percentage change with "%" symbol.
     */
    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? '100%' : '0%';
        }

        $change = (($current - $previous) / $previous) * 100;
        return number_format($change, 2) . '%';
    }
}
