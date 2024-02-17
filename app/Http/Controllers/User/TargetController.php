<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Team;
use App\Models\UserTarget;
use App\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Helper;

class TargetController extends Controller
{

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = UserTarget::where('user_id', $request->user()->id)
                                ->where('status', UserTarget::$status['active'])
                                ->get();

        return view('user.clients.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('user.targets.create', [
            'target_status' => UserTarget::$status,
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
        $data = static::targetStoreValidation($request);
        
        $client = UserTarget::create([
            'user_id' => $request->user()->id,
        	'target' => $data['target'],
            'status' => UserTarget::$status['active'],
        ]);

        if($client){
            request()->session()->flash('success','Target successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('user');
    }

    public static function targetStoreValidation($request){

        $country = $request->country;
        $data[] = $request->validate([
            'target' => ['required'],
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
