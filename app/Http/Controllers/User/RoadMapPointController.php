<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Helpers;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
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
        if($request->user()->position){
            $positions = $request->user()->position;
            $kpi = [
                'step1' => $request->user()->position->step1,
                'step2' => $request->user()->position->step2,
                'step3' => $request->user()->position->step3,
                'step4' => $request->user()->position->step4,
                'step5' => $request->user()->position->step5,
            ];
            $user_point = $request->user()->points ?? 0;
            $kpi_name = 'step1';
            $kpi_points = $kpi['step1'];
            foreach($kpi as $name => $points){
                if($points >= $user_point){
                    $kpi_name = $name;
                    $kpi_points = $points;
                    break;
                }
            }
            if($user_point){
                $percentage_to_next_step = ($user_point / $kpi_points) * 100 ?? 0;
                $percentage_to_next_rank = ($user_point / $request->user()->position->kpi) * 100 ?? 0;
                $points_to_next_step = $kpi_points - $user_point;
                $points_to_next_rank = $request->user()->position->kpi - $user_point; 
            }

            $data = [
                'percentage_to_next_step' => $percentage_to_next_step ??'',
                'percentage_to_next_rank' => $percentage_to_next_rank ??'',
                'points_to_next_step' => $points_to_next_step ??'',
                'points_to_next_rank' => $points_to_next_rank ??'',
                'kpi_name' => $kpi_name ?? '',
                'kpi_points' => $kpi_points ?? '',
                'rank_next_points' => $request->user()->position->kpi ?? '',
                'current_rank' => $request->user()->position->name ?? '',
            ];
        }

        return view('user.roadmappoints.index', [
            'data' => $data,
            'positions' => $positions,
            'user_point' => $user_point,
        ]);
    }
    
}
