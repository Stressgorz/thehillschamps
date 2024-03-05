<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Models\Client;
use App\Models\Sale;
use App\Models\Calendar;
use App\Models\UserWalletHistory;
use App\Models\UserWallet;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(Request $request){
        $profile=Auth()->user();
        $total_clients = Client::where('user_id', $request->user()->id)
                                ->where('status', Client::$status['active'])
                                ->count();

        $path = User::$path.'/';

        $now = Carbon::now();

        $user_wallet = UserWallet::where('user_id', $request->user()->id)
                                    ->where('wallet', UserWallet::$wallet['points'])
                                    ->pluck('balance')
                                    ->first();
                                    
        $user_points = 0;

        if($user_wallet){
            $user_points = $user_wallet;
        }

        $id = $request->user()->id;

        if(isset($request->fdate)){
            $fdate = $request->fdate;
        }

        if(isset($request->tdate)){
            $tdate = $request->tdate;
        }


        $personal_sales = Sale::where('user_id', $request->user()->id)
                                ->where('sales_status', Sale::$sales_status['approved'])
                                ->where('status', Sale::$status['active']);

                                if(isset($fdate) && $fdate){
                                    $personal_sales->where('date', '>=', $fdate);
                                }
                        
                                if(isset($tdate) && $tdate){
                                    $personal_sales->where('date', '<=', $tdate);
                                }

                                $all_personal_sales = $personal_sales->sum('amount');

        if($request->user()->position_id != 1 && $request->user()->position_id != 5){
            $direct_ib = User::where('upline_id', $id)
                        ->where('status', User::$status['active'])
                        ->whereIn('position_id', [1,5])
                        ->select('id')
                        ->pluck('id')
                        ->toArray();
            $direct_ib[] = $id;

            $direct_ib_sales = Sale::whereIn('user_id', $direct_ib)
                            ->where('sales_status', Sale::$sales_status['approved'])
                            ->where('status', Sale::$status['active']);

                            if(isset($fdate) && $fdate){
                                $direct_ib_sales->where('date', '>=', $fdate);
                            }

                            if(isset($tdate) && $tdate){
                                $direct_ib_sales->where('date', '<=', $tdate);
                            }

                            $direct_ib_sales_amount = $direct_ib_sales->sum('amount');
        }

        $all_downline = User::getAllIbDownline($id);

        $all_downline_sales = Sale::whereIn('user_id', $all_downline)
                                ->where('sales_status', Sale::$sales_status['approved'])
                                ->where('status', Sale::$status['active']);

                                if(isset($fdate) && $fdate){
                                    $all_downline_sales->where('date', '>=', $fdate);
                                }
                        
                                if(isset($tdate) && $tdate){
                                    $all_downline_sales->where('date', '<=', $tdate);
                                }

                                $all_downline_sales_amount = $all_downline_sales->sum('amount');

        // return $profile;
        return view('user.users.profile', [
            'profile' => $profile,
            'path' => $path,
            'direct_ib_sales' => $direct_ib_sales_amount ?? 0,
            'all_downline_sales' => $all_downline_sales_amount,
            'all_personal_sales' => $all_personal_sales,
            'user_points' => $user_points,
            'total_clients' => $total_clients,
        ]);
    }

    public function showprofileUpdate(){
        $profile=Auth()->user();
        
        // return $profile;
        return view('user.users.profile-edit')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){

        // return $request->all();
        $user=User::findOrFail($id);
        if($user){
            $data = static::profileUpdateValidation($request, $id);

            $path = User::$path.'/';
            $image = '';

            if (isset($data['photo'])) {

                $filename = $data['photo']->getClientOriginalName();
                $data['photo']->storeAs($path, $filename, 'public');
                $image = $filename;
            }

            $updateData = [
                'dob' => $data['dob'],
                'code' => $data['code'],
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'phone' => $data['phone'],
                'photo' => $image,
            ];

            // add birthday to calendar
            if(isset($user->id) &&  $user->dob){
                if($user->dob != $updateData['dob'])
                Calendar::addUserDOB($user->id, $updateData['dob']);
            }
            
            $user->fill($updateData)->save();

            request()->session()->flash('success','Successfully updated your profile');
        } else {
            request()->session()->flash('error','Please try again!');
        }

        return redirect()->route('user');
    }

    
    public static function profileUpdateValidation($request, $id){

        $data[] = $request->validate([
            'dob' => ['required'],
            'code' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'phone' => ['required'],
            'photo' => ['nullable'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }
    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('error','You can not delete this order now');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('success','Order Successfully deleted');
                }
                else{
                    request()->session()->flash('error','Order can not deleted');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderShow($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('user.order.show')->with('order',$order);
    }
    // Product Review
    public function productReviewIndex(){
        $reviews=ProductReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function productReviewEdit($id)
    {
        $review=ProductReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewUpdate(Request $request, $id)
    {
        $review=ProductReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('success','Review Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Review not found!!');
        }

        return redirect()->route('user.productreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productReviewDelete($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('user.productreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('success','Post Comment successfully deleted');
            }
            else{
                request()->session()->flash('error','Error occurred please try again');
            }
            return back();
        }
        else{
            request()->session()->flash('error','Post Comment not found');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('success','Comment successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('error','Comment not found');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }

    
}
