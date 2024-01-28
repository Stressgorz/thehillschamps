<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Ads;
use Carbon\Carbon;

class AdsController extends Controller
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

        return view('backend.ads.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'ads_status' => Ads::$status,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('ads_sub')
                    ->leftJoin('users', 'ads_sub.user_id' , '=', 'users.id')
		        	->select('ads_sub.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    )
                    ->orderBy('id','ASC');
        $params = [
            'ads_sub' => [
                'status' => 'status',
                'date' => 'date',
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
        $ads_status = Ads::$status;

        return view('backend.ads.create', [
            'ads_status' => $ads_status,  
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

        return redirect()->route('ads.index');
    }

    public static function adsStoreValidation($request){

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ads = Ads::findOrFail($id);

        $user = User::select('firstname', 'lastname')
                        ->where('id', $ads->user_id)
                        ->first();
                
        return view('backend.ads.show', [
            'ads' => $ads,
            'user' => $user,
            'ads_status' => Ads::$status,
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
        $ads = Ads::findOrFail($id);

        $user = User::select('firstname', 'lastname')
                    ->where('id', $ads->user_id)
                    ->first();

        return view('backend.ads.edit', [
            'ads' => $ads,
            'user' => $user,
            'ads_status' => Ads::$status,
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
        $data = static::adsUpdateValidation($request, $id);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'bank_acc' => $data['bank_acc'],
            'bank_num' => $data['bank_num'],
            'status' => $data['status'],
        ];

        $ads=Ads::findOrFail($id);

        if($ads){
            $ads->fill($updateData)->save();
            request()->session()->flash('success','Ads successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('ads.index');
    }

    public static function adsUpdateValidation($request, $id){

        $data[] = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'contact' => ['required'],
            'bank_acc' => ['required'],
            'bank_num' => ['required'],
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
        $ads=Ads::findOrFail($id);

        if($ads){
            // return $child_cat_id;
            $ads = Ads::where('id', $id)->update([
                'status' => Ads::$status['reject'],
            ]);

            request()->session()->flash('success','Ads successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Ads');
        }
        return redirect()->route('ads.index');
    }
}
