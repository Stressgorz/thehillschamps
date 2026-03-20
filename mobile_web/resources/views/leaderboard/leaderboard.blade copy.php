<x-app-layout>
    <title>Leaderboard | TheHillsChamps</title>
    <!-- Header Card -->
    <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}" data-card-height="150"
        style="animation: fadeIn 1.5s ease-in-out;">
        <div class="card-center ms-3">
            <h1 class="color-white mb-0" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Leaderboard</h1>
            <p class="color-white mt-n1 mb-0" style="text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);">Top 30 Performers &amp;
                Achievers</p>
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



    <div class="card card-style mb-3">
        <div class="content m-0 mb-n3">
            <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                <select id="form5" class="border-0">
                    <option value="0" disabled="" selected="">Select Month</option>
                    <option value="3" selected="">March</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                </select>
                <span><i class="fa fa-chevron-down"></i></span>
                <i class="fa fa-check pb-1 disabled valid color-green-dark"></i>
                <i class="fa fa-check pb-1 disabled invalid color-red-dark"></i>
            </div>
        </div>
    </div>

    <div class="main-content leaderboard-page">

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


            <!-- Tabs -->
            {{-- <div class="card card-style mb-3">
                <div class="content leaderboard-tabs">
                    <a href="#" class="color-black leaderboard-tab  my-1 leaderboard-tab-active" data-tab="sales">
                        Sales Performance
                    </a>
                    <a href="#" class="color-black leaderboard-tab  my-1" data-tab="newIB">
                        New IB Acquisition
                    </a>
                    <a href="#" class="color-black leaderboard-tab  my-1" data-tab="newClient">
                        New Client Acquisition
                    </a>
                </div>
            </div> --}}


            <!-- Sales Performance (Default Visible) -->
            <div class="card card-style mb-3" id="tab-sales">
                <div class="content">
                    <h1 class="section-title">Sales Performance</h1>
                    @php
                        $salesPerformance = [
                            // Top 30 entries
                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            ['name' => 'Sarah Johnson', 'role' => 'Director', 'amount' => 185000],
                            ['name' => 'Michael Chen', 'role' => 'Senior', 'amount' => 170000],
                            ['name' => 'Emma Wilson', 'role' => 'IB', 'amount' => 155000],
                            ['name' => 'John Smith', 'role' => 'Marketer', 'amount' => 140000],
                            ['name' => 'Lisa Brown', 'role' => 'Marketer', 'amount' => 125000],

                            // Add 25 more entries here...
                        ];
                    @endphp

                    @foreach ($salesPerformance as $index => $person)
                        @if ($index < 3)
                            <!-- Special design for top 3 -->
                            <div class="top3-item top{{ $index + 1 }}"
                                style="animation-delay: {{ $index * 0.1 }}s;">
                                <div style="position: relative;">
                                    <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile" class="top3-pic">
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
                                    <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile"
                                        class="profile-pic">
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

            {{-- <!-- New IB Acquisition -->
            <div class="card card-style mb-3" id="tab-newIB" style="display: none;">
                <div class="content">
                    <h1 class="section-title">New IB Acquisition</h1>
                    @php
                        $newIB = [
                            // Top 30 entries
                            ['name' => 'Anna Lim', 'role' => 'IB', 'amount' => 90000],
                            ['name' => 'Jason Lee', 'role' => 'Marketer', 'amount' => 75000],
                            // Add 28 more entries here...
                        ];
                    @endphp

                    @if (empty($newIB))
                        <p class="text-center" style="color: #d4af37;">No new IB acquisitions this period</p>
                    @else
                    @foreach ($newIB as $index => $person)
                    @if ($index < 3)
                        <!-- Special design for top 3 -->
                        <div class="top3-item top{{ $index + 1 }}"
                            style="animation-delay: {{ $index * 0.1 }}s;">
                            <div style="position: relative;">
                                <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile" class="top3-pic">
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
                                <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile"
                                    class="profile-pic">
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
                    @endif
                </div>
            </div>

            <!-- New Client Acquisition -->
            <div class="card card-style mb-3" id="tab-newClient" style="display: none;">
                <div class="content">
                    <h1 class="section-title">New Client Acquisition</h1>
                    @php
                        $newClient = [
                            // Top 30 entries
                            ['name' => 'Peter Tan', 'role' => 'Marketer', 'amount' => 50000],
                            ['name' => 'Nina Sanders', 'role' => 'Director', 'amount' => 48000],
                            // Add 28 more entries here...
                        ];
                    @endphp

                    @if (empty($newClient))
                        <p class="text-center" style="color: #d4af37;">No new client acquisitions this period</p>
                    @else
                    @foreach ($newClient as $index => $person)
                    @if ($index < 3)
                        <!-- Special design for top 3 -->
                        <div class="top3-item top{{ $index + 1 }}"
                            style="animation-delay: {{ $index * 0.1 }}s;">
                            <div style="position: relative;">
                                <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile" class="top3-pic">
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
                                <img src="{{ asset('UI/images/pictures/7s.jpg') }}" alt="Profile"
                                    class="profile-pic">
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
                    @endif
                </div>
            </div> --}}
        </div>
        <!-- End of #captureArea -->

        <!-- Save Story Button (outside capture area) -->
        {{-- <button class="btn"
            style="
            background: linear-gradient(135deg, #d4af37, #fbbf24);
            border: none;
            border-radius: 8px;
            width: calc(100% - 2rem);
            margin: 1rem;
            color: #101010;
            font-weight: bold;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        "
            onclick="captureLeaderboard()">
            📸 Save Story
        </button> --}}
    </div>
    <!-- End of Page Content -->

    <!-- html2canvas for Screenshot -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    {{-- <script>
        // Tab Switching Logic (Scoped to leaderboard-page)
        const tabs = document.querySelectorAll('.leaderboard-tab');
        const sections = {
            sales: document.getElementById('tab-sales'),
            newIB: document.getElementById('tab-newIB'),
            newClient: document.getElementById('tab-newClient'),
        };

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                // Remove active state from all tabs
                tabs.forEach(t => t.classList.remove('leaderboard-tab-active'));
                // Hide all sections
                Object.values(sections).forEach(sec => sec.style.display = 'none');
                // Show selected section
                this.classList.add('leaderboard-tab-active');
                sections[this.dataset.tab].style.display = 'block';
            });
        });

        // Screenshot Capture: Only capture #captureArea content
        function captureLeaderboard() {
            html2canvas(document.querySelector('#captureArea')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'leaderboard-story.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        }
    </script> --}}
</x-app-layout>
