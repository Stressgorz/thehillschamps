<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $user = Auth::user(); // using the Auth facade
    @endphp
    <!-- Must -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('UI/styles/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('UI/styles/style.css') }}">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap"
        rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('UI/fonts/css/fontawesome-all.min.css') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('UI/_manifest.json') }}">

    <!-- PWA Splash -->
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 440px) and (device-height: 956px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_16_Pro_Max_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 402px) and (device-height: 874px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_16_Pro_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_16_Plus__iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_16__iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_11_Pro_Max__iPhone_XS_Max_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_11__iPhone_XR_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 1032px) and (device-height: 1376px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/13__iPad_Pro_M4_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/12.9__iPad_Pro_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1210px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/11__iPad_Pro_M4_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/11__iPad_Pro__10.5__iPad_Pro_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/10.9__iPad_Air_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/10.5__iPad_Air_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/10.2__iPad_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)"
        href="{{ asset('UI/app/splash/8.3__iPad_Mini_landscape.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 440px) and (device-height: 956px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_16_Pro_Max_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 402px) and (device-height: 874px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_16_Pro_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 430px) and (device-height: 932px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_16_Plus__iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 393px) and (device-height: 852px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_16__iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_11_Pro_Max__iPhone_XS_Max_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_11__iPhone_XR_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 1032px) and (device-height: 1376px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/13__iPad_Pro_M4_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/12.9__iPad_Pro_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1210px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/11__iPad_Pro_M4_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/11__iPad_Pro__10.5__iPad_Pro_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 820px) and (device-height: 1180px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/10.9__iPad_Air_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/10.5__iPad_Air_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/10.2__iPad_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait.png') }}">
    <link rel="apple-touch-startup-image"
        media="screen and (device-width: 744px) and (device-height: 1133px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)"
        href="{{ asset('UI/app/splash/8.3__iPad_Mini_portrait.png') }}">


</head>



