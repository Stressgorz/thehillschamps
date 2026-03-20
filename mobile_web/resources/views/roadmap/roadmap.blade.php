<x-app-layout>
    <title>Be like a Boss | TheHillsChamps</title>
    <!-- Header Card -->
    <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}" data-card-height="150"
        style="animation: fadeIn 1.5s ease-in-out;">
        <div class="card-center ms-3">
            <h1 class="color-white mb-0" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Be like a Boss</h1>
        </div>
        <div class="card-overlay bg-black opacity-80"></div>
    </div>




    @if (Auth::user()->position_id == 4)
        @php
            // Define rank labels according to position_id.
            $rankLabels = [
                4 => 'Director',
                2 => 'Senior',
                1 => 'IB',
                3 => 'Leader',
                5 => 'Marketer',
            ];
            // Force the selected rank to always be IB (position_id 1).
            $selectedRank = $position_id;
        @endphp

        <!-- Rank Selector for Directors -->
        <div class="card card-style mb-3">
            <div class="content m-0 mb-n3">
                <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                    <select id="ibSelector" class="border-0" onchange="updateAllFilters();">
                        <option value="" disabled>Select Rank</option>
                        @foreach ($rankLabels as $positionId => $label)
                            <option value="{{ $positionId }}" {{ $selectedRank == $positionId ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                </div>
            </div>
        </div>
    @endif






    <div class="main-content leaderboard-page">
        <!-- Year Selector -->
        <div class="card card-style mb-3">
            <div class="content m-0 mb-n3">
                <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                    <select id="yearSelect" class="border-0" onchange="updateAllFilters();">
                        <option value="" disabled>Select Year</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                </div>
            </div>
        </div>

        <!-- Month Selector -->
        <div class="card card-style mb-3">
            <div class="content m-0 mb-n3">
                <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                    <select id="monthSelect" class="border-0" onchange="updateAllFilters();">
                        <option value="" disabled>Select Month</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                </div>
            </div>
        </div>

        <!-- Amount Card -->
        <div class="card card-style border-0">
            <div class="card-body py-5 px-4 text-center">
                <h1 class="display-2 fw-bold text-nowrap mb-2">{{ $amount }}</h1>
                <p class="h5 text-secondary mb-0">USD</p>
            </div>
        </div>

        <script>
            console.log({{ $selectedYear }});
        </script>
    </div>


    <script>
        function updateAllFilters() {
            // Get the IB value (if available).
            var ibElem = document.getElementById('ibSelector');
            var ib = ibElem ? ibElem.value : '';

            // Get the selected year.
            var yearElem = document.getElementById('yearSelect');
            var selectedYear = yearElem ? yearElem.value : '';

            // Get the selected month.
            var monthElem = document.getElementById('monthSelect');
            var selectedMonth = monthElem ? monthElem.value : '';

            // Build the URL with all parameters.
            var url = "{{ route('roadmap.view') }}";
            var params = [];

            if (ib) {
                params.push("ib=" + encodeURIComponent(ib));
            }
            if (selectedYear) {
                params.push("year=" + encodeURIComponent(selectedYear));
            }
            if (selectedMonth) {
                params.push("month=" + encodeURIComponent(selectedMonth));
            }
            if (params.length > 0) {
                url += "?" + params.join("&");
            }
            window.location.href = url;
        }
    </script>
</x-app-layout>
