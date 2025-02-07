<?php

    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    // CACHE CLEAR ROUTE
    Route::get('cache-clear', function () {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        request()->session()->flash('success', 'Successfully cache cleared.');
        return redirect()->back();
    })->name('cache.clear');


    // STORAGE LINKED ROUTE
    Route::get('storage-link',[\App\Http\Controllers\AdminController::class,'storageLink'])->name('storage.link');


    Auth::routes(['register' => false]);

    Route::get('user/login', 'FrontendController@login')->name('login.form');
    Route::post('user/login', 'FrontendController@loginSubmit')->name('login.submit');
    Route::get('user/logout', 'FrontendController@logout')->name('user.logout');

    Route::get('user/register', 'FrontendController@register')->name('register.form');
    Route::post('user/register', 'FrontendController@registerSubmit')->name('register.submit');
// Reset password
    Route::get('password-reset', 'FrontendController@showResetForm')->name('password.reset');

    Route::get('/', 'FrontendController@index')->name('home');

// Frontend Routes
    Route::get('/home', 'FrontendController@home');
    Route::get('/about-us', 'FrontendController@aboutUs')->name('about-us');
    Route::get('/contact', 'FrontendController@contact')->name('contact');
    Route::post('/contact/message', 'MessageController@store')->name('contact.store');
    Route::get('product-detail/{slug}', 'FrontendController@productDetail')->name('product-detail');
    Route::post('/product/search', 'FrontendController@productSearch')->name('product.search');
    Route::get('/product-cat/{slug}', 'FrontendController@productCat')->name('product-cat');
    Route::get('/product-sub-cat/{slug}/{sub_slug}', 'FrontendController@productSubCat')->name('product-sub-cat');
    Route::get('/product-brand/{slug}', 'FrontendController@productBrand')->name('product-brand');
