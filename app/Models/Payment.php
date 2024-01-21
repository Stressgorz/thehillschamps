<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Product;

class Payment extends Model
{
    // protected $fillable=['user_id','order_number','sub_total','quantity','delivery_charge','status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','shipping_id','coupon'];
    public static $payment_type = [
        'stripe' => 'stripe',
    ];

    public static function makePayment($order){

        $product_data = [];

        $cart = Cart::select('id','product_id', 'quantity', 'price')
                    ->where('user_id', auth()->user()->id)
                    ->where('order_id', NULL)
                    ->get();

        foreach($cart as $data){

            $product = Product::select('product_api_id')->where('id', $data->product_id)->first();
            $product_api_id = $product->product_api_id;

            $product_data[] = [
                'product_api_id' => $product_api_id,
                'price' => $data->price,
                'quantity' => $data->quantity,
            ];
        }
        
        $stripe = new \Stripe\StripeClient(config('app.stripe_secret'));
          $item = [];
          foreach ($product_data as $data){
            $stripe_price = $stripe->prices->all([
              'product' => $data['product_api_id'],
              'active' => true,
            ]);
            $price = $stripe_price->first();
            $item[] = [
              'price' => $price->id,
              'quantity' => $data['quantity'],
            ];
          }

          $url = $stripe->paymentLinks->create([
            'line_items' => [$item],
            'after_completion' => [
              'type' => 'redirect',
              'redirect' => ['url' => config('app.url').'/thank-you?order_id='.$order->order_number],
            ],
          ]);

          $return_data = [
            'payment_id' => $url->id,
            'payment_url' => $url->url,
          ];

          return $return_data;
    }
}
