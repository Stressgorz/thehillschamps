<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoadmapController extends Controller
{
    /**
     * Display the roadmap view.
     *
     * This method:
     *  - Retrieves distinct years from the roadmap table based on the date column.
     *  - Retrieves distinct months for the selected year.
     *  - Checks if the logged-in user's rank is either "senior" or "IB".
     *  - Uses the logged-in user's position_id to further filter the query.
     *  - Retrieves the USD amount for the selected year and month.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Retrieve the authenticated user.
        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user
        

        $position_id = $user->position_id;

        if ($loggedUser->position_id == 4) {
            // Get the selected IB (user id) from the query parameter.
            $position_id = $request->get('ib'); // Might be empty string or null
        }


        // Retrieve distinct years from the roadmap table.
        $years = DB::table('roadmap')
            ->select(DB::raw('YEAR(date) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Determine selected year based on request or default to first available year or current year.
        $selectedYear = $request->get('year', count($years) > 0 ? $years[0] : date('Y'));

        // Retrieve distinct months available for the selected year.
        $months = DB::table('roadmap')
            ->select(DB::raw('MONTH(date) as month'))
            ->whereYear('date', $selectedYear)
            ->distinct()
            ->orderBy('month')
            ->pluck('month')
            ->toArray();

        // Determine the selected month, defaulting to the first available month or current month.
        $selectedMonth = $request->get('month', count($months) > 0 ? max($months) : date('n'));


        // Retrieve the roadmap record where the year, month, and position_id match.
        $record = DB::table('roadmap')
            ->whereYear('date', $selectedYear)
            ->whereMonth( 'date', $selectedMonth)
            ->where('position_id', $position_id)
            ->first();

        // Format the USD amount if a record is found; otherwise, default to "0.00".
        $amount = $record ? number_format($record->usd_amount, 2) : '0.00';

        // Retrieve all active users (status = 1) for the dropdown,
        // filtering for position_id in [1, 2, 3, 4] and sorted by firstname.
        $activeUsers = DB::table('users')
            ->where('status', 1)
            ->whereIn('position_id', [1, 2, 3, 4])
            ->orderBy('firstname', 'asc')
            ->get();

        // Pass variables to the view.
        return view('roadmap.roadmap', [
            'amount'        => $amount,
            'years'         => $years,
            'selectedYear'  => $selectedYear,
            'months'        => $months,
            'selectedMonth' => $selectedMonth,
            'message'       => null,
            'position_id'   => $position_id,
        ]);
    }
}
