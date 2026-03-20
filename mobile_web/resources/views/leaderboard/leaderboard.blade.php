<x-app-layout>
    <title>Who is the Boss? | TheHillsChamps</title>
    <!-- Header Card -->
    <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}" data-card-height="150"
        style="animation: fadeIn 1.5s ease-in-out;">
        <div class="card-center ms-3">
            <h1 class="color-white mb-0" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Who is the Boss?</h1>
        </div>
        <div class="card-overlay bg-black opacity-80"></div>
        <!-- Firework Container -->
        <div class="firework-container">
            <div class="firework"></div>
            <div class="firework"></div>
            <div class="firework"></div>
        </div>
        <!-- Floating Sparkles -->
        <div class="floating-sparkles">
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
        </div>
    </div>



    <!-- Month Selector -->
    <div class="card card-style mb-3">
        <div class="content m-0 mb-n3">
            <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                <select id="form5" class="border-0"
                    onchange="location = '{{ route('leaderboard.view') }}?month=' + this.value;">
                    <option value="" disabled>Select Month</option>
                    <option value="01" {{ $selectedMonth == '01' ? 'selected' : '' }}>January</option>
                    <option value="02" {{ $selectedMonth == '02' ? 'selected' : '' }}>February</option>
                    <option value="03" {{ $selectedMonth == '03' ? 'selected' : '' }}>March</option>
                    <option value="04" {{ $selectedMonth == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ $selectedMonth == '05' ? 'selected' : '' }}>May</option>
                    <option value="06" {{ $selectedMonth == '06' ? 'selected' : '' }}>June</option>
                    <option value="07" {{ $selectedMonth == '07' ? 'selected' : '' }}>July</option>
                    <option value="08" {{ $selectedMonth == '08' ? 'selected' : '' }}>August</option>
                    <option value="09" {{ $selectedMonth == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ $selectedMonth == '10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ $selectedMonth == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ $selectedMonth == '12' ? 'selected' : '' }}>December</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check pb-1 disabled valid color-green-dark"></i>
                <i class="fa fa-check pb-1 disabled invalid color-red-dark"></i>
            </div>
        </div>
    </div>

    <div class="main-content leaderboard-page">
        <!-- Hill Image Container with Background & Pyramid Overlay -->
        <div class="card card-style border-0 mb-3"
            style="background: url('{{ asset('UI/images/leaderboardLogo.png') }}') no-repeat center center; 
                  background-size: contain; 
                  position: relative; 
                  height: 30vh;
                  background-color: white;">
            <!-- Pyramid Overlay positioned at top: 22% of container height -->
            <div class="pyramid-overlay" style="position: absolute; top: 22%; left: 0; width: 100%;">
                @php
                    // Split the top 30 users into four rows:
                    // Row 1: first 3 users (largest avatars)
                    // Row 2: next 6 users (medium avatars)
                    // Row 3: next 9 users (small avatars)
                    // Row 4: next 12 users (extra-small avatars)
                    $row1 = array_slice($salesPerformance, 0, 3);
                    $row2 = array_slice($salesPerformance, 3, 6);
                    $row3 = array_slice($salesPerformance, 9, 9);
                    $row4 = array_slice($salesPerformance, 18, 12);
                @endphp

                {{-- Row 1: Large avatars (9vw diameter) with Rank 1 centered --}}
                @php
                    // Reorder so that rank 1 appears in the center:
                    $userLeft = $row1[1]; // originally rank 2
                    $userCenter = $row1[0]; // originally rank 1 (best performer)
                    $userRight = $row1[2]; // originally rank 3
                @endphp
                <div class="pyramid-row" style="display: flex; justify-content: center; margin-bottom: 1.5vh;">
                    {{-- Left: Rank 2 --}}
                    <div style="position: relative; display: inline-block; margin: 0 1vw;"
                        data-photo="{{ $userLeft['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userLeft['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                        data-name="{{ $userLeft['name'] }}" data-rank="2" data-amount="{{ $userLeft['amount'] }}">
                        <img src="{{ $userLeft['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userLeft['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            alt="{{ $userLeft['name'] }}"
                            style="width: 9vw; height: 9vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171;">
                    </div>
                    {{-- Center: Rank 1 (best performer) --}}
                    <div style="position: relative; display: inline-block; margin: 0 1vw;"
                        data-photo="{{ $userCenter['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userCenter['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                        data-name="{{ $userCenter['name'] }}" data-rank="1"
                        data-amount="{{ $userCenter['amount'] }}">
                        <img src="{{ $userCenter['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userCenter['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            alt="{{ $userCenter['name'] }}"
                            style="width: 9vw; height: 9vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171; ">
                    </div>
                    {{-- Right: Rank 3 --}}
                    <div style="position: relative; display: inline-block; margin: 0 1vw;"
                        data-photo="{{ $userRight['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userRight['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                        data-name="{{ $userRight['name'] }}" data-rank="3" data-amount="{{ $userRight['amount'] }}">
                        <img src="{{ $userRight['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $userRight['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            alt="{{ $userRight['name'] }}"
                            style="width: 9vw; height: 9vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171;">
                    </div>
                </div>

                {{-- Row 2: Medium avatars (7vw diameter) --}}
                <div class="pyramid-row" style="display: flex; justify-content: center; margin-bottom: 1.5vh;">
                    @foreach ($row2 as $index => $u)
                        @php $rank = count($row1) + $index + 1; @endphp
                        <div style="position: relative; display: inline-block; margin: 0 1vw;"
                            data-photo="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            data-name="{{ $u['name'] }}" data-rank="{{ $rank }}"
                            data-amount="{{ $u['amount'] }}">
                            <img src="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                alt="{{ $u['name'] }}"
                                style="width: 7vw; height: 7vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171;">
                        </div>
                    @endforeach
                </div>

                {{-- Row 3: Small avatars (6vw diameter) --}}
                <div class="pyramid-row" style="display: flex; justify-content: center; margin-bottom: 1.5vh;">
                    @foreach ($row3 as $index => $u)
                        @php $rank = count($row1) + count($row2) + $index + 1; @endphp
                        <div style="position: relative; display: inline-block; margin: 0 1vw;"
                            data-photo="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            data-name="{{ $u['name'] }}" data-rank="{{ $rank }}"
                            data-amount="{{ $u['amount'] }}">
                            <img src="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                alt="{{ $u['name'] }}"
                                style="width: 6vw; height: 6vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171;">
                        </div>
                    @endforeach
                </div>

                {{-- Row 4: Extra-small avatars (5vw diameter) --}}
                <div class="pyramid-row" style="display: flex; justify-content: center;">
                    @foreach ($row4 as $index => $u)
                        @php $rank = count($row1) + count($row2) + count($row3) + $index + 1; @endphp
                        <div style="position: relative; display: inline-block; margin: 0 1vw;"
                            data-photo="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                            data-name="{{ $u['name'] }}" data-rank="{{ $rank }}"
                            data-amount="{{ $u['amount'] }}">
                            <img src="{{ $u['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $u['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                alt="{{ $u['name'] }}"
                                style="width: 5vw; height: 5vw; border-radius: 50%; object-fit: cover; display: block;border: 2px solid #b0a171;">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
















        <!-- This container is the only part that gets captured in the screenshot -->
        <div id="captureArea">
            <!-- Scoped Leaderboard Styles -->
            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                    }

                    to {
                        opacity: 1;
                    }
                }

                @keyframes slideIn {
                    from {
                        transform: translateY(20px);
                        opacity: 0;
                    }

                    to {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }

                @keyframes firework {
                    0% {
                        transform: scale(0);
                        opacity: 1;
                    }

                    100% {
                        transform: scale(1);
                        opacity: 0;
                    }
                }

                @keyframes float {

                    0%,
                    100% {
                        transform: translateY(0);
                    }

                    50% {
                        transform: translateY(-10px);
                    }
                }

                @keyframes sparkleMove {
                    0% {
                        transform: translateY(0) translateX(0);
                        opacity: 0;
                    }

                    50% {
                        opacity: 1;
                    }

                    100% {
                        transform: translateY(-100vh) translateX(100vw);
                        opacity: 0;
                    }
                }

                .bg-gradient-dark {
                    background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.4));
                }

                .leaderboard-page .card-style {
                    /* background: #0f1117 !important; */
                    /* Dark card */
                    border: none;
                    border-radius: 12px;
                    overflow: hidden;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }



                /* Firework Container */
                .firework-container {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                }

                .firework {
                    position: absolute;
                    width: 10px;
                    height: 10px;
                    background: rgba(212, 175, 55, 0.8);
                    border-radius: 50%;
                    animation: firework 1.5s ease-out infinite;
                }

                .firework:nth-child(1) {
                    top: 20%;
                    left: 10%;
                    animation-delay: 0s;
                }

                .firework:nth-child(2) {
                    top: 50%;
                    left: 30%;
                    animation-delay: 0.5s;
                }

                .firework:nth-child(3) {
                    top: 70%;
                    left: 80%;
                    animation-delay: 1s;
                }

                /* Floating Sparkles */
                .floating-sparkles {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    overflow: hidden;
                }

                .sparkle {
                    position: absolute;
                    width: 5px;
                    height: 5px;
                    background: rgba(255, 255, 255, 0.8);
                    border-radius: 50%;
                    animation: sparkleMove 10s linear infinite;
                }

                .sparkle:nth-child(1) {
                    top: 10%;
                    left: 20%;
                    animation-delay: 0s;
                }

                .sparkle:nth-child(2) {
                    top: 40%;
                    left: 60%;
                    animation-delay: 2s;
                }

                .sparkle:nth-child(3) {
                    top: 80%;
                    left: 90%;
                    animation-delay: 4s;
                }

                /* Category Tabs Container */
                .leaderboard-page .leaderboard-tabs {
                    display: flex;
                    justify-content: space-around;
                    border-radius: 12px;
                    margin: 0 1rem;
                    padding: 0.3rem;
                }

                /* Each Tab */
                .leaderboard-page .leaderboard-tab {
                    flex: 1;
                    text-align: center;
                    font-weight: 500;
                    padding: 0.75rem;
                    margin: 0 0.25rem;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    text-decoration: none;
                    /* background: #2a2a2a; */
                    line-height: 15px;
                }



                /* Active Tab */
                .leaderboard-page .leaderboard-tab-active {
                    background: linear-gradient(135deg, #d4af37, #fbbf24);
                    color: #101010 !important;
                    font-weight: 600;
                    box-shadow: 0 2px 6px rgba(212, 175, 55, 0.8);
                }

                .leaderboard-page .section-title {
                    text-align: center;
                    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
                }

                .leaderboard-page .leaderboard-item {
                    background-color: #f8f9fb;
                    border-radius: 12px;
                    /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); */
                    padding: 1rem;
                    margin-bottom: 0.75rem;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    animation: slideIn 0.5s ease-out;
                    animation-fill-mode: backwards;
                }

                /* Dark theme override */
                .theme-dark .leaderboard-page .leaderboard-item {
                    background-color: #1e20244d;
                    /* Dark theme background */
                }

                /* .leaderboard-page .leaderboard-item:hover {
                    transform: scale(1.02);
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                } */

                /* Standard profile picture styling for non-top3 */
                .leaderboard-page .profile-pic {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-right: 1rem;
                    border: 2px solid #d4af37;
                }

                /* Ranking number styling */
                .leaderboard-page .rank-number {
                    font-size: 1em;
                    color: #d4af37 !important;
                    font-weight: bold;
                    margin-right: 0.5rem;
                }

                .leaderboard-page .participant-info h5 {
                    margin: 0;
                }

                .leaderboard-page .participant-info p {
                    color: #ccc;
                    margin: 0;
                    font-size: 0.8rem;
                }

                .leaderboard-page .amount-info h5 {
                    color: #d4af37;
                    margin: 0;
                }

                /* Top3 special design */
                .leaderboard-page .top3-item {
                    background: linear-gradient(135deg, #d4af37, #fbbf24);
                    /* default gold gradient */
                    border-radius: 12px;
                    padding: 1rem;
                    margin-bottom: 0.75rem;
                    display: flex;
                    align-items: center;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    animation: slideIn 0.5s ease-out;
                    animation-fill-mode: backwards;
                }

                /* .leaderboard-page .top3-item:hover {
                    transform: scale(1.02);
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.8);
                } */

                /* Adjust gradient per position */
                .leaderboard-page .top1 {
                    background: linear-gradient(135deg, #d4af37, #fbbf24);
                }

                .leaderboard-page .top2 {
                    background: linear-gradient(135deg, #bfc1c2, #d1d3d4);
                    margin-right: 0.2rem;
                    margin-left: 0.2rem;
                }

                .leaderboard-page .top3 {
                    background: linear-gradient(135deg, #c38c5a, #d2a67a);
                    margin-right: 0.3rem;
                    margin-left: 0.3rem;
                }

                .leaderboard-page .top3-pic {
                    width: 70px;
                    height: 70px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-right: 1rem;
                    position: relative;
                    border: 3px solid #fff;
                }

                .leaderboard-page .top3-info h5 {
                    color: #101010;
                    margin: 0;
                    font-weight: bold;
                }

                .leaderboard-page .top3-info p {
                    color: #101010;
                    margin: 0;
                    font-size: 0.8rem;
                }

                .leaderboard-page .top3-amount {
                    color: #101010;
                    font-weight: bold;
                    font-size: 1rem !important;
                }

                /* Ranking Badge */
                .ranking-badge {
                    position: absolute;
                    top: -9px;
                    right: 10px;
                    background: #d4af37;
                    color: #101010;
                    font-weight: bold;
                    font-size: 0.7em;
                    width: 20px;
                    height: 20px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 1px solid #fff;
                }

                /* Bigger Font for Top 1 */
                .top1-name {
                    font-size: 1.5em;
                    /* Adjust as needed */
                    font-weight: bold;
                }

                /* Top 3 Profile Picture */
                .top3-pic {
                    width: 80px;
                    /* Larger for top 3 */
                    height: 80px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin-right: 1rem;
                    border: 3px solid #fff;
                }

                /* Top 3 Item Styling */
                .top3-item {
                    background: linear-gradient(135deg, #d4af37, #fbbf24);
                    border-radius: 12px;
                    padding: 1rem;
                    margin-bottom: 0.75rem;
                    display: flex;
                    align-items: center;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    animation: slideIn 0.5s ease-out;
                    animation-fill-mode: backwards;
                }

                /* .top3-item:hover {
                    transform: scale(1.02);
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.8);
                } */
            </style>




            <!-- Sales Performance (Dynamic Data) -->
            <div class="card card-style mb-3" id="tab-sales">
                <div class="content">
                    <h1 class="section-title">Sales Performance</h1>
                    @foreach ($salesPerformance as $index => $person)
                        @if ($index < 3)
                            <!-- Special design for top 3 -->
                            <div class="top3-item top{{ $index + 1 }}"
                                style="animation-delay: {{ $index * 0.1 }}s;">
                                <div style="position: relative;">
                                    <img src="{{ $person['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $person['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                        alt="Profile" class="top3-pic">
                                    <!-- Ranking Badge -->
                                    <div class="ranking-badge">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                                <div class="top3-info">
                                    <h5 class="{{ $index === 0 ? 'top1-name' : '' }}">{{ $person['name'] }}</h5>
                                    <p>{{ $person['role'] }}</p>
                                    <p class="top3-amount">${{ number_format($person['amount']) }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Standard design for others -->
                            <div class="leaderboard-item" style="animation-delay: {{ $index * 0.1 }}s;">
                                <div class="d-flex align-items-center">
                                    <span class="rank-number"
                                        style="color: #d4af37 !important;">#{{ $index + 1 }}</span>
                                    <img src="{{ $person['photo'] ? 'https://thehillschamps.com/storage/Profile_Pic/' . $person['photo'] : 'https://thehillschamps.com/storage/avatar/avatar.png' }}"
                                        alt="Profile" class="profile-pic">
                                    <div class="participant-info">
                                        <h5>{{ $person['name'] }}</h5>
                                        <p>{{ $person['role'] }}</p>
                                    </div>
                                </div>
                                <div class="amount-info text-end">
                                    <h5>${{ number_format($person['amount']) }}</h5>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End of #captureArea -->


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</x-app-layout>
