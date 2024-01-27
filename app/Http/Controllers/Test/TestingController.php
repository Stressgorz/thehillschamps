<?php

namespace App\Http\Controllers\Test;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Team;
use App\Models\Client;
use App\Models\Sale;
use Illuminate\Support\Facades\Hash;
use App\User;

class TestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        // $datas = Sale::all();

        // foreach($datas as $data){

        //     $status = '';
        //     $is_update =  false;
        //     if($data->sales_status == 'Approve'){
        //         $is_update = true;
        //         $status = Sale::$sales_status['approved'];
        //     } elseif($data->sales_status == 'Pending') {
        //         $is_update = true;
        //         $status = Sale::$sales_status['pending'];    
        //     } elseif($data->sales_status == 'Reject') {
        //         $is_update = true;
        //         $status = Sale::$sales_status['reject'];   
        //     }

        //     if($is_update == true){
        //         Sale::where('id', $data->id)->update([
        //             'sales_status' => $status,
        //         ]);
        //     }
        // }
        // $admin = Admin::create([
        //     'username' => 'admin',
        //     'password'=>Hash::make('admin'),
        //     'name' => 'admin',
        //     'contact' => '12321321321',
        //     'email' => 'admin@admin.com',
        //     'status' => 'active',
        // ]);
    }
}
