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
use App\Models\Calendar;
use App\Models\UserWalletHistory;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\ClientPending;

class TestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // static::addAdmin();
        // static::updatePositionImage();
        // static::updateUserImage();
        // static::updateUserImage2();
        // static::updateSaleSlip();
        // static::updateSaleSlip2();
        // static::addIbBd();
        // static::addUserPoints();
        // static::emailClient();
        $client = Client::find(36);
        $user = User::find(256);

        Client::emailClient($client, $user->firstname);

        dd('done');
    }

    public static function emailClient(){

        $tomail=['tester1@hotmail.com'];
        $data = [
            'email' => 'tester1@hotmail.com',
            'client_email' => 'client@hotmail.com',
            'ib_name' => 'Tan Sohai',
            'url' => 'https://www.google.com/',
        ];

        try{
            Mail::to($data['email'])->send(new ClientPending($data));
        }catch(\Exception $e){
            dd($e->getMessage());
            // Log::error('message :'.$e->getMessage());
        }
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
                $new_user_photo = str_replace("files/profile/", "", $user->photo);
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

    public static function addIbBd(){

        $users = User::where('status', User::$status['active'])->get();

        foreach($users as $user){
            if($user->id && $user->dob){
                $dob = Carbon::parse($user->dob)->toDateString();
                if($dob >= '1500-01-01'){
                    Calendar::addUserDOB($user->id, $dob);
                }
            }
        }
    }
    public static function downlineGet($user_id){


        $user = User::where('upline_id', $user_id)
                    ->where('status', User::$status['active'])
                    ->get();

        return $user;
    }

    public static function addUserPoints(){
        $users = User::where('status', User::$status['active'])->get();
        $description = 'script add previous points';
        $type = UserPoint::$type['credit'];
        $transaction_type = UserWalletHistory::$transaction_type['admin_transfer'];

        foreach($users as $user){
            if($user->points == null){
                continue;
            }
            UserPoint::updateUserPoint($user->id, $type, $transaction_type, $user->points, $description);
        }
    }

    public static function updateSaleSlip(){
        $sales = Sale::get();
        foreach($sales as $sale){
            $update_data = [];
            if($sale->slip){
                $new_sale_slip = str_replace("files/Sales_Slip/", "", $sale->slip);
                $update_data['slip'] = $new_sale_slip;
            }
            $sale->fill($update_data)->save();
        }
    }

    public static function updateSaleSlip2(){
        $sales = Sale::get();
        foreach($sales as $sale){
            $update_data = [];
            if($sale->slip){
                $new_sale_slip = str_replace("files/slip/", "", $sale->slip);
                $update_data['slip'] = $new_sale_slip;
            }
            $sale->fill($update_data)->save();
        }
    }

}
