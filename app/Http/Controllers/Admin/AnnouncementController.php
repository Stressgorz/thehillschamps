<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
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
        
        if (empty($request->query('status'))) {
            $request->request->add([
                'status' => $request->query('status'),
            ]);
        }
        
        $table_data = $this->filter($request);

        return view('backend.announcements.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'announcements_status' => Announcement::$status,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('Announcements')
		        	->select('*'
                    )
                    ->orderBy('id','DESC');

        $params = [
            'announcements' => [
                'status' => 'status',
            ]
        ];
        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'created_at') {
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
        $announcements_status = Announcement::$status;

        return view('backend.announcements.create', [
            'announcements_status' => $announcements_status,  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = static::announcementStoreValidation($request);
        $annoucement = Announcement::create([
        	'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'date' => $data['date'],
            'status' => $data['status'],
        ]);

        if($annoucement){
            request()->session()->flash('success','Annoucement successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('announcements.index');
    }

    public static function announcementStoreValidation($request){

        $data[] = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'content' => ['nullable'],
            'date' => ['required'],
            'status' => ['required'],
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
        $data = Announcement::findOrFail($id);

        return view('backend.announcements.edit', [
            'data' => $data,
            'data_status' => Announcement::$status,
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
        $data = static::announcementUpdateValidation($request, $id);

        $updateData = [
        	'title' => $data['title'],
            'description' => $data['description'],
            'content' => $data['content'],
            'date' => $data['date'],
            'status' => $data['status'],
        ];

        $data=Announcement::findOrFail($id);

        if($data){
            $data->fill($updateData)->save();
            request()->session()->flash('success','Announcement successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('announcements.index');
    }

    public static function announcementUpdateValidation($request, $id){


        $data[] = $request->validate([
            'title' => ['required'],
            'description' => ['nullable'],
            'content' => ['nullable'],
            'date' => ['required'],
            'status' => ['required'],
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
        $team=Team::findOrFail($id);

        if($team){
            // return $child_cat_id;
            $team = Team::where('id', $id)->update([
                'status' => Team::$status['inactive'],
            ]);

            request()->session()->flash('success','Team successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Team');
        }
        return redirect()->route('announcements.index');
    }
}
