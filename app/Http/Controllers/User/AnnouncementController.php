<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Calendar;
use App\User;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];
        $now = Carbon::now();
        $from_date = Carbon::parse($now)->subDay(7)->toDateTimeString();
        $data = DB::table('announcements')->where('date', '>=', $from_date)
                            ->where('status', Announcement::$status['active'])
                            ->get()
                            ->groupBy(function($data) {
                                return Carbon::parse($data->date)->format('Y-m-d'); // grouping by years
                            });
        
        $events = [];

        $calendars = Calendar::get();
        $this_year = Carbon::now()->format('Y');

        foreach($calendars as $calendar){
            $start_time = $calendar->start_time;
            $title = $calendar->title;
            if($calendar->type == Calendar::$type['birthday']){

                $user = User::where('id', $calendar->user_id)
                                ->select('team_id', 'firstname', 'lastname')
                                ->first();
                if($user->team_id != $request->user()->team_id){
                    continue;
                }
                $title = Calendar::$bdcontent .' '.$user->firstname.' '.$user->lastname;
                $start_time = Carbon::parse($calendar->start_time)->format($this_year.'-m-d');
            }
            $events[] = [
                'title' => $title,
                'start' => $start_time,
                'end' => $calendar->finish_time,
            ];
        }

        return view('user.announcement.index', [
            'data' => $data,
            'events' => $events,
        ]);
    }
    
}
