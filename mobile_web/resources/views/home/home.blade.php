<x-app-layout>
    <title>Home | TheHillsChamps</title>




    <!-- Start of Page Content-->
    <div class="main-content">



        <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/6w.jpg') }}"
            data-card-height="150">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">Home</h1>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>

        <div class="card rounded-m shadow-l mx-3">
            <div class="card-bottom text-center mb-0">
                <h1 class="color-white font-700 mb-n1">The Hills International</h1>
                <p class="color-white opacity-80 mb-4"></p>
            </div>
            <div class="card-overlay bg-gradient rounded-m"></div>
            <img class=" rounded-m img-fluid" src="{{ asset('UI/images/pictures/team2.jpg')}}">
        </div>

        {{-- <div class="card card-style" style=" overflow: hidden;">
            <img src="" alt="Full Image"
                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 15px;">
        </div> --}}
        

        @if (auth()->user()->position_id != 5)
        <a href="{{ route('leaderboard.view') }}">
            <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/15w.jpg') }}" data-card-height="150">
                <div class="card-center ms-3">
                    <h1 class="color-white mb-0">Who is the Boss</h1>
                </div>
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </a>
        @endif
        
        @if (auth()->user()->position_id != 5)
        <a href="{{ route('roadmap.view') }}">
            <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/11w.jpg') }}" data-card-height="150">
                <div class="card-center ms-3">
                    <h1 class="color-white mb-0">Be like a Boss</h1>
                </div>
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </a>
        @endif
        
        <a href="{{ route('requirement.view') }}">
            <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/12w.jpg') }}" data-card-height="150">
                <div class="card-center ms-3">
                    <h1 class="color-white mb-0">Act like a Boss</h1>
                </div>
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </a>
        
        @if (auth()->user()->position_id != 5)
        <a href="{{ route('incentive.view') }}">
            <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/14w.jpg') }}" data-card-height="150">
                <div class="card-center ms-3">
                    <h1 class="color-white mb-0">Boss or Loss</h1>
                </div>
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </a>
        @endif
        @if (auth()->user()->position_id != 5)
        <a href="{{ route('performance.view') }}">
            <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}" data-card-height="150">
                <div class="card-center ms-3">
                    <h1 class="color-white mb-0">You are the Boss</h1>
                </div>
                <div class="card-overlay bg-black opacity-50"></div>
            </div>
        </a>
        @endif
        



    </div>






    <!-- End of Page Content-->



</x-app-layout>
