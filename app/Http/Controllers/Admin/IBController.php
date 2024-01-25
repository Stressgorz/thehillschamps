<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;
use Carbon\Carbon;

class IBController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (empty($request->query('name'))) {
            $request->request->add([
                'name' => $request->query('name'),
            ]);
        }

        if (empty($request->query('position'))) {
            $request->request->add([
                'position' => $request->query('position'),
            ]);
        }

        if (empty($request->query('team'))) {
            $request->request->add([
                'team' => $request->query('team'),
            ]);
        }
        
        $table_data = $this->filter($request);

        $positions = Position::where('status', Position::$status['active'])->get();
        $teams = Team::where('status', Team::$status['active'])->get();

        return view('backend.ib.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'positions' => $positions,
            'teams' => $teams,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('users')
                    ->leftJoin('teams', 'users.team_id' , '=', 'teams.id')
                    ->leftJoin('positions', 'users.position_id' , '=', 'positions.id')
                    ->leftJoin('users as upline', function ($join) {
                        $join->on('users.upline_id', '=', 'upline.id');
                    })
                    ->where('users.status', User::$status['active'])
		        	->select('users.*',
                    'teams.name as team_name',
                    'positions.name as position_name',
                    'upline.firstname as upline_firstname',
                    'upline.lastname as upline_lastname',
                    )
                    ->orderBy('id','ASC');

        $params = [
            'users' => [
                'name' => 'name',
            ],
            'positions' => [
                'position' => 'name',
            ],
            'teams' => [
                'team' => 'name',
            ],
            'upline' => [
                'upline' => 'firstname',
            ],
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
        $user_status = User::$status;
        $user_role = User::$role;

        return view('backend.admin.create', [
            'admin_role' => $user_status,
            'admin_status' => $user_role,
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
        $data = static::adminStoreValidation($request);

        $admin = Admin::create([
        	'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],

        ]);

        if($admin){
            request()->session()->flash('success','Admin successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('admin-setting.index');
    }

    public static function adminStoreValidation($request){

        $data[] = $request->validate([
            'username' => ['required',
            function ($attribute, $value, $fail) {
                $admin_name = Admin::where('username', $value)->first();
                if ($admin_name) {
                    $fail('username is exists');
                }
            }
            ],
            'password' => ['required'],
            'confirm_password' => ['same:password'],
            'name' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'status' => ['required'],
            'role' => ['required'],
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
        $admin=Admin::findOrFail($id);

        return view('backend.admin.edit', [
            'admin' => $admin,
            'admin_role' => Admin::$role,
            'admin_status' => Admin::$status,
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
        $data = static::adminUpdateValidation($request, $id);

        $updateData = [
            'name' => $data['name'],
            'contact' => $data['contact'],
            'email' => $data['email'],
            'role' => $data['role'],
            'status' => $data['status'],
        ];

        if(isset($data['username'])){
            $updateData = [
                'username' => $data['username'],
            ];
        }

        if(isset($data['password'])){
            $updateData = [
                'password' => Hash::make($data['password']),
            ];
        }

        $admin=Admin::findOrFail($id);

        if($admin){
            $admin->fill($updateData)->save();
            request()->session()->flash('success','Admin successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('admin-setting.index');
    }

    public static function adminUpdateValidation($request, $id){

        $data[] = $request->validate([
            'name' => ['required'],
            'contact' => ['required'],
            'email' => ['required'],
            'status' => ['required'],
            'role' => ['required'],
        ]);

        $admin = Admin::select('username')
                        ->where('id', $id)
                        ->first();

        if($request->username != $admin->username){
            $data[] = $request->validate([
                'username' => ['required',
                function ($attribute, $value, $fail) {
                    $admin_name = Admin::where('username', $value)->first();
                    if ($admin_name) {
                        $fail('username has exist');
                    }
                }
                ],
            ]);
        }

        if($request->password != null){
            $data[] = $request->validate([
                'password' => ['required'],
                'confirm_password' => ['same:password'],
            ]);
        }

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
        $admin=Admin::findOrFail($id);

        if($admin){
            // return $child_cat_id;
            $admin = Admin::where('id', $id)->update([
                'status' => Admin::$status['inactive'],
            ]);

            request()->session()->flash('success','Admin successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting admin');
        }
        return redirect()->route('admin-setting.index');
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
