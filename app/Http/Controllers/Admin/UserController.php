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

class UserController extends Controller
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

        return view('backend.users.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'positions' => $positions,
            'teams' => $teams,
            'user_status' => User::$status,
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
		        	->select('users.*',
                    'teams.name as team_name',
                    'positions.name as position_name',
                    'upline.firstname as upline_firstname',
                    'upline.lastname as upline_lastname',
                    )
                    ->orderBy('id','ASC');

        $params = [
            'users' => [
                'name' => 'username',
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
        $positions = Position::where('status', Position::$status['active'])->get();
        $teams = Team::where('status', Team::$status['active'])->get();
        $users = User::select('id', 'firstname', 'lastname')
                        ->where('status', User::$status['active'])->get();

        return view('backend.users.create', [
            'user_status' => $user_status,  
            'positions' => $positions,
            'teams' => $teams,
            'users' => $users,
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
        $data = static::userStoreValidation($request);

        $user = User::create([
        	'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'code' => $data['code'],
            'ib_code' => $data['ib_code'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'team_id' => $data['team_id'],
            'position_id' => $data['position_id'],
            'upline_id' => $data['upline_id'],
            'status' => $data['status'],
        ]);

        if($user){
            request()->session()->flash('success','User successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('users.index');
    }

    public static function userStoreValidation($request){

        $data[] = $request->validate([
            'email' => ['required',
                function ($attribute, $value, $fail) {
                    $user_email = User::where('email', $value)->first();
                    if ($user_email) {
                        $fail('Email is exists');
                    }
                }],
            'password' => ['required'],
            'confirm_password' => ['same:password'],
            'username' => ['required',
                function ($attribute, $value, $fail) {
                    $username = User::where('username', $value)->first();
                    if ($username) {
                        $fail('User Name is exists');
                    }
                }
            ],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'code' => ['required'],
            'ib_code' => ['required'],
            'phone' => ['required'],
            'dob' => ['required'],
            'team_id' => ['required',
            function ($attribute, $value, $fail) {
                $team = Team::where('id', $value)
                            ->where('status', Team::$status['active'])
                            ->first();
                if (empty($team)) {
                    $fail('Team does not exist');
                }
            }],
            'position_id' => ['required',
            function ($attribute, $value, $fail) {
                $position = Position::where('id', $value)
                            ->where('status', Position::$status['active'])
                            ->first();
                if (empty($position)) {
                    $fail('Position does not exist');
                }
            }],
            'upline_id' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline = User::where('id', $value)
                            ->where('status', Position::$status['active'])
                            ->first();
                if (empty($upline)) {
                    $fail('Upline does not exist');
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
        $user = User::findOrFail($id);

        $user_status = User::$status;
        $positions = Position::where('status', Position::$status['active'])->get();
        $teams = Team::where('status', Team::$status['active'])->get();
        $users = User::select('id', 'firstname', 'lastname')
                        ->where('status', User::$status['active'])->get();


        return view('backend.users.edit', [
            'user' => $user,
            'users' => $users,
            'teams' => $teams,
            'positions' => $positions,
            'user_status' => User::$status,
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
        $data = static::userUpdateValidation($request, $id);

        $updateData = [
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'code' => $data['code'],
            'ib_code' => $data['ib_code'],
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'points' => $data['points'],
            'team_id' => $data['team_id'],
            'position_id' => $data['position_id'],
            'upline_id' => $data['upline_id'],
            'status' => $data['status'],
        ];

        if(isset($data['password'])){
            $updateData = [
                'password' => Hash::make($data['password']),
            ];
        }

        $user=User::findOrFail($id);

        if($user){
            $user->fill($updateData)->save();
            request()->session()->flash('success','User successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('users.index');
    }

    public static function userUpdateValidation($request, $id){


        $data[] = $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'code' => ['required'],
            'ib_code' => ['required'],
            'phone' => ['required'],
            'dob' => ['required'],
            'points' => ['nullable'],
            'team_id' => ['required',
            function ($attribute, $value, $fail) {
                $team = Team::where('id', $value)
                            ->where('status', Team::$status['active'])
                            ->first();
                if (empty($team)) {
                    $fail('Team does not exist');
                }
            }],
            'position_id' => ['required',
            function ($attribute, $value, $fail) {
                $position = Position::where('id', $value)
                            ->where('status', Position::$status['active'])
                            ->first();
                if (empty($position)) {
                    $fail('Position does not exist');
                }
            }],
            'upline_id' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline = User::where('id', $value)
                            ->where('status', Position::$status['active'])
                            ->first();
                if (empty($upline)) {
                    $fail('Upline does not exist');
                }
            }],
            'status' => ['required'],
        ]);

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
        $user=User::findOrFail($id);

        if($user){
            // return $child_cat_id;
            $user = User::where('id', $id)->update([
                'status' => User::$status['inactive'],
            ]);

            request()->session()->flash('success','User successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting User');
        }
        return redirect()->route('users.index');
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
