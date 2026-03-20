<x-app-layout>
    <title>Boss or Loss | TheHillsChamps</title>

    <!-- ─── Page Content ─────────────────────────────────────────────────────── -->
    <div class="main-content">
        <!-- Header Card -->
        <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/dubai_card.jpg') }}"
             data-card-height="150">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">Boss or Loss</h1>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>

        <div class="content mt-0">
            <!-- Photo -->
            <img src="{{ asset('UI/images/pictures/dubai_poster.png') }}" alt="Dubai Trip" class="rounded img-fluid">

            <!-- Progress Card -->
            <div class="card card-style mx-0 mb-3 p-3 mt-3">
                <div class="row mb-2">
                    <!-- WTT Progress Bar -->
                    <div class="col-12 col-md-6 mt-2 mb-3 text-center">
                        <h5 class="mb-3">WTT Entries</h5>

                        <div class="progress wtt-wrapper mx-auto">
                            <div id="wttBar" class="progress-bar bg-success" role="progressbar"
                                 style="width:0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- Tick labels -->
                        <span class="tick tick-25">25&nbsp;WTT</span>
                        <span class="tick tick-50">50&nbsp;WTT</span>
                        <span class="tick tick-100">100&nbsp;WTT</span>

                        <!-- Current value -->
                        <p class="wtt-current mt-3 mb-0" id="wttInfo"></p>
                    </div>

                    <!-- Lots Ring -->
                    <div class="col-12 col-md-6 mb-1 text-center">
                        <h5 class="mb-4">Lots Volume</h5>

                        <div class="ring-box position-relative mx-auto">
                            <div id="lotsRing" class="w-100 h-100"></div>
                            <span class="ring-marker marker-top">1000&nbsp;Lots</span>
                            <span class="ring-marker marker-bottom">500&nbsp;Lots</span>
                        </div>

                        <p class="lots-current mt-4 mb-0" id="lotsInfo"></p>
                    </div>
                </div>

                <h5 class="mb-0 text-success" id="qualifyText" style="text-align:center;"></h5>
            </div>

            
        </div>
    </div>
    <!-- ──────────────────────────────────────────────────────────────────────── -->

    <!-- ProgressBar.js -->
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>

    <script>
        console.log({{$currentLots}});

        /* Replace with Blade variables later */
        const currentWTT  = {{$currentWTT}};  // e.g. 
        const currentLots = {{$currentLots}};   // e.g. 

        /* WTT bar */
        const wttPercent = Math.min(currentWTT, 100);
        wttBar.style.width  = wttPercent + '%';
        document.getElementById('wttInfo').textContent = 'Current : ' + currentWTT + ' WTT';

        /* Lots ring */
        const lotsRing = new ProgressBar.Circle('#lotsRing', {
            strokeWidth:12, trailWidth:12, trailColor:'#444', duration:1400,
            from:{color:'#f39c12'}, to:{color:'#27ae60'},
            text:{ value:'0%', style:{
                color:'#000', position:'absolute', left:'50%', top:'50%',
                transform:'translate(-50%,-50%)', fontSize:'1.3rem', fontWeight:'bold'
            }},
            step:(state,circle)=>{ circle.path.setAttribute('stroke',state.color);
                                   circle.setText(Math.round(circle.value()*100)+'%'); }
        });
        lotsRing.animate(Math.min(currentLots/1000,1));
        document.getElementById('lotsInfo').textContent = 'Current : ' + currentLots + ' Lots';

        /* Qualification */
        let message = '<span class="text-danger">Keep going, you haven’t qualified yet.</span>';

        if (currentWTT >= 100) {
            // 🥇 Option 1 – WTT only
            message = `Congratulations!!!<br><p class="text">You have achieved<br>(${currentWTT} WTT Entries)</p>`;
        } else if (currentWTT >= 50 && currentLots >= 500) {
            // 🥈 Option 2
            message = `Congratulations!!!<br><p>You have achieved<br>(${currentWTT} WTT Entries + ${currentLots} Lots)</p>`;
        } else if (currentWTT >= 25 && currentLots >= 1000) {
            // 🥉 Option 3
            message = `Congratulations!!!<br><p>You have achieved<br>(${currentWTT} WTT Entries + ${currentLots} Lots)</p>`;
        }

        /* show it */
        document.getElementById('qualifyText').innerHTML = message;
        document.getElementById('qualifyCard').classList.remove('d-none');
    </script>

    <!-- Custom CSS -->
    <style>
        body.theme-dark .card-style { box-shadow:0 4px 24px 0 rgb(96 89 89 / 11%); }

        .progress.wtt-wrapper { height:32px; width:80%; position:relative; background:#3a3a3a; }
        .tick { position:absolute; top:-20px; font-size:.75rem; color:#fff; text-shadow:0 0 3px #000; font-weight:600; transform:translateX(-50%); }
        .tick-25{left:25%} .tick-50{left:50%} .tick-100{left:100%}

        .ring-box{width:150px;height:150px}
        .ring-marker{position:absolute;color:#616161;font-size:.7rem;font-weight:600;transform:translateX(-50%)}
        .marker-top{left:50%;top:-24px} .marker-bottom{left:50%;bottom:-24px}

        .wtt-current, .lots-current{font-size:.9rem}
        canvas { width:100%!important;height:auto!important; }
    </style>
</x-app-layout>
