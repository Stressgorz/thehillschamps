<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use App\Models\PositionStep;
use Carbon\Carbon;

class PositionController extends Controller
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

        return view('backend.positions.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'position_status' => Team::$status,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('positions')
		        	->select('*'
                    )
                    ->orderBy('id','ASC');

        $params = [
            'positions' => [
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
        $team_status = Position::$status;

        return view('backend.positions.create', [
            'team_status' => $team_status,  
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
        $data = static::positionStoreValidation($request);

        $team = Position::create([
        	'name' => $data['name'],
            'status' => $data['status'],
        ]);

        if($team){
            request()->session()->flash('success','Team successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('positions.index');
    }

    public static function positionStoreValidation($request){

        $data[] = $request->validate([
            'name' => ['required',
                function ($attribute, $value, $fail) {
                    $team_name = Position::where('name', $value)->first();
                    if ($team_name) {
                        $fail('Team Name is exists');
                    }
                }],
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
        $position = Position::findOrFail($id);
        $position_steps = PositionStep::where('position_id', $id)
                        ->where('status', PositionStep::$status['active'])
                        ->get();

        $path = Position::$path;
        return view('backend.positions.edit', [
            'position' => $position,
            'position_status' => Position::$status,
            'position_steps' => $position_steps,
            'path' => $path,
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
        $is_update = false;
        // return $request->all();
        $data = static::positionUpdateValidation($request, $id);

        $path = Position::$path;

        if(isset($data['image'])){
            foreach($data['image'] as $index => $image){
                if($image){
                    $filename = $image->getClientOriginalName();
                    $image->storeAs($path, $filename, 'public');
                    $data['image'][$index] = $filename;
                }
            }
        }

        $position_steps = PositionStep::where('position_id', $id)
                            ->select('sort', 'image')
                            ->where('status', PositionStep::$status['active'])
                            ->orderBy('sort')
                            ->get();

        // Update Or Insert the gift according to the order
        foreach ($data['sort'] as $index => $sort) {
            DB::table('position_steps')
                ->updateOrInsert(
                    [
                        'sort' => $data['sort'][$index],
                        'position_id' => $id,
                    ],
                    [
                        'name' => $data['name'][$index],
                        'amount' => $data['amount'][$index],
                        'image' => isset($data['image'][$index]) ? $data['image'][$index] : $position_steps[$index]->image ?? '',
                        'status' => PositionStep::$status['active'],
                    ],
                );
            $is_update = true;
            $sort_id[] = $data['sort'][$index];
        }

        foreach($position_steps as $position_step){
            $position_sort_id[] = $position_step->sort;
        }

        $diff_id = array_diff($position_sort_id, $sort_id);

        foreach($diff_id as $removed_id){
            PositionStep::where('position_id', $id)
                            ->where('sort', $removed_id)
                            ->update([
                                'status' => PositionStep::$status['inactive']
                            ]);
        }

        if($is_update){
            request()->session()->flash('success','Positions Steps successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('positions.index');
    }

    public static function positionUpdateValidation($request, $id){

        $data[] = $request->validate([
            'sort.*' => ['required'],
            'amount.*' => ['required'],
            'name.*' => ['required'],
            'image.*' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }
        
        return $validated;
    }

    public static function addPositionSteps(Request $request, $id){

        $positionsteps = false;

        $steps = PositionStep::where('position_id', $id)->where('status', PositionStep::$status['active'])->first();
        if(empty($steps)){
            $positionsteps = PositionStep::create([
                'sort' => 1,
                'position_id' => $id,   
                'name' => '',
                'amount' => 0,
                'image' => '',
                'status' => PositionStep::$status['active'],
            ]);
        }
        
        if($positionsteps){
            request()->session()->flash('success','Positions Steps successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('positions.index');
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
            $team = Position::where('id', $id)->update([
                'status' => Position::$status['inactive'],
            ]);

            request()->session()->flash('success','Team successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Team');
        }
        return redirect()->route('positions.index');
    }
}
