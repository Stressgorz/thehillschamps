<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Client;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\UserKpi;
use App\Models\Kpi;
use App\Models\KpiAnswer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;
use Carbon\Carbon;
use App\User;

class UserKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $now = Carbon::now();

        if (empty($request->query('fdate'))) {
            $request->request->add([
                'fdate' => $request->query('fdate'),
            ]);
        }
        if (empty($request->query('tdate'))) {
            $request->request->add([
                'tdate' =>$request->query('tdate'),
            ]);
        }

        $table_data = $this->filter($request);

        return view('user.user_kpi.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'user_kpi_status' => UserKpi::$status,
            'brokers' => Sale::$broker,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('user_kpi')
                    ->where('user_id', $filters->user()->id)
		        	->select('*'
                    )
                    ->orderBy('id','ASC');

        $params = [
            'user_kpi' => [
                'fdate' => 'created_at',
                'tdate' => 'created_at',
            ],
        ];

        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'created_at') {
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
    public function create(Request $request)
    {
        $position_id = $request->user()->position_id;
        $kpi_question = [];
        if($position_id){
            $questions = Kpi::where('position_id', $position_id)
                            ->where('status', Kpi::$status['active'])
                            ->orderBy('sort')
                            ->get();

            foreach($questions as $question_index => $question){

                $answers = KpiAnswer::where('kpi_id', $question->id)
                                    ->where('status', KpiAnswer::$status['active'])
                                    ->orderBy('sort')
                                    ->get();

                foreach($answers as $answer_index => $answer){
                    $kpi_question[$question->sort][$question->name][$answer->sort]['answer'] = $answer->name;
                    $kpi_question[$question->sort][$question->name][$answer->sort]['points'] = $answer->points;
                }
            }
        }

        foreach($kpi_question as $question_no => $question){

            foreach($question as $kpi_answer){
                foreach($kpi_answer as $answer_no => $answer){

                }
            }
        }
        return view('user.user_kpi.create', [
            'kpi_question' => $kpi_question,
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

        $data = static::saleStoreValidation($request);

        foreach ($data['slip'] as $slip) {
            $path = Sale::$path.'/';
            if (isset($slip)) {
                $filename = $slip->getClientOriginalName();
                $slip->storeAs($path, $filename, 'public');
                $image[] = $filename;
            }
    	}   

        $sales = Sale::create([
            'client_id' => $data['client_id'],
            'user_id' => $request->user()->id,
            'amount' => $data['amount'],
            'type' => 1,
            'mt4_id' => $data['mt4_id'],
            'mt4_pass' => $data['mt4_pass'],
            'broker_type' => $data['broker_type'],
            'slip' => json_encode($image),
            'remark' => $data['remark'],
            'date' => $data['date'],
            'status' => Sale::$status['active'],
            'sales_status' => Sale::$sales_status['pending'],
        ]);

        if($sales){
            request()->session()->flash('success','Sales successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('sales.index');
    }

    public static function saleStoreValidation($request){

        $data[] = $request->validate([
            'client_id' => ['required',
            function ($attribute, $value, $fail) use ($request) {
                $clients = Client::where('id', $value)
                                        ->where('user_id', $request->user()->id)
                                        ->first();
                if (empty($clients)) {
                    $fail('Client does not exists');
                } else {
                    if($clients->status != Client::$status['active']){
                        $fail('Client is not activated, pls kindly ask client to verify at their email');
                    }
                }
            }
            ],
            'amount' => ['required'],
            'mt4_id' => ['required'],
            'mt4_pass' => ['required'],
            'broker_type' => ['required'],
            'slip' => ['required'],
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

        if($user_upline){
            $user_upline->username = $user_upline->firstname.' '.$user_upline->lastname;
        }

        $slips = json_decode($sale->slip);
        $slip_image = [];
        foreach($slips as $index => $slip){
            $slip_image[$index] = 'storage/'.Sale::$path.'/'.$slip;
        }

        return view('user.sales.show', [
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

        $slips = json_decode($sale->slip);
        $slip_image = [];
        foreach($slips as $index => $slip){
            $slip_image[$index] = 'storage/'.Sale::$path.'/'.$slip;
        }

        return view('user.sales.edit', [
            'sales' => $sale,
            'sales_status' => Sale::$sales_status,
            'sales_broker' => Sale::$broker,
            'slip_image' => $slip_image,
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
        $image = [];
    	foreach ($data['slip'] as $slip) {

            $path = Sale::$path.'/'.$id;
            if (isset($slip)) {
                $filename = $slip->getClientOriginalName();
                $slip->storeAs($path, $filename, 'public');
                $image[] = $filename;
            }
    	}   

        $updateData = [
            'amount' => $data['amount'],
            'mt4_id' => $data['mt4_id'],
            'mt4_pass' => $data['mt4_pass'],
            'broker_type' => $data['broker_type'],
            'sales_status' => $data['sales_status'],
            'slip' => $image,
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

        return redirect()->route('sales.index');
    }

    public static function saleUpdateValidation($request, $id){

        $data[] = $request->validate([
            'amount' => ['required'],
            'mt4_id' => ['required'],
            'mt4_pass' => ['required'],
            'broker_type' => ['required'],
            'sales_status' => ['required'],
            'slip' => ['required'],
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
                'status' => Sale::$status['inactive'],
            ]);

            request()->session()->flash('success','Sales successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Sales');
        }
        return redirect()->route('sales.index');
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
