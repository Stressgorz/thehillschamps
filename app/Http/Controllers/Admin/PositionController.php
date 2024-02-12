<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
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

        $path = Position::$path;
        return view('backend.positions.edit', [
            'position' => $position,
            'position_status' => Position::$status,
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
        
        // return $request->all();
        $data = static::positionUpdateValidation($request, $id);

        $updateData = [
            'step1' => $data['step1'],
            'step2' => $data['step2'],
            'step3' => $data['step3'],
            'step4' => $data['step4'],
            'step5' => $data['step5'],
            'kpi' => $data['kpi'],
            'step1_name' => $data['step1_name'],
            'step2_name' => $data['step2_name'],
            'step3_name' => $data['step3_name'],
            'step4_name' => $data['step4_name'],
            'step5_name' => $data['step5_name'],
        ];

        $path = Position::$path;

        if(isset($data['step1_img'])){
            $filename = $data['step1_img']->getClientOriginalName();
            $data['step1_img']->storeAs($path, $filename, 'public');
            $updateData['step1_img'] = $filename;
        }

        if(isset($data['step2_img'])){
            $filename = $data['step2_img']->getClientOriginalName();
            $data['step2_img']->storeAs($path, $filename, 'public');
            $updateData['step2_img'] = $filename;
        }

        if(isset($data['step3_img'])){
            $filename = $data['step3_img']->getClientOriginalName();
            $data['step3_img']->storeAs($path, $filename, 'public');
            $updateData['step3_img'] = $filename;
        }

        if(isset($data['step4_img'])){
            $filename = $data['step4_img']->getClientOriginalName();
            $data['step4_img']->storeAs($path, $filename, 'public');
            $updateData['step4_img'] = $filename;
        }

        if(isset($data['step5_img'])){
            $filename = $data['step5_img']->getClientOriginalName();
            $data['step5_img']->storeAs($path, $filename, 'public');
            $updateData['step5_img'] = $filename;
        }

        $position=Position::findOrFail($id);

        if($position){
            $position->fill($updateData)->save();
            request()->session()->flash('success','Positions successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('positions.index');
    }

    public static function positionUpdateValidation($request, $id){

        $data[] = $request->validate([
            'step1' => ['required'],
            'step2' => ['required'],
            'step3' => ['required'],
            'step4' => ['required'],
            'step5' => ['required'],
            'kpi' => ['required'],
            'step1_img' => ['nullable'],
            'step2_img' => ['nullable'],
            'step3_img' => ['nullable'],
            'step4_img' => ['nullable'],
            'step5_img' => ['nullable'],
            'step1_name' => ['nullable'],
            'step2_name' => ['nullable'],
            'step3_name' => ['nullable'],
            'step4_name' => ['nullable'],
            'step5_name' => ['nullable'],
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
