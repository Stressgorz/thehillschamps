<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $now = Carbon::now();

        if (empty($request->query('sales_status'))) {
            $request->request->add([
                'sales_status' => $request->query('sales_status'),
            ]);
        }

        if (empty($request->query('broker_type'))) {
            $request->request->add([
                'broker_type' => $request->query('broker_type'),
            ]);
        }

        if (empty($request->query('fdate'))) {
            $fdate = Carbon::createFromFormat('Y-m-d H:i:s', $now)->subDays(1)->format('Y-m-d');
            $request->request->add([
                'fdate' => $fdate,
            ]);
        }
        if (empty($request->query('tdate'))) {
            $tdate = Carbon::createFromFormat('Y-m-d H:i:s', $now)->format('Y-m-d');
            $request->request->add([
                'tdate' => $tdate,
            ]);
        }

        $table_data = $this->filter($request);

        return view('backend.sales.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'sales_status' => Sale::$sales_status,
            'brokers' => Sale::$broker,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('sales')
                    ->leftJoin('users', 'sales.user_id' , '=', 'users.id')
                    ->leftJoin('clients', 'sales.client_id' , '=', 'clients.id')
                    ->where('sales.status', Sale::$status['active'])
		        	->select('sales.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    'users.email as user_email',
                    'clients.name as client_name',
                    'clients.email as client_email',
                    'clients.contact as client_contact',
                    )
                    ->orderBy('id','ASC');

        $params = [
            'sales' => [
                'sales_status' => 'sales_status',
                'broker_type' => 'broker_type',
                'created_by' => 'created_by',
            ],
            'users' => [
                'user_email' => 'email',
            ],
            'clients' => [
                'client_email' => 'email',
            ],
        ];

        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'created_by') {
	                if ($filters->get('fdate')) {
	                    $query->where($table.'.'.$param, '>=',  $filters->get('fdate'));
	                }
	                if ($filters->get('tdate')) {
	                    $query->where($table.'.'.$param, '<=', ($filters->get('tdate').' 23:59:59'));
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
        $team_status = Team::$status;

        return view('backend.teams.create', [
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
        $data = static::teamStoreValidation($request);

        $team = Team::create([
        	'name' => $data['name'],
            'status' => $data['status'],
        ]);

        if($team){
            request()->session()->flash('success','Team successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('teams.index');
    }

    public static function teamStoreValidation($request){

        $data[] = $request->validate([
            'name' => ['required',
                function ($attribute, $value, $fail) {
                    $team_name = Team::where('name', $value)->first();
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
        $team = Team::findOrFail($id);

        return view('backend.teams.edit', [
            'team' => $team,
            'team_status' => Team::$status,
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
        $data = static::teamUpdateValidation($request, $id);

        $updateData = [
            'name' => $data['name'],
            'status' => $data['status'],
        ];

        $team=Team::findOrFail($id);

        if($team){
            $team->fill($updateData)->save();
            request()->session()->flash('success','Team successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('teams.index');
    }

    public static function teamUpdateValidation($request, $id){


        $data[] = $request->validate([
            'name' => ['required'],
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
        return redirect()->route('teams.index');
    }

    /**
     * Export filtered data.
     *
     */
    public function export(Request $request)
    {   
        
        $table_data = $this->filter($request);
        return Excel::download(new MembersExport($table_data), 'members-'.Carbon::now()->format('YmdHis').'.xlsx');
    }
    
}
