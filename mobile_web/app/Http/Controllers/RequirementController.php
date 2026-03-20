<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequirementController extends Controller
{

    // Index method: determines user rank and dispatches to the proper view.
    public function index(Request $request)
    {
        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user

        if ($loggedUser->position_id == 4) {
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

        $userId = $user->id;
        // Get user rank from users table (assume column "position_id")
        $positionId = DB::table('users')
            ->where('id', $userId)
            ->value('position_id');

        // For example, assume:
        // IB      => position_id = 1
        // Senior  => position_id = 2
        // Marketer=> position_id = 5


        if ($positionId == 1) {
            return $this->viewIBRequirement($request);
        } elseif ($positionId == 2) {
            return $this->viewSeniorRequirement($request);
        } elseif ($positionId == 5) {
            return $this->viewMKTRequirement($request);
        } else {
            // Default to senior view if undefined
            return $this->viewSeniorRequirement($request);
        }
    }



    // --------------------------
    // New IB Requirement Method for IB Users
    // --------------------------
    public function viewIBRequirement(Request $request)
    {
         // 1) Identify the logged-in user & team
         $loggedUser = auth()->user();
         $user = $loggedUser; // default to logged-in user
 
         if ($loggedUser->position_id == 4) {
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
 
         $userId = $user->id;
        // For IB, we will use the lots table instead of sales.
        // Default year is 2025 and quarter is current if not provided.
        $selectedYear = $request->input('selectedYear', 2025);
        $selectedQuarter = $request->input('selectedQuarter', $this->getCurrentQuarter());

        // Determine quarter start and end based on the quarter range.
        [$startMonth, $endMonth] = $this->getQuarterMonthRange($selectedQuarter);
        $quarterStart = Carbon::create($selectedYear, $startMonth, 1)->startOfMonth();
        $quarterEnd   = Carbon::create($selectedYear, $endMonth, 1)->endOfMonth();

        // Query the lots table for the logged-in IB.
        // We assume IB trading volume is stored in the column "lots" and the date column is "lots_date".
        $totalLots = DB::table('lots')
            ->where('user_id', $userId)
            ->whereBetween('lots_date', [$quarterStart, $quarterEnd])
            ->sum('lots');

        // Set a target—for example, 500 lots.
        $lotTarget = 500;

        // Determine IB status based on lots and whether the quarter is over.
        $today = Carbon::today();
        if ($today->lt($quarterEnd)) {
            // If the quarter is still in progress:
            $ibStatus = ($totalLots >= $lotTarget) ? 'Pass' : 'In Progress';
        } else {
            // Quarter completed – no in progress now.
            $ibStatus = ($totalLots >= $lotTarget) ? 'Pass' : 'Fail';
        }

        $activeUsers = DB::table('users')
            ->where('status', 1)
            
            ->orderBy('firstname', 'asc')
            ->get();

        return view('requirement.ib-requirement', [
            'selectedYear'    => $selectedYear,
            'selectedQuarter' => $selectedQuarter,
            'totalLots'       => $totalLots,
            'lotTarget'       => $lotTarget,
            'ibStatus'        => $ibStatus,
            'activeUsers'     => $activeUsers,
        ]);
    }

    // --------------------------
    // (Placeholder) MKT Requirement Method
    // --------------------------
    public function viewMKTRequirement(Request $request)
    {
        // 1) Identify the logged-in user & team
        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user

        if ($loggedUser->position_id == 4) {
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

        $userId = $user->id;

        // Define the date range: 30 days before today until today.
        $endDate = Carbon::today(); // today
        $startDate = Carbon::today()->subDays(30);

        // Sum sales for the given user between start and end date.
        $personalSales = DB::table('sales')
            ->where('user_id', $userId)
                ->where('sales_status', 'Approve')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        // Count the number of clients introduced by this marketer.
        // Adjust "clients" and "sponsor_id" if your schema is different.
        $newClients = DB::table('clients')
            ->where('user_id', $userId)
            ->count();


        // 3. Define target values:
        $personalSalesTarget = 3000; // example target for personal sales
        // For new clients, you might define a target (e.g., at least 1 new client)
        $newClientsTarget = 3;

        // 4. Determine statuses:
        // Personal Sales: if personal sales are equal to or above the target, mark as "Pass".
        $personalSalesStatus = ($personalSales >= $personalSalesTarget) ? 'Pass' : 'Fail';
        // New Clients: if new clients count is equal to or above the target, mark as "Pass".
        $newClientsStatus = ($newClients >= $newClientsTarget) ? 'Pass' : 'Fail';

        $activeUsers = DB::table('users')
        ->where('status', 1)
        
        ->orderBy('firstname', 'asc')
        ->get();

        return view('requirement.mkt-requirement', [
            'newClients' => $newClients,
            'personalSales' => $personalSales,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
            'personalSalesStatus'  => $personalSalesStatus,
            'newClientsStatus'     => $newClientsStatus,
            'activeUsers'     => $activeUsers,
        ]);
    }





    public function viewSeniorRequirement(Request $request)
    {
        // 1) Identify the logged-in user & team
        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user

        if ($loggedUser->position_id == 4) {
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

        
        $userId = $user->id;
        $userTeamId = DB::table('users')
            ->where('id', $userId)
            ->value('team_id');

        // 2) Determine the selected Year & Quarter
        // Default year is 2025, quarter = current if none is provided
        $selectedYear    = $request->input('selectedYear', 2025);
        $selectedQuarter = $request->input('selectedQuarter', $this->getCurrentQuarter());

        // 3) Build start/end months & date range for that quarter
        [$startMonth, $endMonth] = $this->getQuarterMonthRange($selectedQuarter);
        $quarterStart = Carbon::create($selectedYear, $startMonth, 1)->startOfMonth();
        $quarterEnd   = Carbon::create($selectedYear, $endMonth, 1)->endOfMonth();

        //---------------------------------------------------------------------
        // A) MONTHLY SALES (Detailed Logic)
        //---------------------------------------------------------------------
        // Each month in the quarter must pass individually.
        // If any completed month fails => "Fail".
        // If any month is still ongoing => "In Progress".
        // If all three months are complete & pass => "Pass".
        $monthlyTarget      = 50000;
        $monthlySalesStatus = $this->getQuarterMonthlySalesStatus(
            $userId,
            $selectedYear,
            $selectedQuarter,
            $monthlyTarget
        );

        // Determine the 3 months in the quarter and their sales sums.
        // For example, Q2 has months 4, 5, and 6.
        $m1 = $startMonth;
        $m2 = $startMonth + 1;
        $m3 = $startMonth + 2;

        $m1Sales = $this->getMonthSales($userId, $selectedYear, $m1);
        $m2Sales = $this->getMonthSales($userId, $selectedYear, $m2);
        $m3Sales = $this->getMonthSales($userId, $selectedYear, $m3);

        // Also get each month's status (Pass/Fail/In Progress)
        $m1Status = $this->getSingleMonthStatus($userId, $selectedYear, $m1, $monthlyTarget);
        $m2Status = $this->getSingleMonthStatus($userId, $selectedYear, $m2, $monthlyTarget);
        $m3Status = $this->getSingleMonthStatus($userId, $selectedYear, $m3, $monthlyTarget);

        //---------------------------------------------------------------------
        // B) GROUP SALES (Simple Quarter Logic)
        //---------------------------------------------------------------------
        // 1) Get all user IDs in the same team
        $teamUserIds = DB::table('users')
            ->where('team_id', $userTeamId)
            ->pluck('id');

        // 2) Sum all sales by those users in the quarter
        $groupSales = DB::table('sales')
            ->whereIn('user_id', $teamUserIds)
                ->where('sales_status', 'Approve')
            ->whereBetween('date', [$quarterStart, $quarterEnd])
            ->sum('amount');

        $quarterGroupSalesTarget = 80000;
        $groupSalesStatus = $this->getQuarterSimpleStatus(
            $groupSales,
            $quarterGroupSalesTarget,
            $quarterEnd
        );

        //---------------------------------------------------------------------
        // C) NEW IB (Simple Quarter Logic)
        //---------------------------------------------------------------------
        // Using position_id = 1 for IB
        $newIBs = DB::table('users')
            ->where('position_id', 1)
            ->whereIn('id', $teamUserIds)
            ->whereBetween('toIB_date', [$quarterStart, $quarterEnd])
            ->count();

        $newIbTarget = 3;
        $newIbStatus = $this->getQuarterSimpleStatus(
            $newIBs,
            $newIbTarget,
            $quarterEnd
        );

        //---------------------------------------------------------------------
        // D) NEW MARKETERS (Simple Quarter Logic)
        //---------------------------------------------------------------------
        // Using position_id = 5 for Marketer
        $newMarketers = DB::table('users')
            ->where('position_id', 5)
            ->whereIn('id', $teamUserIds)
            ->whereBetween('created_at', [$quarterStart, $quarterEnd])
            ->count();

        $newMarketerTarget = 10;
        $newMarketerStatus = $this->getQuarterSimpleStatus(
            $newMarketers,
            $newMarketerTarget,
            $quarterEnd
        );

        //---------------------------------------------------------------------
        // E) Overall Quarter Status based on new rules:
        //    - If any category is "Pass" => "Pass"
        //    - Else if no category passes and the selected quarter is still current => "In Progress"
        //    - Otherwise (all finished and none passed) => "Fail"
        //---------------------------------------------------------------------
        $quarterStatus = $this->computeQuarterStatus(
            $selectedYear,
            $selectedQuarter,
            $monthlySalesStatus,
            $groupSalesStatus,
            $newIbStatus,
            $newMarketerStatus
        );

        $activeUsers = DB::table('users')
        ->where('status', 1)
        
        ->orderBy('firstname', 'asc')
        ->get();

        //---------------------------------------------------------------------
        // F) Return Data to the Blade view
        //---------------------------------------------------------------------
        return view('requirement.senior-requirement', [
            // Filter info
            'selectedYear'        => $selectedYear,
            'selectedQuarter'     => $selectedQuarter,

            // Overall Quarter Status
            'quarterStatus'       => $quarterStatus,

            // Monthly Sales data
            'monthlySalesStatus'  => $monthlySalesStatus,
            'monthlySalesTarget'  => $monthlyTarget,
            'm1Sales'             => $m1Sales,
            'm2Sales'             => $m2Sales,
            'm3Sales'             => $m3Sales,
            'm1Status'            => $m1Status,
            'm2Status'            => $m2Status,
            'm3Status'            => $m3Status,

            // Group Sales data
            'groupSales'               => $groupSales,
            'quarterGroupSalesTarget'  => $quarterGroupSalesTarget,
            'groupSalesStatus'         => $groupSalesStatus,

            // New IB data
            'newIBs'       => $newIBs,
            'newIbTarget'  => $newIbTarget,
            'newIbStatus'  => $newIbStatus,

            // New Marketer data
            'newMarketers'      => $newMarketers,
            'newMarketerTarget' => $newMarketerTarget,
            'newMarketerStatus' => $newMarketerStatus,

            'activeUsers'     => $activeUsers,
        ]);
    }

    // -----------------------------------------------------------------
    // HELPER #1: Quarter-based Monthly Sales Logic
    // -----------------------------------------------------------------
    /**
     * For the quarter’s monthly sales:
     * - If any completed month fails => "Fail".
     * - If no completed month fails but at least one month is still ongoing => "In Progress".
     * - If all three months are complete and each month passed => "Pass".
     */
    private function getQuarterMonthlySalesStatus($userId, $year, $quarter, $monthlyTarget)
    {
        [$startMonth, $endMonth] = $this->getQuarterMonthRange($quarter);
        for ($m = $startMonth; $m <= $endMonth; $m++) {
            $monthStatus = $this->getSingleMonthStatus($userId, $year, $m, $monthlyTarget);
            if ($monthStatus === 'Fail') {
                return 'Fail';
            }
            if ($monthStatus === 'In Progress') {
                return 'In Progress';
            }
        }
        return 'Pass';
    }

    /**
     * For a specific month, return:
     * - "Pass" if the month is complete and sales >= target.
     * - "Fail" if the month is complete and sales < target.
     * - "In Progress" if the month has not ended.
     */
    private function getSingleMonthStatus($userId, $year, $month, $monthlyTarget)
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = Carbon::create($year, $month, 1)->endOfMonth();

        $sales = DB::table('sales')
            ->where('user_id', $userId)
                ->where('sales_status', 'Approve')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        if ($today->gt($endOfMonth)) {  // Month is complete.
            return $sales >= $monthlyTarget ? 'Pass' : 'Fail';
        }
        return 'In Progress';
    }

    /**
     * Sum up a user's sales for the specified month.
     */
    private function getMonthSales($userId, $year, $month)
    {
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = Carbon::create($year, $month, 1)->endOfMonth();
        return DB::table('sales')
            ->where('user_id', $userId)
                ->where('sales_status', 'Approve')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
    }

    // -----------------------------------------------------------------
    // HELPER #2: Quarter Simple Logic for Group Sales, New IB, New Marketer
    // -----------------------------------------------------------------
    /**
     * For group sales, new IB, and new marketer:
     * - If today is before the quarter's end => return "Pass" if actual >= target, else "In Progress".
     * - If the quarter is complete => return "Pass" if actual >= target, else "Fail".
     */
    private function getQuarterSimpleStatus($actual, $target, $quarterEnd)
    {
        $today = Carbon::today();
        if ($today->lt($quarterEnd)) {
            return ($actual >= $target) ? 'Pass' : 'In Progress';
        }
        return ($actual >= $target) ? 'Pass' : 'Fail';
    }

    // -----------------------------------------------------------------
    // HELPER #3: Compute Overall Quarter Status
    // -----------------------------------------------------------------
    /**
     * Overall Quarter Status (across all categories):
     * - If any category is "Pass" => "Pass".
     * - Else if no category is "Pass" but the selected quarter is still current => "In Progress".
     * - Otherwise => "Fail".
     */
    private function computeQuarterStatus(
        $year,
        $quarter,
        $monthlySalesStatus,
        $groupSalesStatus,
        $newIbStatus,
        $newMarketerStatus
    ) {
        $allStatuses = [
            $monthlySalesStatus,
            $groupSalesStatus,
            $newIbStatus,
            $newMarketerStatus
        ];
        if (in_array('Pass', $allStatuses)) {
            return 'Pass';
        }
        $currentYear = Carbon::now()->year;
        $currentQuarter = $this->getCurrentQuarter();
        if ($year == $currentYear && $quarter == $currentQuarter) {
            return 'In Progress';
        }
        return 'Fail';
    }

    // -----------------------------------------------------------------
    // HELPER #4: Current Quarter & Quarter Range
    // -----------------------------------------------------------------
    private function getCurrentQuarter()
    {
        $month = Carbon::now()->month;
        if ($month <= 3) {
            return 1;
        } elseif ($month <= 6) {
            return 2;
        } elseif ($month <= 9) {
            return 3;
        }
        return 4;
    }

    private function getQuarterMonthRange($quarter)
    {
        switch ($quarter) {
            case 1:
                return [1, 3];
            case 2:
                return [4, 6];
            case 3:
                return [7, 9];
            case 4:
                return [10, 12];
        }
        return [1, 3]; // fallback
    }
}
