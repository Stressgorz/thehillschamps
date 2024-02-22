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
use App\Models\Position;
use App\Models\UserPoint;

class TestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // static::updatePositionImage();
        // static::updateUserImage();
        static::addAdmin();
        dd('done');
        $user_id = 82;
        $type = 'debit';
        $transaction_type = 'admin_transfer';
        $amount = 200;
        $description = 'hahahaha';
        $haha = UserPoint::updateUserPoint($user_id, $type, $transaction_type, $amount, $description);

        dd($haha);

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

    public static function updatePositionImage(){
        $positions = Position::get();
        foreach($positions as $position){
            $update_data = [];
            if($position->step1_img){
                $new_step1_img = str_replace("upload/images/", "", $position->step1_img);
                $update_data['step1_img'] = $new_step1_img;
            }
            if($position->step2_img){
                $new_step2_img = str_replace("upload/images/", "", $position->step2_img);
                $update_data['step2_img'] = $new_step2_img;
            }
            if($position->step3_img){
                $new_step3_img = str_replace("upload/images/", "", $position->step3_img);
                $update_data['step3_img'] = $new_step3_img;
            }
            if($position->step4_img){
                $new_step4_img = str_replace("upload/images/", "", $position->step4_img);
                $update_data['step4_img'] = $new_step4_img;
            }
            if($position->step5_img){
                $new_step5_img = str_replace("upload/images/", "", $position->step5_img);
                $update_data['step5_img'] = $new_step5_img;
            }

            $position->fill($update_data)->save();
        }
    }

    public static function updateUserImage(){
        $users = User::where('status', User::$status['active'])->get();
        foreach($users as $user){
            $update_data = [];
            if($user->photo){
                $new_user_photo = str_replace("files/Profile_Pic/", "", $user->photo);
                $update_data['photo'] = $new_user_photo;
            }
            $user->fill($update_data)->save();
        }
    }

    public static function updateUserImage2(){
        $users = User::where('status', User::$status['active'])->get();
        foreach($users as $user){
            $update_data = [];
            if($user->photo){
                $new_user_photo = str_replace("files/Profile_Pic/", "", $user->photo);
                $update_data['photo'] = $new_user_photo;
            }
            $user->fill($update_data)->save();
        }
    }

    public static function addAdmin(){

        $admin = Admin::where('email', 'admin@admin.com')->first();

        if(empty($admin)){
            Admin::create([
                'name' => 'Admin',
                'contact' => '123456789',
                'email' => 'admin@admin.com',
                'password' => Hash::make('qwer1234'),
                'status' => Admin::$status['active'],
            ]);
        }
    }
    public static function downlineGet($user_id){


        $user = User::where('upline_id', $user_id)
                    ->where('status', User::$status['active'])
                    ->get();

        return $user;
    }

}
