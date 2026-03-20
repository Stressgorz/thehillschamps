<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Login | TheHillsChamps</title>
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

    <div id="page">

        <div class="page-content pb-0">

            <div data-card-height="cover" class="card">
                <div class="card-center bg-theme rounded-m mx-3">
                    <div class="p-4">
                        <h1 class="text-center font-800 font-40 mb-1">Sign In</h1>
                        <p class="color-highlight text-center font-12">Let's get you logged in</p>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <!-- Session 2 Status -->

                        <form method="POST" id="formLogin" action="{{ route('login') }}">
                            @csrf

                            <div class="input-style no-borders has-icon validate-field">
                                <i class="fa fa-user"></i>
                                <input type="email" name="email" class="form-control validate-email"
                                    id="email" placeholder="Email" required autofocus autocomplete="email">
                                <label for="email" class="color-blue-dark font-10 mt-1">Email</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />

                            <div class="input-style no-borders has-icon validate-field mt-4">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control validate-password"
                                    id="password" placeholder="Password" required autocomplete="current-password">
                                <label for="password" class="color-blue-dark font-10 mt-1">Password</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />


                            <!-- Remember Me -->
                            <div class="form-check form-check-lg d-flex align-items-end mb-4" style="display:none!important">
                                <input id="remember_me" type="checkbox" class="form-check-input me-2"
                                    name="remember" checked>
                                <label for="remember_me" class="form-check-label text-gray-600">
                                    Remember me
                                </label>
                            </div>

                            <!-- A tag as submit button -->
                            <a href="#" onclick="document.getElementById('loginButton').click();"
                                class="btn btn-full btn-m shadow-large rounded-sm text-uppercase font-900 bg-highlight">
                                LOGIN
                            </a>
                            <!-- Login Button -->
                            <x-primary-button id="loginButton" style="display: none;"
                                class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                                Log in
                            </x-primary-button>
                        </form>


                    </div>
                </div>
                <div class="card-overlay-infinite preload-img"
                    data-src="{{ asset(path: 'UI/images/pictures/_bg-infinite.jpg') }}"></div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('UI/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('UI/scripts/custom.js') }}"></script>

</body>

</html>
