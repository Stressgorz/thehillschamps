<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;
use App\Models\Order;
use App\Models\Product;
use DB;

class ThankYouController extends Controller
{
    public function index(Request $request)
    {
        if(isset($request->order_id)){
            Order::where('order_number', $request->order_id)->update(['payment_status' => Order::$payment_status['paid']]);
        }

        return view('frontend.pages.thank-you');
    }
   
}
