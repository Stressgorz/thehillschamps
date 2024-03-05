<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Client;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Team;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaleExport;
use Carbon\Carbon;
use App\User;

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
            $sales_status = Sale::$sales_status['pending'];
            $request->request->add([
                'sales_status' => $sales_status,
            ]);
        }

        if (empty($request->query('status'))) {
            $request->request->add([
                'status' => $request->query('status'),
            ]);
        }

        if (empty($request->query('broker_type'))) {
            $request->request->add([
                'broker_type' => $request->query('broker_type'),
            ]);
        }

        if (empty($request->query('client_email'))) {
            $request->request->add([
                'client_email' => $request->query('client_email'),
            ]);
        }
        
        if (empty($request->query('client_name'))) {
            $request->request->add([
                'client_name' => $request->query('client_name'),
            ]);
        }

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

        $table_data = $this->filter($request);
        $total_amount = 0;
        foreach($table_data as $data){
            $total_amount = $total_amount + $data->amount;
        }

        return view('backend.sales.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'total_amount' => $total_amount,
            'sales_status' => Sale::$sales_status,
            'status_data' => Sale::$status,
            'brokers' => Sale::$broker,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('sales')
                    ->leftJoin('users', 'sales.user_id' , '=', 'users.id')
                    ->leftJoin('clients', 'sales.client_id' , '=', 'clients.id')
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
                'status' => 'status',
                'broker_type' => 'broker_type',
                'date' => 'date',
            ],
            'users' => [
                'user_email' => 'email',
            ],
            'clients' => [
                'client_email' => 'email',
                'client_name' => 'name',
            ],
        ];

        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'date') {
	                if ($filters->get('fdate')) {
	                    $query->where($table.'.'.$param, '>=',  $filters->get('fdate'));
	                }
	                if ($filters->get('tdate')) {
	                    $query->where($table.'.'.$param, '<', ($filters->get('tdate')));
	                }
	            } elseif ($field == 'sales_status') { 
	                if ($filters->get('sales_status')) {
	                    $query->where($table.'.'.$param, '=',  $filters->get('sales_status'));
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

        return view('backend.sales.create', [
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

        return redirect()->route('sales-admin.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $sale = Sale::findOrFail($id);

        $sale = DB::table('sales')
                    ->leftJoin('users', 'sales.user_id' , '=', 'users.id')
                    ->leftJoin('clients', 'sales.client_id' , '=', 'clients.id')
                    ->where('sales.id', $id)
                    ->select('sales.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    'users.email as user_email',
                    'clients.name as client_name',
                    'clients.email as client_email',
                    'clients.contact as client_contact',
                    'clients.address as client_address',
                    )
                    ->first();
        
        $user_id = $sale->user_id;
        $client_id = $sale->client_id;

        $user = User::where('id', $user_id)->first();
        $client = Client::where('id', $client_id)->first();

        $user_upline = User::where('id', $user->upline_id)
                                ->select('firstname', 'lastname')
                                ->first();

        $client_upline = Client::where('id', $client->upline_client_id)
                                ->select('name')
                                ->first();

        $slips = json_decode($sale->slip);
        $slip_image = [];
        foreach($slips as $index => $slip){
            $slip_image[$index] = 'storage/'.Sale::$path.'/'.$slip;
        }

        return view('backend.sales.show', [
            'sales' => $sale ?? [],
            'user_upline' => $user_upline,
            'client_upline' => $client_upline,
            'sales_status' => Sale::$sales_status,
            'sales_broker' => Sale::$broker,
            'slip_image' => $slip_image,
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
        $sale = Sale::findOrFail($id);

        return view('backend.sales.edit', [
            'sales' => $sale,
            'sales_status' => Sale::$sales_status,
            'status_data' => Sale::$status,
            'sales_broker' => Sale::$broker,
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
        $data = static::saleUpdateValidation($request, $id);

        $updateData = [
            'amount' => $data['amount'],
            'mt4_id' => $data['mt4_id'],
            'mt4_pass' => $data['mt4_pass'],
            'broker_type' => $data['broker_type'],
            'sales_status' => $data['sales_status'],
            'status' => $data['status'],
            'reason' => $data['reason'],
            'remark' => $data['remark'],
            'date' => $data['date'],
        ];

        $sale=Sale::findOrFail($id);

        if($sale){
            $sale->fill($updateData)->save();
            request()->session()->flash('success','Sales successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('sales-admin.index');
    }

    public static function saleUpdateValidation($request, $id){

        $data[] = $request->validate([
            'amount' => ['required'],
            'mt4_id' => ['required'],
            'mt4_pass' => ['required'],
            'broker_type' => ['required'],
            'sales_status' => ['required'],
            'status' => ['required'],
            'reason' => ['nullable'],
            'remark' => ['nullable'],
            'date' => ['required'],
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
        $sale=Sale::findOrFail($id);

        if($sale){
            // return $child_cat_id;
            $sale = Sale::where('id', $id)->update([
                'status' => Sale::$status['removed'],
            ]);

            request()->session()->flash('success','Sales successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Sales');
        }
        return redirect()->route('sales-admin.index');
    }

    /**
     * Export filtered data.
     *
     */
    public function export(Request $request)
    {   
        
        $table_data = $this->filter($request);
        return Excel::download(new SaleExport($table_data), 'sales-'.Carbon::now()->format('YmdHis').'.xlsx');
    }
    
}
