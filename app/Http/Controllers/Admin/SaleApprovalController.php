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
use App\Exports\MembersExport;
use Carbon\Carbon;
use App\User;

class SaleApprovalController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $table_data = $this->filter($request);

        return view('backend.sales-approval.index', [
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
                    ->where('sales.sales_status', Sale::$sales_status['pending'])
                    ->orderBy('id','DESC');

        $params = [];

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
        $user_upline_name = '';
        $client_upline_name = '';
        if($user_upline){
            $user_upline_name = $user_upline->firstname.' '.$user_upline->lastname;
        }

        if($client_upline){
            $client_upline_name = $client_upline->name;
        }
        return view('backend.sales-approval.show', [
            'sales' => $sale ?? [],
            'user_upline_name' => $user_upline_name,
            'client_upline_name' => $client_upline_name,
            'sales_status' => Sale::$sales_status,
            'sales_broker' => Sale::$broker,
        ]);
    }

            /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request, $id)
    {
        $sale=Sale::findOrFail($id);

        if($sale){
            // return $child_cat_id;
            $sale = Sale::where('id', $id)->update([
                'sales_status' => Sale::$sales_status['approved'],
            ]);

            request()->session()->flash('success','Sales successfully approved');
        } else {
            request()->session()->flash('error','Error while approving Sales');
        }
        return redirect()->route('sales-approval.index');
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
                'sales_status' => Sale::$sales_status['reject'],
            ]);

            request()->session()->flash('success','Sales successfully rejected');
        } else {
            request()->session()->flash('error','Error while rejecting Sales');
        }
        return redirect()->route('sales-approval.index');
    }


}
