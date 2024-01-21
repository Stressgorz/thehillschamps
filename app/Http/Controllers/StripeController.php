<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Illuminate\Http\Request;
use Models\product;

class StripeController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function makePayment(Request $request)
    {  
        dd($request);
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $domain = $host = request()->getHttpHost();

        $checkout_session = Stripe::create([
            'customer_email' => 'customer@example.com',
            'submit_type' => 'donate',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
              'allowed_countries' => ['US', 'CA'],
            ],
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              'price' => '{{PRICE_ID}}',
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $domain . '/success',
            'cancel_url' => $domain . '/cancel',
          ]);

          
    }

        /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }

        /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        // return $response;
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            request()->session()->flash('success','You successfully pay from Paypal! Thank You');
            session()->forget('cart');
            session()->forget('coupon');
            return redirect()->route('home');
        }
  
        request()->session()->flash('error','Something went wrong please try again!!!');
        return redirect()->back();
    }
}
