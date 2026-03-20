<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncentiveController extends Controller
{
    /**
     * Display the logged‑in user’s WTT entries count and Lots volume
     * accumulated during the Dubai incentive period (1 May 2025 → 31 Jul 2025).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // --- Define the incentive window ----------------------------------
        $startDate = Carbon::create(2025, 5, 1)->startOfDay();  // 01‑May‑2025 00:00:00
        $endDate   = Carbon::create(2025, 7, 31)->endOfDay();   // 31‑Jul‑2025 23:59:59

        // --- Fetch the logged user ID --------------------------------------
        $loggedUser = auth()->user();
        $user = $loggedUser; // default to logged-in user

        // --- Aggregate Lots volume -----------------------------------------
         $totalLots = DB::table('lots')
            ->where('user_id', $user->id)
            ->whereBetween('lots_date', [$startDate, $endDate])
            ->sum('lots');

        // --- Count WTT entries ---------------------------------------------
        $totalWttEntries = DB::table('wtt')
            ->where('user_id', $user->id)
            ->whereBetween('wtt_date', [$startDate, $endDate])
            ->sum('wtt');

        // Otherwise return the Blade view, passing the two totals
        return view('incentive.incentive', [
            'currentLots' => (float) $totalLots,
            'currentWTT'  => (int)   $totalWttEntries,
        ]);
    }
}