// Cart section
    Route::get('/add-to-cart/{slug}', 'CartController@addToCart')->name('add-to-cart')->middleware('user');
    Route::post('/add-to-cart', 'CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
    Route::get('cart-delete/{id}', 'CartController@cartDelete')->name('cart-delete');
    Route::post('cart-update', 'CartController@cartUpdate')->name('cart.update');

    Route::get('/cart', function () {
        return view('frontend.pages.cart');
    })->name('cart');
    Route::get('/checkout', 'CartController@checkout')->name('checkout')->middleware('user');
// Wishlist
    Route::get('/wishlist', function () {
        return view('frontend.pages.wishlist');
    })->name('wishlist');
    Route::get('/wishlist/{slug}', 'WishlistController@wishlist')->name('add-to-wishlist')->middleware('user');
    Route::get('wishlist-delete/{id}', 'WishlistController@wishlistDelete')->name('wishlist-delete');
    Route::post('cart/order', 'OrderController@store')->name('cart.order');
    Route::get('order/pdf/{id}', 'OrderController@pdf')->name('order.pdf');
    Route::get('/income', 'OrderController@incomeChart')->name('product.order.income');
// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
    Route::get('/product-grids', 'FrontendController@productGrids')->name('product-grids');
    Route::get('/product-lists', 'FrontendController@productLists')->name('product-lists');
    Route::match(['get', 'post'], '/filter', 'FrontendController@productFilter')->name('shop.filter');
// Order Track
    Route::get('/product/track', 'OrderController@orderTrack')->name('order.track');
    Route::post('product/track/order', 'OrderController@productTrackOrder')->name('product.track.order');
// Blog
    Route::get('/blog', 'FrontendController@blog')->name('blog');
    Route::get('/blog-detail/{slug}', 'FrontendController@blogDetail')->name('blog.detail');
    Route::get('/blog/search', 'FrontendController@blogSearch')->name('blog.search');
    Route::post('/blog/filter', 'FrontendController@blogFilter')->name('blog.filter');
    Route::get('blog-cat/{slug}', 'FrontendController@blogByCategory')->name('blog.category');
    Route::get('blog-tag/{slug}', 'FrontendController@blogByTag')->name('blog.tag');

// NewsLetter
    Route::post('/subscribe', 'FrontendController@subscribe')->name('subscribe');

// Product Review
    Route::resource('/review', 'ProductReviewController');
    Route::post('product/{slug}/review', 'ProductReviewController@store')->name('review.store');

// Post Comment
    Route::post('post/{slug}/comment', 'PostCommentController@store')->name('post-comment.store');
    Route::resource('/comment', 'PostCommentController');
// Coupon
    Route::post('/coupon-store', 'CouponController@couponStore')->name('coupon-store');
// Payment
    Route::get('payment', 'PayPalController@payment')->name('payment');
    Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
    Route::get('payment/success', 'PayPalController@success')->name('payment.success');

// Payment
Route::get('payment/stripe', 'StripeController@makePayment')->name('payment.stripe');
Route::get('payment/cancel', 'StripeController@cancel')->name('stripe.cancel');
Route::get('payment/success', 'StripeController@success')->name('stripe.success');

//after order page
Route::get('thank-you', 'ThankYouController@index')->name('order.thankyou');


// Socialite
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login_form');
Route::post('admin/login', 'Admin\Auth\LoginController@login')->name('admin.login');
Route::post('admin/logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');

// Socialite
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');
Route::get('testing-abcdefg', 'Test\TestingController@index');

// Backend section start
    Route::group(['prefix' => '/admin', 'middleware' => ['auth.admin', 'admin']], function () {
        
        Route::get('/', 'AdminController@index')->name('admin');

        // admin
        Route::resource('/admin-setting', 'Admin\AdminSettingController');

        // ib
        Route::get('/users/export', 'Admin\UserController@export');
        Route::resource('/users', 'Admin\UserController');
        Route::get('/ib-downline/{user_id}', 'Admin\UserController@getIbDownline')->name('get-ib-downline');
        Route::get('/client-downline/{user_id}', 'Admin\UserController@getClientDownline')->name('get-client-downline');
        Route::get('/marketer-downline/{user_id}', 'Admin\UserController@getMarketerDownline')->name('get-marketer-downline');
        Route::get('/users-points/{user_id}', 'Admin\UserController@getUserWalletHistory')->name('get-users-history');
        Route::get('/add-users-points/{user_id}', 'Admin\UserController@showUpdateUserPoints')->name('get-users-points-form');
        Route::post('/add-users-points/{user_id}', 'Admin\UserController@updateUserPoints')->name('add-users-points');


        // teams
        Route::resource('/teams', 'Admin\TeamController');

        // positions
        Route::resource('/positions', 'Admin\PositionController');
        Route::get('/positions-steps/{user_id}', 'Admin\PositionController@addPositionSteps')->name('add-position-steps');

        // kpi question
        Route::resource('/kpi-question', 'Admin\KpiController');

        // sales
        Route::get('/sales-admin/export', 'Admin\SaleController@export');
        Route::resource('/sales-admin', 'Admin\SaleController');

        // Ads
        Route::get('/ads/export', 'Admin\AdsController@export');
        Route::resource('/ads', 'Admin\AdsController');

        // Mar
        Route::get('/mar/export', 'Admin\MarController@export');
        Route::resource('/mar', 'Admin\MarController');

        // Admin Kpi
        Route::resource('/admin-kpi', 'Admin\AdminKpiController');

        // Client
        Route::get('/clients-admin/export', 'Admin\ClientController@export');
        Route::resource('/clients-admin', 'Admin\ClientController');
        Route::get('/client-admin-downline/{user_id}', 'Admin\ClientController@getClientDownline')->name('client-get-client-downline');
        Route::post('/client-admin-approve/{id}', 'Admin\ClientController@sendClientEmail')->name('admin-send-client-approval');

        // Client
        Route::resource('/announcements', 'Admin\AnnouncementController');

        // Client
        Route::resource('/calendars', 'Admin\CalendarController');

        // Leaderboard
        Route::get('/leaderboard-sale/{data_type}', 'Admin\LeaderboardController@leaderboardSales')->name('admin-get-leaderboard-sale');
        // Leaderboard
        Route::get('/leaderboard-ib/{data_type}', 'Admin\LeaderboardController@leaderboardIb')->name('admin-get-leaderboard-ib');

        // Leaderboard
        Route::get('/leaderboard-client/{data_type}', 'Admin\LeaderboardController@leaderboardClient')->name('admin-get-leaderboard-client');
        
        // Leaderboard
        Route::get('/leaderboard-setting', 'Admin\LeaderboardSettingController@index')->name('admin-get-setting');
        Route::post('/leaderboard-setting/edit/{id}', 'Admin\LeaderboardSettingController@edit')->name('admin-setting.edit');

        // Client   
        Route::resource('/sales-approval', 'Admin\SaleApprovalController');
        Route::post('/sales-approval/{id}/approve', 'Admin\SaleApprovalController@approve')->name('sales.approve');
        
        Route::get('/file-manager', function () {
            return view('backend.layouts.file-manager');
        })->name('file-manager');
        // // user route
        // Route::resource('users', 'UsersController');
        // Banner
        Route::resource('banner', 'BannerController');
        // Brand
        Route::resource('brand', 'BrandController');
        // Profile
        Route::get('/profile', 'AdminController@profile')->name('admin-profile');
        Route::post('/profile/{id}', 'AdminController@profileUpdate')->name('profile-update');
        // Category
        Route::resource('/category', 'CategoryController');
        // Product
        Route::resource('/product', 'ProductController');
        // Ajax for sub category
        Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
        // POST category
        Route::resource('/post-category', 'PostCategoryController');
        // Post tag
        Route::resource('/post-tag', 'PostTagController');
        // Post
        Route::resource('/post', 'PostController');
        // Message
        Route::resource('/message', 'MessageController');
        Route::get('/message/five', 'MessageController@messageFive')->name('messages.five');

        // Order
        Route::resource('/order', 'OrderController');
        // Shipping
        Route::resource('/shipping', 'ShippingController');
        // Coupon
        Route::resource('/coupon', 'CouponController');
        // Settings
        Route::get('settings', 'AdminController@settings')->name('settings');
        Route::post('setting/update', 'AdminController@settingsUpdate')->name('settings.update');

        // Notification
        Route::get('/notification/{id}', 'NotificationController@show')->name('admin.notification');
        Route::get('/notifications', 'NotificationController@index')->name('all.notification');
        Route::delete('/notification/{id}', 'NotificationController@delete')->name('notification.delete');
        // Password Change
        Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
        Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');

        Route::get('testing', 'Test\TestingController@index');
    });


// User section start
    Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
        Route::get('/', 'HomeController@profile')->name('user');

        // Client
        Route::resource('/targets', 'User\TargetController');

        // Client
        Route::resource('/clients', 'User\ClientController');

        // Client
        Route::resource('/sales', 'User\SaleController');

        // Client
        Route::resource('/user-kpi', 'User\UserKpiController');

        // Client
        Route::get('/user-points', 'User\PointController@index')->name('user-point-history');

        // Leaderboard
        Route::get('/leaderboard-sale/{data_type}', 'User\LeaderboardController@leaderboardSales')->name('get-leaderboard-sale');

        // Leaderboard
        Route::get('/leaderboard-ib/{data_type}', 'User\LeaderboardController@leaderboardIb')->name('get-leaderboard-ib');

        // Leaderboard
        Route::get('/leaderboard-client/{data_type}', 'User\LeaderboardController@leaderboardClient')->name('get-leaderboard-client');

        // Leaderboard
        Route::get('/road-map-points', 'User\RoadMapPointController@index')->name('road-map-points');

        // Client
        Route::get('/announcement', 'User\AnnouncementController@index')->name('announcement-data');

        // Profile
        Route::get('/profile', 'HomeController@profile')->name('user-profile'); 
        Route::get('/profile/update/{id}', 'HomeController@showprofileUpdate')->name('user-profile-update-page');
        Route::post('/profile/update/{id}', 'HomeController@profileUpdate')->name('user-profile-update');
        //  Order
        Route::get('/order', "HomeController@orderIndex")->name('user.order.index');
        Route::get('/order/show/{id}', "HomeController@orderShow")->name('user.order.show');
        Route::delete('/order/delete/{id}', 'HomeController@userOrderDelete')->name('user.order.delete');
        // Product Review
        Route::get('/user-review', 'HomeController@productReviewIndex')->name('user.productreview.index');
        Route::delete('/user-review/delete/{id}', 'HomeController@productReviewDelete')->name('user.productreview.delete');
        Route::get('/user-review/edit/{id}', 'HomeController@productReviewEdit')->name('user.productreview.edit');
        Route::patch('/user-review/update/{id}', 'HomeController@productReviewUpdate')->name('user.productreview.update');

        // Post comment
        Route::get('user-post/comment', 'HomeController@userComment')->name('user.post-comment.index');
        Route::delete('user-post/comment/delete/{id}', 'HomeController@userCommentDelete')->name('user.post-comment.delete');
        Route::get('user-post/comment/edit/{id}', 'HomeController@userCommentEdit')->name('user.post-comment.edit');
        Route::patch('user-post/comment/udpate/{id}', 'HomeController@userCommentUpdate')->name('user.post-comment.update');

        // Password Change
        Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
        Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

    });

// Client Approval
Route::get('/client-approval/{id}', 'User\ClientController@approveClient')->name('client-approve');

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
