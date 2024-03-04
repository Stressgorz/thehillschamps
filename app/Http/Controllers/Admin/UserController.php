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
use App\Models\Sale;
use App\Models\Client;
use App\Models\UserTarget;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;
use Carbon\Carbon;
use App\Models\UserWallet;
use App\Models\Calendar;
use App\Models\UserWalletHistory;
use App\Models\UserPoint;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->query('email'))) {
            $request->request->add([
                'email' => $request->query('email'),
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
                    ->leftJoin('user_wallets', 'users.id' , '=', 'user_wallets.user_id')
                    ->leftJoin('users as upline', function ($join) {
                        $join->on('users.upline_id', '=', 'upline.id');
                    })
		        	->select('users.*',
                    'teams.name as team_name',
                    'positions.name as position_name',
                    'upline.firstname as upline_firstname',
                    'upline.lastname as upline_lastname',
                    'user_wallets.balance as user_points'
                    )
                    ->orderBy('id','ASC');

        $params = [
            'users' => [
                'email' => 'email',
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
                        ->where('status', User::$status['active'])
                        ->orderBy('firstname')
                        ->get();

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

        // add birthday to calendar
        if(isset($user->id) &&  $user->dob){
            Calendar::addUserDOB($user->id, $user->dob);
        }

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
    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if(isset($request->fdate)){
            $fdate = $request->fdate;
        }

        if(isset($request->edate)){
            $edate = $request->edate;
        }

        $direct_ib = User::where('upline_id', $id)
                            ->where('status', User::$status['active'])
                            ->where('position_id', '!=', 5)
                            ->select('id')
                            ->pluck('id')
                            ->toArray();

        $direct_ib_sales = Sale::whereIn('user_id', $direct_ib)
                                ->where('sales_status', Sale::$sales_status['approved'])
                                ->where('status', Sale::$status['active']);

                                if(isset($fdate) && $fdate){
                                    $direct_ib_sales->where('date', '>=', $fdate);
                                }

                                if(isset($edate) && $edate){
                                    $direct_ib_sales->where('date', '>=', $edate);
                                }

                                $direct_ib_sales_amount = $direct_ib_sales->sum('amount');

        $all_downline = User::getAllIbDownline($id);

        $all_downline_sales = Sale::whereIn('user_id', $all_downline)
                                ->where('sales_status', Sale::$sales_status['approved'])
                                ->where('status', Sale::$status['active']);

                                if(isset($fdate) && $fdate){
                                    $all_downline_sales->where('date', '>=', $fdate);
                                }
                        
                                if(isset($edate) && $edate){
                                    $all_downline_sales->where('date', '>=', $edate);
                                }

                                $all_downline_sales_amount = $all_downline_sales->sum('amount');
    
        $personal_sales = Sale::where('user_id', $id)
                                ->where('sales_status', Sale::$sales_status['approved'])
                                ->where('status', Sale::$status['active']);

                                if(isset($fdate) && $fdate){
                                    $personal_sales->where('date', '>=', $fdate);
                                }
                        
                                if(isset($edate) && $edate){
                                    $personal_sales->where('date', '>=', $edate);
                                }

                                $all_personal_sales = $personal_sales->sum('amount');


        return view('backend.users.show', [
            'user' => $user,
            'direct_ib_sales' => $direct_ib_sales_amount,
            'all_downline_sales' => $all_downline_sales_amount,
            'all_personal_sales' => $all_personal_sales,
            'user_status' => User::$status,
        ]);
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
            $updateData['password'] = Hash::make($data['password']);
        }

        $user=User::findOrFail($id);

        // add birthday to calendar
        if(isset($user->id) &&  $user->dob){
            if($user->dob != $updateData['dob'])
            Calendar::addUserDOB($user->id, $updateData['dob']);
        }

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
    
    public static function getIbDownline($user_id){

        $user = User::findOrFail($user_id);
        $downline = User::searchIbDownline($user->id);

        return view('backend.users.downline-ib', [
            'user' => $user,
            'data' => $downline,
        ]);
    }

    public static function getClientDownline($user_id){

        $user = User::findOrFail($user_id);
        $downline = Client::searchClientDownline($user->id);

        return view('backend.users.downline-client', [
            'user' => $user,
            'data' => $downline,
        ]);
    }

    public static function getMarketerDownline($user_id){

        $user = User::findOrFail($user_id);
        $downline = User::searchMarketerDownline($user->id);

        return view('backend.users.downline-marketer', [
            'user' => $user,
            'data' => $downline,
        ]);
    }

    public function getUserWalletHistory(Request $request, $user_id){

        if (empty($request->query('fdate'))) {
            $request->request->add([
                'fdate' => $request->query('fdate'),
            ]);
        }
        if (empty($request->query('tdate'))) {
            $request->request->add([
                'tdate' => $request->query('tdate'),
            ]);
        }

        $user_wallet_history = $this->filterUserWallet($request, $user_id);

        return view('backend.users.history', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'user_wallet_history' => $user_wallet_history,
        ]);
    }

    public static function filterUserWallet(Request $filters, $user_id)
    {
        $query = DB::table('user_wallet_history')
                    ->where('user_id', $user_id)
                    ->where('wallet', UserWallet::$wallet['points'])
		        	->select('*'
                    )
                    ->orderBy('id','DESC');

        $params = [
            'user_wallet_history' => [
                'created_at' => 'created_at',
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
    public function showUpdateUserPoints($user_id)
    {
        $transaction_type = UserPoint::$type;
        return view('backend.users.add-points', [
            'transaction_type' => $transaction_type,
            'user_id' => $user_id,
        ]);
    }

    public static function updateUserPoints(Request $request, $user_id){

        // return $request->all();
        $data = static::pointsUpdateValidation($request, $user_id);

        $transaction_type = UserWalletHistory::$transaction_type['admin_transfer'];

        $is_created = UserPoint::updateUserPoint($user_id, $data['type'], $transaction_type, $data['amount'], $data['description']);

        if($is_created){
            request()->session()->flash('success','Points successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('users.index');
    }

    public static function pointsUpdateValidation($request, $id){

        $data[] = $request->validate([
            'amount' => ['required', 'numeric'],
            'type' => array_merge(['required'], [
                function ($attribute, $value, $fail) {
                    if (! in_array($value, array_keys(UserPoint::$type))) {
                        $fail(trans('validation.in'));
                    }
                }
            ]),
            'description' => ['nullable'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }
}
