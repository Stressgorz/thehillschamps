<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Calendar;
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

        foreach($calendars as $calendar){
            $events[] = [
                'title' => $calendar->title,
                'start' => $calendar->start_time,
                'end' => $calendar->finish_time,
            ];
        }
        return view('user.announcement.index', [
            'data' => $data,
            'events' => $events,
        ]);
    }
    
}
