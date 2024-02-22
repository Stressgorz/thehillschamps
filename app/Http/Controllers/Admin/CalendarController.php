<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use App\Models\Calendar;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (empty($request->query('status'))) {
            $request->request->add([
                'status' => $request->query('status'),
            ]);
        }
        
        $table_data = $this->filter($request);

        return view('backend.calendars.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('Calendars')
                    ->where('type', Calendar::$type['content'])
		        	->select('*'
                    )
                    ->orderBy('id','DESC');

        $params = [
            'Calendars' => [
                'start_time' => 'start_time',
            ]
        ];
        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'start_time') {
	                if ($filters->query('fdate')) {
	                    $query->where($table.'.'.$param, '>=',  $filters->query('fdate'));
	                }
	                if ($filters->query('tdate')) {
	                    $query->where($table.'.'.$param, '<=', ($filters->query('tdate').' 23:59:59'));
	                }
	            } elseif (is_array($filters->query($field)) && ! empty($filters->query($field))) { 
	                // If is array and not empty
	                $query->whereIn($table.'.'.$param, $filters->query($field));
	            } else {
                    if (! empty($filters->query($field))) {
                        if (in_array($field, ['status', 'type'])) { 
                            $query->where($table.'.'.$param, '=',  $filters->query($field));
                        } else {
                            $query->where($table.'.'.$param, 'LIKE',  '%'.$filters->query($field).'%');
                        }
                    }
	            }
        	}
        }
        return $query->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.calendars.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = static::calendarStoreValidation($request);
        $calendar = Calendar::create([
        	'title' => $data['title'],
            'type' => Calendar::$type['content'],
            'start_time' => $data['start_time'],
        ]);

        if($calendar){
            request()->session()->flash('success','calendar successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('calendars.index');
    }

    public static function calendarStoreValidation($request){

        $data[] = $request->validate([
            'title' => ['required'],
            'start_time' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }
        
        return $validated;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Calendar::findOrFail($id);

        return view('backend.calendars.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        // return $request->all();
        $data = static::calendarUpdateValidation($request, $id);

        $updateData = [
            'title' => $data['title'],
            'start_time' => $data['start_time'],
        ];

        $calendar=Calendar::findOrFail($id);

        if($calendar){
            $calendar->fill($updateData)->save();
            request()->session()->flash('success','calendar successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('calendars.index');
    }

    public static function calendarUpdateValidation($request, $id){


        $data[] = $request->validate([
            'title' => ['required'],
            'start_time' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }
        
        return $validated;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $calendar=Calendar::findOrFail($id);

        if($calendar){
            // return $child_cat_id;
            $calendar = Calendar::where('id', $id)->delete();

            request()->session()->flash('success','Calendar successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Calendar');
        }
        return redirect()->route('calendars.index');
    }
}
