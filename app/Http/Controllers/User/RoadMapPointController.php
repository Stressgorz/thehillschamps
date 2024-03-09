<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Helpers;
use App\Models\Client;
use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use App\Models\PositionStep;
use App\Models\Sale;
use Carbon\Carbon;

class RoadMapPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $path = Position::$path;
        if($request->user()->position){
            $position_step = PositionStep::where('position_id', $request->user()->position_id)
                                            ->where('status', PositionStep::$status['active'])
                                            ->get();

            foreach($position_step as $index => $steps){
                $step_no = 'step'.$steps->sort;
                $kpi[$step_no] = $steps->amount;
            }

            $user_wallet = UserWallet::where('wallet', Userwallet::$wallet['points'])
                                    ->where('user_id', $request->user()->id)
                                    ->select('balance')
                                    ->first();

            if($user_wallet){
                $user_point = $user_wallet->balance ?? 0;
            } else {
                $user_point = 0;
            }

            $kpi_name = 'step1';
            $kpi_points = $kpi['step1'];
            foreach($kpi as $name => $points){
                if($points > $user_point){
                    $kpi_name = $name;
                    $kpi_points = $points;
                    break;
                }
            }

            if($user_point && $user_point != 0){
                $percentage_to_next_step = ($user_point / $kpi_points) * 100 ?? 0;
                $percentage_to_next_rank = ($user_point / $request->user()->position->kpi) * 100 ?? 0;
                $points_to_next_step = $kpi_points - $user_point;
            }

            $data = [
                'percentage_to_next_step' => $percentage_to_next_step ??'',
                'percentage_to_next_rank' => $percentage_to_next_rank ??'',
                'points_to_next_step' => $points_to_next_step ??'',
                'kpi_name' => $kpi_name ?? '',
                'kpi_points' => $kpi_points ?? '',
                'rank_next_points' => $request->user()->position->kpi ?? '',
                'current_rank' => $request->user()->position->name ?? '',
            ];
        }

        return view('user.roadmappoints.index', [
            'data' => $data,
            'path' => $path,
            'user_point' => $user_point,
            'position_step' => $position_step,
        ]);
    }
    
}
