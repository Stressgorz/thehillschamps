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

class LeaderboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $data_type)
    {
    }

    public function leaderboardSales(Request $request, $data_type)
    {

        $leaderboard_data = static::getLeaderboardInfo($request);
        $photo = 'storage/'.User::$path.'/';
        $start_date = $leaderboard_data['start_date'];
        $end_date = $leaderboard_data['end_date'];
        $type = $leaderboard_data['type'];

        $leaderboard = static::getSaleLeaderboard($request, $start_date, $end_date, $data_type);

        return view('user.leaderboard.sales', [
            'type' => $type,
            'photo' => $photo,
            'data_type' => $data_type,          
            'leaderboard' => $leaderboard ?? [],
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
        ]);
    }

    public function leaderboardIb(Request $request, $data_type)
    {

        
        $leaderboard_data = static::getLeaderboardInfo($request);
        $photo = 'storage/'.User::$path.'/';
        $start_date = $leaderboard_data['start_date'];
        $end_date = $leaderboard_data['end_date'];
        $type = $leaderboard_data['type'];

        $leaderboard = static::getIbLeaderboard($request, $start_date, $end_date, $data_type);

        return view('user.leaderboard.ib', [
            'type' => $type,
            'photo' => $photo,
            'data_type' => $data_type,          
            'leaderboard' => $leaderboard ?? [],
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
        ]);
    }

    public function leaderboardClient(Request $request, $data_type)
    {        
        $leaderboard_data = static::getLeaderboardInfo($request);
        $photo = 'storage/'.User::$path.'/';
        $start_date = $leaderboard_data['start_date'];
        $end_date = $leaderboard_data['end_date'];
        $type = $leaderboard_data['type'];

        $leaderboard = static::getClientLeaderboard($request, $start_date, $end_date, $data_type);

        return view('user.leaderboard.client', [
            'type' => $type,
            'photo' => $photo,
            'data_type' => $data_type,          
            'leaderboard' => $leaderboard ?? [],
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
        ]);
    }
    
    public function getLeaderboardInfo($request){

        $now = Carbon::now();
        $this_month = Carbon::now()->format('M');
        $this_year = Carbon::now()->format('Y');
        $start_date = $now->startOfMonth()->format('Y-m-d H:i:s');
        $end_date = $now->endOfMonth()->format('Y-m-d H:i:s'); 

        if(empty($request->type)){
            $type = Sale::$leaderboard_type['month'];
        } else {
            $type = $request->type;
        }

        if($type == Sale::$leaderboard_type['month']){
            if(empty($request->month)){
                $start_date = Carbon::parse($this_month)->startOfMonth()->format($this_year.'-m-d H:i:s');
                $end_date = Carbon::parse($this_month)->endOfMonth()->format($this_year.'-m-d H:i:s');
            } else {
                $month = $request->month;
                $start_date = Carbon::parse($month)->startOfMonth()->format($this_year.'-m-d H:i:s');
                $end_date = Carbon::parse($month)->endOfMonth()->format($this_year.'-m-d H:i:s');
            }
        } else if($type == Sale::$leaderboard_type['year']){
            if(empty($request->year)){
                $start_date = Carbon::parse($now)->startOfYear()->format('Y-m-d H:i:s');
                $end_date = Carbon::parse($now)->endOfYear()->format('Y-m-d H:i:s');
            } else {
                $year = $request->year;
                $start_date = Carbon::parse($year)->startOfYear()->format($year.'-m-d H:i:s');
                $end_date = Carbon::parse($year)->endOfYear()->format($year.'-m-d H:i:s');
            }
        }

        $returnData = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'type' => $type,
        ];

        return $returnData;

    }

    public static function getSaleLeaderboard($request, $start_date, $end_date, $data_type){

        $queries = DB::table('sales')
                    ->leftJoin('users', 'sales.user_id' , '=', 'users.id')
                    ->leftJoin('positions', 'users.position_id' , '=', 'positions.id')
                    ->leftJoin('teams', 'users.team_id' , '=', 'teams.id')
                    ->where('users.status', User::$status['active'])
                    ->where('sales.sales_status', Sale::$sales_status['approved'])
                    ->where('sales.status', Sale::$status['active'])
                    ->where('sales.created_at', '>=', $start_date)
                    ->where('sales.created_at', '<', $end_date);

        if($data_type == Sale::$leaderboard_data_type['user']){
            $queries = $queries->selectRaw('sum(sales.amount) as total_amount
                                            ,users.firstname as name
                                            ,users.lastname as lastname
                                            ,positions.name as position_name
                                            ,users.photo as photo
                                            ')
                                ->groupBy('sales.user_id')
                                ->groupBy('users.firstname')
                                ->groupBy('users.lastname')
                                ->groupBy('users.photo')
                                ->groupBy('positions.name');

        } else if($data_type == Sale::$leaderboard_data_type['team']){
            $queries = $queries->selectRaw('sum(sales.amount) as total_amount
                                            ,teams.name as name
                                            ,teams.id as team_id
                                            ')
                                ->groupBy('teams.id')
                                ->groupBy('teams.name');
        }


        $queries = $queries->orderBy('total_amount', 'DESC')
                            ->Limit(30)
                            ->get()
                            ->toArray();

        $first = $queries[0] ?? [];
        $second = $queries[1] ?? [];
        $third = $queries[2] ?? [];

        unset($queries[0]);
        unset($queries[1]);
        unset($queries[2]);

        $rest = $queries ?? [];

        $returnData = [
            'first' => $first,
            'second' => $second,
            'third' => $third,
            'rest' => $rest,
        ];
        return $returnData;
    }

    public static function getClientLeaderboard($request, $start_date, $end_date, $data_type){

        $queries = DB::table('clients')
                    ->leftJoin('users', 'clients.user_id' , '=', 'users.id')
                    ->leftJoin('positions', 'users.position_id' , '=', 'positions.id')
                    ->leftJoin('teams', 'users.team_id' , '=', 'teams.id')
                    ->where('users.status', User::$status['active'])
                    ->where('clients.status', Client::$status['active'])
                    ->where('clients.created_at', '>=', $start_date)
                    ->where('clients.created_at', '<', $end_date);

        if($data_type == Sale::$leaderboard_data_type['user']){
            $queries = $queries->selectRaw('count(clients.id) as total_amount
                                            ,users.firstname as name
                                            ,users.lastname as lastname
                                            ,positions.name as position_name
                                            ,users.photo as photo
                                            ')
                                ->groupBy('clients.user_id')
                                ->groupBy('users.firstname')
                                ->groupBy('users.lastname')
                                ->groupBy('users.photo')
                                ->groupBy('positions.name');

        } else if($data_type == Sale::$leaderboard_data_type['team']){
            $queries = $queries->selectRaw('count(clients.id) as total_amount
                                            ,teams.name as name
                                            ,teams.id as team_id
                                            ')
                                ->groupBy('teams.id')
                                ->groupBy('teams.name');
        }


        $queries = $queries->orderBy('total_amount', 'DESC')
                            ->Limit(30)
                            ->get()
                            ->toArray();

        $first = $queries[0] ?? [];
        $second = $queries[1] ?? [];
        $third = $queries[2] ?? [];

        unset($queries[0]);
        unset($queries[1]);
        unset($queries[2]);

        $rest = $queries ?? [];

        $returnData = [
            'first' => $first,
            'second' => $second,
            'third' => $third,
            'rest' => $rest,
        ];
        return $returnData;
    }

    public static function getIbLeaderboard($request, $start_date, $end_date, $data_type){

        $queries = DB::table('users')
                    ->leftJoin('users as downline', function ($join) {
                        $join->on('downline.upline_id', '=', 'users.id');
                    })
                    ->leftJoin('positions', 'users.position_id' , '=', 'positions.id')
                    ->leftJoin('teams', 'users.team_id' , '=', 'teams.id')
                    ->where('downline.status', User::$status['active'])
                    ->where('users.status', User::$status['active'])
                    ->where('downline.created_at', '>=', $start_date)
                    ->where('downline.created_at', '<', $end_date);

        if($data_type == Sale::$leaderboard_data_type['user']){
            $queries = $queries->selectRaw('count(downline.id) as total_amount
                                            ,users.firstname as name
                                            ,users.lastname as lastname
                                            ,positions.name as position_name
                                            ,users.photo as photo
                                            ')
                                ->groupBy('users.firstname')
                                ->groupBy('users.lastname')
                                ->groupBy('users.photo')
                                ->groupBy('positions.name');

        } else if($data_type == Sale::$leaderboard_data_type['team']){
            $queries = $queries->selectRaw('count(downline.id) as total_amount
                                            ,teams.name as name
                                            ,teams.id as team_id
                                            ')
                                ->groupBy('teams.id')
                                ->groupBy('teams.name');
        }


        $queries = $queries->orderBy('total_amount', 'DESC')
                            ->Limit(30)
                            ->get()
                            ->toArray();
                            
        $first = $queries[0] ?? [];
        $second = $queries[1] ?? [];
        $third = $queries[2] ?? [];

        unset($queries[0]);
        unset($queries[1]);
        unset($queries[2]);

        $rest = $queries ?? [];

        $returnData = [
            'first' => $first,
            'second' => $second,
            'third' => $third,
            'rest' => $rest,
        ];
        return $returnData;
    }
    
}
