<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\Mar;
use Carbon\Carbon;

class MarController extends Controller
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
            'ads_status' => Mar::$status,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('mar_sub')
                    ->leftJoin('users', 'mar_sub.user_id' , '=', 'users.id')
		        	->select('mar_sub.*',
                    'users.firstname as user_firstname',
                    'users.lastname as user_lastname',
                    )
                    ->orderBy('id','ASC');
        $params = [
            'mar_sub' => [
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
        $mar_status = Mar::$status;

        return view('backend.mar.create', [
            'mar_status' => $mar_status,  
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

        return redirect()->route('mar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mar = Mar::findOrFail($id);

        $user = User::select('firstname', 'lastname')
                        ->where('id', $mar->user_id)
                        ->first();
                
        return view('backend.ads.show', [
            'mar' => $mar,
            'user' => $user,
            'mar_status' => Mar::$status,
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
        $mar = Mar::findOrFail($id);

        $user = User::select('firstname', 'lastname')
                    ->where('id', $mar->user_id)
                    ->first();

        return view('backend.ads.edit', [
            'mar' => $mar,
            'user' => $user,
            'mar_status' => Mar::$status,
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
        $data = static::marUpdateValidation($request, $id);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'bank_acc' => $data['bank_acc'],
            'bank_num' => $data['bank_num'],
            'status' => $data['status'],
        ];

        $mar=Mar::findOrFail($id);

        if($mar){
            $mar->fill($updateData)->save();
            request()->session()->flash('success','Mar successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('mar.index');
    }

    public static function marUpdateValidation($request, $id){

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
        $mar=Mar::findOrFail($id);

        if($mar){
            // return $child_cat_id;
            $mar = Mar::where('id', $id)->update([
                'status' => Mar::$status['reject'],
            ]);

            request()->session()->flash('success','Mar Subsidize successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Mar Subsidize');
        }
        return redirect()->route('mar.index');
    }
}
