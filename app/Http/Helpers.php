<?php
use App\Models\Message;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;

// use Auth;
class Helper{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    } 
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    } 
    
    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>
            
            <li>
            <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    public static function postTagList($option='all'){
        if($option='all'){
            return PostTag::orderBy('id','desc')->get();
        }
        return PostTag::has('posts')->orderBy('id','desc')->get();
    }

    public static function postCategoryList($option="all"){
        if($option='all'){
            return PostCategory::orderBy('id','DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id','DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    public static function totalCartPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::with('product')->where('user_id',$user_id)->where('cart_id',null)->get();
        }
        else{
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Wishlist::where('user_id',$user_id)->where('cart_id',null)->sum('amount');
        }
        else{
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }

    

    public static function random_str($length, $keyspace = '01234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for($i = 0; $i < $length; ++$i) {
            $pieces [] =$keyspace[random_int(0,$max)];
        }
        return implode('', $pieces);
    }


    public static $general_status = [
        '1' => 'Active',
        '9' => 'Inactive',
        '999' => 'Removed',
    ];

    public static $client_status = [
        '1' => 'Active',
        '9' => 'Pending',
        '999' => 'Inactive',
    ];


    public static $approval_status = [
        '1' => 'Approved',
        '9' => 'Pending',
        '999' => 'Reject',
    ];

    public static $genders = [
        'm' => 'Male',
        'f' => 'Female',
    ];

    public static $year = [
        '2019',
        '2020',
        '2021',
        '2022',
        '2023',
        '2024',
        '2025',
        '2026',
        '2027',
    ];

    public static $month = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
    ];


    public static $country = [
        'AU' => 'AU',
        'BD' => 'BD',
        'BN' => 'BN',
        'KH' => 'KH',
        'CN' => 'CN',
        'HK' => 'HK',
        'IN' => 'IN',
        'ID' => 'ID',
        'JP' => 'JP',
        'LA' => 'LA',
        'MY' => 'MY',
        'MV' => 'MV',
        'MN' => 'MN',
        'NP' => 'NP',
        'NZ' => 'NZ',
        'PK' => 'PK',
        'PH' => 'PH',
        'SG' => 'SG',
        'KR' => 'KR',
        'LK' => 'LK',
        'TW' => 'TW',
        'TH' => 'TH',
        'VN' => 'VN',
        'US' => 'US',
        'UK' => 'UK',
        'DK' => 'DK',
        'ES' => 'ES',
        'OO' => 'OO',
    ];

    public static $country_name = [
        'AU' => 'Australia',
        'BD' => 'Bangladesh',
        'BN' => 'Brunei',
        'KH' => 'Cambodia',
        'CN' => 'China',
        'HK' => 'Hong Kong',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'JP' => 'Japan',
        'LA' => 'Laos',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'MN' => 'Mangolia',
        'NP' => 'Nepal',
        'NZ' => 'New Zealand',
        'PK' => 'Pakistan',
        'PH' => 'Philippines',
        'SG' => 'Singapore',
        'KR' => 'South Korea',
        'LK' => 'Sri Lanka',
        'TW' => 'Taiwan',
        'TH' => 'Thailand',
        'VN' => 'Vietnam',
        'US' => 'United States',
        'UK' => 'United Kingdom',
        'DK' => 'Denmark',
        'ES' => 'Spain',
        'OO' => 'Others',
    ];

    public static $state = [
        'AU' => [
            'Others',
        ],
        'BD' => [
            'Others',
        ],
        'BN' => [
            'Others',
        ],
        'KH' => [
            'Others',
        ],
        'CN' => [
            'Others',
        ],
        'HK' => [
            'Others',
        ],
        'IN' => [
            'Others',
        ],
        'ID' => [
            'Others',
        ],
        'JP' => [
            'Others',
        ],
        'LA' => [
            'Others',
        ],
        'MY' => [
            'Johor',
            'Kedah',
            'Kelantan',
            'Kuala Lumpur',
            'Melaka',
            'Negeri Sembilan',
            'Pahang',
            'Penang',
            'Perak',
            'Perlis',
            'Sabah',
            'Sarawak',
            'Selangor',
            'Terengganu',
        ],
        'MV' => [
            'Others',
        ],
        'MN' => [
            'Others',
        ],
        'NP' => [
            'Others',
        ],
        'NZ' => [
            'Others',
        ],
        'PK' => [
            'Others',
        ],
        'PH' => [
            'Others',
        ],
        'SG' => [
            'Others',
        ],
        'KR' => [
            'Others',
        ],
        'LK' => [
            'Others',
        ],
        'TW' => [
            'Others',
        ],
        'TH' => [
            'Others',
        ],
        'VN' => [
            'Others',
        ],
        'US' => [
            'Others',
        ],
        'UK' => [
            'Others',
        ],
        'DK' => [
            'Others',
        ],
        'ES' => [
            'Others',
        ],
        'OO' => [
            'Others',
        ],
    ];
}

?>