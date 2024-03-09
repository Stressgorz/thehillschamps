<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Kpi;
use App\Models\KpiAnswer;
use App\Models\Team;
use App\Models\PositionStep;
use Carbon\Carbon;

class KpiController extends Controller
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

        $positions = Position::all();

        return view('backend.kpi.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'kpi_status' => Kpi::$status,
            'positions' => $positions,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('kpi')
                    ->leftJoin('positions', 'kpi.position_id' , '=', 'positions.id')
		        	->select('kpi.*',
                    'positions.name as position_name',
                    )
                    ->orderBy('sort','ASC');

        $params = [
            'kpi' => [
                'status' => 'status',
            ],
            'positions' => [
                'position' => 'id',
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
                        if (in_array($field, ['status'])) { 
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

        $positions = Position::all();
        return view('backend.kpi.create', [
            'kpi_status' => Kpi::$status,
            'positions' => $positions,
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

        $data = static::kpiStoreValidation($request);

        $kpi = Kpi::create([
        	'position_id' => $data['position_id'],
            'sort' => $data['sort'],
            'name' => $data['name'],
            'status' => Kpi::$status['active'],
        ]);

        if($kpi){
            foreach($data['answer_sort'] as $index => $answer){
                $kpi_answer = KpiAnswer::create([
                    'kpi_id' => $kpi->id,
                    'sort' => $data['answer_sort'][$index],
                    'name' => $data['answer_name'][$index],
                    'points' => $data['points'][$index],
                    'status' => KpiAnswer::$status['active'],
                ]);
            }
        }
        
        if($kpi_answer && $kpi){
            request()->session()->flash('success','KPI successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('kpi-question.index');
    }

    public static function kpiStoreValidation($request){

        $data[] = $request->validate([
            'sort' => ['required',
                function ($attribute, $value, $fail) use ($request) {
                    $kpi = KPI::where('position_id', $request->position_id)
                                ->where('sort', $value)
                                ->first();
                    if ($kpi) {
                        $fail('Kpi Question is exists');
                    }
                }],
            'position_id' => ['required',
                function ($attribute, $value, $fail) use ($request) {
                $position = Position::where('id', $value)
                            ->first();
                if (empty($position)) {
                    $fail('Position is not exists');
                }
            }],
            'name' => ['required'],
            'answer_sort.*' => ['required'],
            'answer_name.*' => ['required'],
            'points.*' => ['required'],
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
        $kpi = Kpi::findOrFail($id);

        $position = Position::where('id', $kpi->position_id)->first();
        $kpi_answers = KpiAnswer::where('kpi_id', $id)
                                        ->where('status', KpiAnswer::$status['active'])
                                        ->get();
                                        
        return view('backend.kpi.edit', [
            'kpi' => $kpi,
            'position' => $position,
            'kpi_answers' => $kpi_answers,
            'kpi_status' => Kpi::$status,
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
        $now = Carbon::now();
        // return $request->all();
        $data = static::kpiUpdateValidation($request, $id);

        $kpi_answers = KpiAnswer::where('kpi_id', $id)
                                ->where('status', KpiAnswer::$status['active'])
                                ->orderBy('sort')
                                ->get();

        $updateData = [
            'name' => $data['name'],
            'status' => $data['status'],
        ];

        $kpi=Kpi::findOrFail($id);

        if($kpi){
            $kpi->fill($updateData)->save();
        }
        // Update Or Insert the gift according to the order
        foreach($data['answer_sort'] as $index => $answer){
            $kpi_answer = DB::table('kpi_answers')
                ->updateOrInsert(
                    [
                        'sort' => $data['answer_sort'][$index],
                        'kpi_id' => $id,
                    ],
                    [
                        'name' => $data['answer_name'][$index],
                        'points' => $data['points'][$index],
                        'status' => KpiAnswer::$status['active'],
                        'created_at' => $now,
                        'updated_at' => $now,  
                    ],
                );
            $sort_id[] = $data['answer_sort'][$index];
        }

        foreach($kpi_answers as $answer){
            $answer_sort_id[] = $answer->sort;
        }

        $diff_id = array_diff($answer_sort_id, $sort_id);

        foreach($diff_id as $removed_id){
            KpiAnswer::where('kpi_id', $id)
                            ->where('sort', $removed_id)
                            ->update([
                                'status' => KpiAnswer::$status['inactive']
                            ]);
        }

        if($kpi_answer || $kpi){
            request()->session()->flash('success','Kpi Answer successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('kpi-question.index');
    }

    public static function kpiUpdateValidation($request, $id){

        $data[] = $request->validate([
            'name' => ['required'],
            'status' => ['required'],
            'answer_sort.*' => ['required'],
            'answer_name.*' => ['required'],
            'points.*' => ['required'],
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
        $kpi=Kpi::findOrFail($id);

        if($kpi){
            // return $child_cat_id;
            $kpi = Kpi::where('id', $id)->update([
                'status' => Position::$status['inactive'],
            ]);

            request()->session()->flash('success','Kpi successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Kpi');
        }
        return redirect()->route('kpi.index');
    }
}
