<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Team;
use App\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ClientController extends Controller
{

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $now = Carbon::now();

        if (empty($request->query('status'))) {
            $request->request->add([
                'status' => $request->query('status'),
            ]);
        }

        if (empty($request->query('name'))) {
            $request->request->add([
                'name' => $request->query('name'),
            ]);
        }

        if (empty($request->query('upline_user_email'))) {
            $request->request->add([
                'upline_user_email' => $request->query('upline_user_email'),
            ]);
        }

        if (empty($request->query('upline_client_name'))) {
            $request->request->add([
                'upline_client_name' => $request->query('upline_client_name'),
            ]);
        }

        $teams = Team::all();

        $table_data = $this->filter($request);

        return view('user.clients.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'teams' => $teams,
            'client_status' => Client::$status,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('clients')
                    ->leftJoin('users', 'clients.user_id' , '=', 'users.id')
                    ->leftJoin('teams', 'users.team_id' , '=', 'teams.id')
                    ->leftJoin('clients as client_upline', function ($join) {
                        $join->on('clients.upline_client_id', '=', 'client_upline.id');
                    })
                    ->leftJoin('users as user_upline', function ($join) {
                        $join->on('clients.upline_user_id', '=', 'user_upline.id');
                    })
                    ->where('clients.user_id', $filters->user()->id)
		        	->select('clients.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    'users.email as upline_user_email',
                    'user_upline.firstname as upline_user_firstname',
                    'user_upline.lastname as upline_user_lastname',
                    'user_upline.email as upline_user_email',
                    'client_upline.name as upline_client_name',
                    'teams.name as team_name',
                );

        $params = [
            'clients' => [
                'name' => 'name',
                'status' => 'status',
            ],
            'users' => [
                'user_email' => 'email',
            ],
            'user_upline' => [
                'upline_user_email' => 'email',
            ],
            'client_upline' => [
                'upline_client_name' => 'name',
            ],
            'teams' => [
                'team_name' => 'name',
            ],
        ];
        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'date') {
	                if ($filters->query('fdate')) {
	                    $query->where($table.'.'.$param, '>=',  $filters->query('fdate'));
	                }
	                if ($filters->query('tdate')) {
	                    $query->where($table.'.'.$param, '<=', ($filters->query('tdate').' 23:59:59'));
	                }
	            } elseif (is_array($filters->query($field)) && ! empty($filters->query($field))) { 
	                // If is array and not empty
	                $query->whereIn($table.'.'.$param, $filters->get($field));
	            } else {
                    if (! empty($filters->get($field))) {
                        if (in_array($field, ['status', 'type'])) { 
                            $query->where($table.'.'.$param, '=',  $filters->get($field));
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
        $client_status = Client::$status;

        return view('user.clients.create', [
            'client_status' => $client_status,

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
        $data = static::clientStoreValidation($request);
        $upline_client_id = Client::where('email', $data['upline_client_email'])->pluck('id')->first();
        $upline_user_id = User::where('email', $data['upline_user_email'])->pluck('id')->first();

        $client = Client::create([
            'user_id' => $request->user()->id,
        	'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'address' => $data['address'],
            'upline_client_id' => $upline_client_id ??0,
            'upline_user_id' => $upline_user_id??0,
            'status' => Client::$status['active'],
        ]);

        if($client){
            request()->session()->flash('success','client successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('clients.index');
    }

    public static function clientStoreValidation($request){

        $data[] = $request->validate([
            'email' => ['required',
            function ($attribute, $value, $fail) {
                $email = Client::where('email', $value)->first();
                if ($email) {
                    $fail('Email is exists');
                }
            }
            ],
            'upline_user_email' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline_user_email = User::where('email', $value)->first();
                if (empty($upline_user_email)) {
                    $fail('Upline User does not exists');
                }
            }
            ],
            'upline_client_email' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline_client_email = Client::where('email', $value)->first();
                if (empty($upline_client_email)) {
                    $fail('Upline Client does not exists');
                }
            }
            ],
            'name' => ['required'],
            'contact' => ['required'],
            'address' => ['required'],
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
        $client = DB::table('clients')
                    ->leftJoin('users', 'clients.user_id' , '=', 'users.id')
                    ->leftJoin('clients as client_upline', function ($join) {
                        $join->on('clients.upline_client_id', '=', 'client_upline.id');
                    })
                    ->leftJoin('users as user_upline', function ($join) {
                        $join->on('clients.upline_user_id', '=', 'user_upline.id');
                    })
		        	->select('clients.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    'users.email as user_email',
                    'user_upline.firstname as upline_user_firstname',
                    'user_upline.lastname as upline_user_lastname',
                    'user_upline.email as upline_user_email',
                    'client_upline.name as upline_client_name',
                    'client_upline.email as upline_client_email',
                    )
                    ->where('clients.id', $id)
                    ->first();

        return view('user.clients.edit', [
            'client' => $client,
            'client_status' => Client::$status,
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
        $data = static::clientUpdateValidation($request, $id);

        $user_id = User::where('email', $data['user_email'])->pluck('id')->first();
        $upline_user_id = User::where('email', $data['upline_user_email'])->pluck('id')->first();
        $upline_client_id = Client::where('email', $data['upline_client_email'])->pluck('id')->first();

        $updateData = [
        	'user_id' => $user_id,
        	'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'address' => $data['address'],  
            'upline_client_id' => $upline_client_id,
            'upline_user_id' => $upline_user_id,
            'status' => $data['status'],
        ];

        $client=Client::findOrFail($id);

        if($client){
            $client->fill($updateData)->save();
            request()->session()->flash('success','Client successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('clients.index');
    }

    public static function clientUpdateValidation($request, $id){

        $client = Client::find($id);
        $data[] = $request->validate([
            'user_email' => ['required',
            function ($attribute, $value, $fail) {
                $user_id = User::where('email', $value)->first();
                if (empty($user_id)) {
                    $fail('User does not exists');
                }
            }
            ],
            'upline_user_email' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline_user_id = User::where('email', $value)->first();
                if (empty($upline_user_id)) {
                    $fail('Upline User does not exists');
                }
            }
            ],
            'upline_client_email' => ['nullable',
            function ($attribute, $value, $fail) {
                $upline_client_id = Client::where('email', $value)->first();
                if (empty($upline_client_id)) {
                    $fail('Upline Client does not exists');
                }
            }
            ],
            'name' => ['required'],
            'email' => ['required'],
            'contact' => ['required'],
            'address' => ['required'],
            'status' => ['required'],
        ]);

        if($request->email != $client->email){
            $data[] = $request->validate([
                'email' => ['required',
                function ($attribute, $value, $fail) {
                    $email = Client::where('email', $value)->first();
                    if ($email) {
                        $fail('Email is exists');
                    }
                }
                ],
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
        $client=Client::findOrFail($id);

        if($client){
            // return $child_cat_id;
            $client = Client::where('id', $id)->update([
                'status' => Client::$status['inactive'],
            ]);

            request()->session()->flash('success','Client successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Client');
        }
        return redirect()->route('clients.index');
    }
}