<body class="theme-light" data-highlight="highlight-red" data-gradient="body-default">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>



    <div id="app">
        {{-- nav --}}


        <!-- Page Content -->
        <main>

            <div id="main">
                <div id="page">
                    <div class="menu-hider" id="closee-menu3"></div>
                    {{-- above bar --}}
                    <div class="header header-fixed header-logo-center header-auto-show"
                        style="height: 300px !important;top: -250px;">
                        <a href="{{ url('index.html') }}" class="header-title" style="bottom: 0"><img
                                src="{{ asset('UI/app/icons/logo.png') }}" width="42">The Hills International</a>

                        <a href="#" style="z-index: 101;bottom: 0" data-back-button
                            class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
                    </div>
                    {{-- bottom bar --}}
                    <div style="z-index: 101;
                                right: 20px;
                                left: 20px;
                                border-radius: 15px !important;
                                height: 65px;
                                bottom: 28px;
                                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;"
                        id="footer-bar" class="footer-bar-1  rounded-s footer-bar-scroll">


                        <a href="#" class="" id="togglee-menu" data-menu="menu-sidebar-left-1"
                            style="padding-top: 24px;">
                            <i class="fa fa-bars"></i>
                        </a>

                        <a href="#" style="display: none" class="close-menu" id="closee-menu"
                            data-menu="menu-sidebar-left-1" style="padding-top: 24px;">
                            <i class="fa fa-times"></i>
                        </a>







                        @if (auth()->user()->position_id != 5)
                            <a href="{{ route('performance.view') }}" style="padding-top: 24px;"
                                class="{{ Request::is('performance') ? 'active-nav' : '' }}"><i
                                    class="fas fa-chart-line"></i></a>
                        @endif
                        <a href="{{ route('home.view') }}" style="padding-top: 24px;"
                            class="{{ Route::currentRouteName() == 'home.view' ? 'active-nav' : '' }}">
                            <img style="margin-top:-13px" src="{{ asset('UI/app/icons/logo2.png') }}" width="49"
                                class="" alt="img">
                            <span></span><strong></strong></a>
                        @if (auth()->user()->position_id != 5)
                            <a href="{{ route('leaderboard.view') }}" style="padding-top: 24px;"
                                class="{{ Route::currentRouteName() == 'leaderboard.view' ? 'active-nav' : '' }}"><i
                                    class="fas fa-trophy"></i></a>
                        @endif

                        @if (auth()->user()->position_id != 5)
                            <a href="#"><i class="fa fa-chevron-right"></i></a>
                        @endif
                        <a href="{{ route('requirement.view') }}" style="padding-top: 24px;"
                            class="{{ Route::currentRouteName() == 'requirement.view' ? 'active-nav' : '' }}"><i
                                class="fas fa-tasks"></i></a>

                        @if (auth()->user()->position_id != 5)
                            <a href="{{ route('roadmap.view') }}" style="padding-top: 24px;"
                                class="{{ Route::currentRouteName() == 'roadmap.view' ? 'active-nav' : '' }}"><i
                                    class="fas fa-route"></i></a>
                        @endif
                        @if (auth()->user()->position_id != 5)
                            <a href="{{ route('incentive.view') }}" style="padding-top: 24px;"
                                class="{{ Route::currentRouteName() == 'incentive.view' ? 'active-nav' : '' }}"><i
                                    class="fas fa-gift"></i></a>
                        @endif
                    </div>





                    <div class="page-content mt-4">
                        {{ $slot }}

                        <div class="footer card card-style">


                            <p class="footer-copyright mb-3">Copyright &copy; TheHillsInternational <span
                                    id="copyright-year">2025</span>.
                                All
                                Rights
                                Reserved.</p>
                            <div class="clear"></div>
                        </div>
                    </div>


                   
                </div>






                {{-- open side bar --}}
                <!-- All Menus, Action Sheets, Modals, Notifications, Toasts, Snackbars get Placed outside the <div class=\"page-content\"> -->
                {{-- <div id="menu-settings" class="menu menu-box-bottom menu-box-detached">
                    <div class="menu-title mt-0 pt-0">
                        <h1>Settings</h1>
                        <p class="color-highlight">Flexible and Easy to Use</p>
                        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="divider divider-margins mb-n2"></div>
                    <div class="content">
                        <div class="list-group list-custom-small">
                            <a href="#" data-toggle-theme data-trigger-switch="switch-dark-mode"
                                class="pb-2 ms-n1">
                                <i class="fa font-12 fa-moon rounded-s bg-highlight color-white me-3"></i>
                                <span>Dark Mode</span>
                                <div class="custom-control scale-switch ios-switch">
                                    <input data-toggle-theme type="checkbox" class="ios-input" id="switch-dark-mode">
                                    <label class="custom-control-label" for="switch-dark-mode"></label>
                                </div>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                        <div class="list-group list-custom-large">
                            <a data-menu="menu-highlights" href="#">
                                <i class="fa font-14 fa-tint bg-green-dark rounded-s"></i>
                                <span>Page Highlight</span>
                                <strong>16 Colors Highlights Included</strong>
                                <span class="badge bg-highlight color-white">HOT</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a data-menu="menu-backgrounds" href="#" class="border-0">
                                <i class="fa font-14 fa-cog bg-blue-dark rounded-s"></i>
                                <span>Background Color</span>
                                <strong>10 Page Gradients Included</strong>
                                <span class="badge bg-highlight color-white">NEW</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div> --}}
                <!-- Menu Share -->
                <div id="menu-share" class="menu menu-box-bottom menu-box-detached">
                    <div class="menu-title mt-n1">
                        <h1>Share the Love</h1>
                        <p class="color-highlight">Just Tap the Social Icon. We'll add the Link</p>
                        <a href="#" class="close-menu"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="content mb-0">
                        <div class="divider mb-0"></div>
                        <div class="list-group list-custom-small list-icon-0">
                            <a href="auto_generated" class="shareToFacebook external-link">
                                <i class="font-18 fab fa-facebook-square color-facebook"></i>
                                <span class="font-13">Facebook</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="auto_generated" class="shareToTwitter external-link">
                                <i class="font-18 fab fa-twitter-square color-twitter"></i>
                                <span class="font-13">Twitter</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="auto_generated" class="shareToLinkedIn external-link">
                                <i class="font-18 fab fa-linkedin color-linkedin"></i>
                                <span class="font-13">LinkedIn</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="auto_generated" class="shareToWhatsApp external-link">
                                <i class="font-18 fab fa-whatsapp-square color-whatsapp"></i>
                                <span class="font-13">WhatsApp</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="auto_generated" class="shareToMail external-link border-0">
                                <i class="font-18 fa fa-envelope-square color-mail"></i>
                                <span class="font-13">Email</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="menu-sidebar-left-1" class="menu menu-box-left menu-box-detached menu-sidebar"
                    style="display: block;
                            width: auto;
                            right: 20px !important;
                            left: 20px !important;
                            top: auto !important;
                            bottom: 106px !important;
                            height: 80%;">

                    <div class="sidebar-content">

                        <div class=" mx-3 rounded-m  mt-3">
                            <div class="d-flex  pb-2 pt-2">
                                <div class="align-self-center">
                                    <a href="#"><img src="{{ asset('UI/app/icons/logo.png') }}" width="70"
                                            class="rounded-sm" alt="img"></a>
                                </div>
                                <div class=" align-self-center">
                                    <h5 class="ps-1 mb-1 pt-1 line-height-xs font-18">The Hills International</h5>
                                    <h6 class="ps-1 mb-0 font-400 opacity-80 font-14">Champs</h6>
                                </div>
                            </div>
                            <div class=" menu-title mt-0 pt-0">
                                <a href="#" id="closee-menu2" class="close-menu"><i
                                        class="fa fa-times"></i></a>
                            </div>
                        </div>

                        <div class="bg-theme mx-3 rounded-m shadow-m my-3">
                            <div class="d-flex px-2 pb-2 pt-2">
                                <div class="align-self-center">
                                    <a href="#"><img
                                            src="{{ $user['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $user['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                            width="40" class="rounded-sm" alt="img"></a>
                                </div>
                                <div class="ps-2 align-self-center">
                                    <h5 class="ps-1 mb-1 pt-1 line-height-xs font-17">{{ auth()->user()->firstname }}
                                    </h5>
                                    <h6 class="ps-1 mb-0 font-400 opacity-40 font-12">{{ auth()->user()->lastname }}
                                    </h6>
                                </div>
                                <div class="ms-auto">
                                    <a href="#" data-bs-toggle="dropdown" class="icon icon-m ps-3"><i
                                            class="fa fa-ellipsis-v font-18 color-theme"></i></a>
                                    <div class="dropdown-menu bg-transparent border-0 mb-n5">
                                        <div class="card card-style rounded-m shadow-xl me-1">
                                            <div class="list-group list-custom-small list-icon-0 px-3 mt-n1">
                                                {{-- <a href="#" class="mb-n2 mt-n1">
                                                    <span>Your Profile</span>
                                                    <i class="fa fa-angle-right"></i>
                                                </a> --}}
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <a href="#"
                                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                                        class="mb-n1">
                                                        <span>Sign Out</span>
                                                        <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-style">
                            <div class="content my-0">
                                <h5 class="font-700 text-uppercase opacity-40 font-12 pt-2 mb-0">Menu</h5>
                                <div class="list-group list-custom-small list-icon-0">
                                    <a href="{{ route('home.view') }}">
                                        <i class="fa font-12 fa-home gradient-green rounded-sm color-white"></i>
                                        <span>Home</span>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    @if (auth()->user()->position_id != 5)
                                        <a href="{{ route('leaderboard.view') }}">
                                            <i class="fa font-12 fa-trophy gradient-yellow rounded-sm color-white"></i>
                                            <span>Who is the boss</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    @endif
                                    @if (auth()->user()->position_id != 5)
                                        <a href="{{ route('roadmap.view') }}">
                                            <i class="fa font-12 fa-map gradient-blue rounded-sm color-white"></i>
                                            <span>Be like a Boss</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('requirement.view') }}">
                                        <i class="fa font-12 fa-list-check gradient-orange rounded-sm color-white"></i>
                                        <span>Act like a Boss</span>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                    @if (auth()->user()->position_id != 5)
                                        <a href="{{ route('incentive.view') }}">
                                            <i class="fa font-12 fa-gift gradient-teal rounded-sm color-white"></i>
                                            <span>Boss or Loss</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    @endif
                                    @if (auth()->user()->position_id != 5)
                                        <a href="{{ route('performance.view') }}">
                                            <i
                                                class="fa font-12 fa-chart-line gradient-red rounded-sm color-white"></i>
                                            <span>You are the Boss</span>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>




                    </div>
                    {{-- <div class="w-100 bottom-0 end-0 pb-1">
                        <div class="card card-style mb-3">
                            <div class="content my-0 py-">
                                <div class="list-group list-custom-small list-icon-0">
                                    <a href="#" data-toggle-theme="" data-trigger-switch="switch-dark2-mode"
                                        class="border-0">
                                        <i class="fa font-12 fa-moon gradient-yellow color-white rounded-sm"></i>
                                        <span>Dark Mode</span>
                                        <div class="custom-control ios-switch">
                                            <input data-toggle-theme="" type="checkbox" class="ios-input"
                                                id="switch-dark2-mode">
                                            <label class="custom-control-label" for="switch-dark2-mode"></label>
                                        </div>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

            </div>

    </div>
    </main>


    </div>




    <!-- User Details Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: linear-gradient(135deg, #fbbf24, #d4af37);">
                    <h5 class="modal-title text-dark" id="profileModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center mt-3">
                    <img id="modalUserPhoto" class="img-fluid rounded-circle mb-3" src="" alt="User Photo"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h4 id="modalUserName" class="mb-2"></h4>
                    <p id="modalUserRank" class="mb-1 text-warning"></p>
                    <p id="modalUserAmount" class="text-success"></p>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript: Attach click event to profile containers in the pyramid overlay -->
    <script>
        document.querySelectorAll('.pyramid-overlay div[data-photo]').forEach(function(elem) {
            elem.addEventListener('click', function() {
                var photo = this.getAttribute('data-photo');
                var name = this.getAttribute('data-name');
                var rank = this.getAttribute('data-rank');
                var amount = this.getAttribute('data-amount');

                document.getElementById('modalUserPhoto').src = photo;
                document.getElementById('modalUserName').textContent = name;
                document.getElementById('modalUserRank').textContent = "Rank: " + rank;
                document.getElementById('modalUserAmount').textContent = "Sales: $" + parseFloat(amount)
                    .toLocaleString();

                var myModal = new bootstrap.Modal(document.getElementById('profileModal'));
                myModal.show();
            });
        });
    </script>


    <!-- Toggle Script -->
    <script>
        // Toggle between "Menu" and "Close" buttons


        function toggleMenu(e) {
            e.preventDefault();
            document.getElementById('togglee-menu').style.display = 'none';
            document.getElementById('closee-menu').style.display = 'inline-block';
            expand();
        }

        function closeMenu(e) {
            e.preventDefault();
            document.getElementById('closee-menu').style.display = 'none';
            document.getElementById('togglee-menu').style.display = 'inline-block';
        }

        function shrink() {
            var footerBar = document.getElementById('footer-bar');
            var footerBarA = document.getElementById('togglee-menu');
            var footerBarB = document.getElementById('closee-menu');

            footerBar.classList.remove('expand');
            footerBar.classList.add('shrink');
            footerBarA.style.width = 'auto';
            footerBarB.style.width = 'auto';
        }

        function expand() {
            console.log("fds");
            var footerBar = document.getElementById('footer-bar');
            var footerBarA = document.getElementById('togglee-menu');
            var footerBarB = document.getElementById('closee-menu');

            footerBar.classList.remove('shrink');
            footerBar.classList.add('expand');
            footerBarA.style.width = '19.5%';
            footerBarB.style.width = '19.5%';

        }



        document.getElementById('togglee-menu').addEventListener('click', toggleMenu);
        document.getElementById('closee-menu').addEventListener('click', closeMenu);
        document.getElementById('closee-menu2').addEventListener('click', closeMenu);
        document.getElementById('closee-menu3').addEventListener('click', closeMenu);

        // Variable to store the scroll timeout
        let scrollTimeout;

        // Add scroll event listener
        window.addEventListener('scroll', function() {
            // Call shrink() immediately on scroll
            shrink();
            document.getElementById('closee-menu').click();

            // Clear any existing timeout
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }

            // Set a new timeout to call expand() after 2 seconds of no scroll
            scrollTimeout = setTimeout(expand, 1500);
        });
    </script>

    <!-- CSS for Shrink and Expand Animation -->
    <style>
        /* Default footer bar styling with transition */
        #footer-bar {
            transition: all 0.3s ease;
            /* Set your default width (for example, 100% minus margins) */
            width: calc(100% - 40px);
        }

        /* Shrink state styles with keyframe animation */
        #footer-bar.shrink {
            left: unset !important;
            /* Use keyframe animation to animate the width change */
            animation: shrinkAnim 0.3s forwards;
        }

        /* Optional: if you want an explicit expand state class, you can add one */
        #footer-bar.expand {
            animation: expandAnim 0.3s forwards;
        }

        /* Hide all links except the toggles when in shrink mode */
        #footer-bar.shrink a:not(#togglee-menu):not(#closee-menu) {
            display: none;
        }

        /* Footer bar scroll container - start from right */
        .footer-bar-scroll {
            direction: rtl;
        }


        /* Keyframes for shrinking animation */
        @keyframes shrinkAnim {
            from {
                width: calc(100% - 40px);
            }

            to {
                width: 70px;
            }
        }

        /* Keyframes for expanding animation */
        @keyframes expandAnim {
            from {
                left: 300px;
                width: 70px;
            }

            to {

                left: 20px;
                width: calc(100% - 40px);
            }
        }
    </style>


    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('UI/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('UI/scripts/custom.js') }}"></script>

</body>

</html>
