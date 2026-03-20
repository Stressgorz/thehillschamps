<x-app-layout>
    <title>Act like a Boss | TheHillsChamps</title>

    <!-- Start of Page Content-->
    <div class="main-content">
        <!-- Header Card -->
        <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}"
            data-card-height="150">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">Act like a Boss</h1>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>

        @if (Auth::user()->position_id === 4)
            @php
                // Define rank labels according to position_id
                $rankLabels = [
                    4 => 'Director',
                    2 => 'Senior',
                    1 => 'IB',
                    3 => 'Leader',
                    5 => 'Marketer',
                ];
                // Group the active users collection by position_id
                $groupedUsers = $activeUsers->groupBy('position_id');
            @endphp

            <!-- IB Selector with Grouping -->
            <div class="card card-style mb-3">
                <div class="content m-0 mb-n3">
                    <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                        <select id="ibSelector" class="border-0" onchange="updateAllFilters();">
                            <option value="" disabled>Select IB</option>
                            @foreach ($rankLabels as $positionId => $label)
                                @if ($groupedUsers->has($positionId))
                                    <optgroup label="{{ $label }}">
                                        @foreach ($groupedUsers[$positionId] as $activeUser)
                                            <option value="{{ $activeUser->id }}"
                                                {{ (request('ib') ? request('ib') == $activeUser->id : Auth::user()->id == $activeUser->id) ? 'selected' : '' }}>
                                                {{ $activeUser->firstname }} {{ $activeUser->lastname }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            @endforeach
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
        @endif

        <div class="content mt-0">
            <!-- Filter for Quarter Selection -->
            <div class="card card-style mx-0 mb-3 p-3">
                <!-- Year Selector -->
                <div class="card card-style mb-3">
                    <div class="content m-0 mb-n3">
                        <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                            <select id="formYear" class="border-0" onchange="updateAllFilters();">
                                <option value="" disabled>Select Year</option>
                                @for ($year = 2025; $year <= \Carbon\Carbon::now()->year; $year++)
                                    <option value="{{ $year }}"
                                        @if ($selectedYear == $year) selected @endif>{{ $year }}</option>
                                @endfor
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <i class="fa fa-check pb-1 disabled valid color-green-dark"></i>
                            <i class="fa fa-check pb-1 disabled invalid color-red-dark"></i>
                        </div>
                    </div>
                </div>

                <!-- Quarter Selector -->
                <div class="card card-style mb-3">
                    <div class="content m-0 mb-n3">
                        <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                            @php
                                $currentYear = \Carbon\Carbon::now()->year;
                                $currentQuarter = \Carbon\Carbon::now()->quarter;
                            @endphp
                            <select id="formQuarter" class="border-0" onchange="updateAllFilters();">
                                <option value="" disabled>Select Quarter</option>
                                @if ($selectedYear < $currentYear)
                                    <!-- For past years, show all 4 quarters -->
                                    <option value="1" @if ($selectedQuarter == 1) selected @endif>Q1</option>
                                    <option value="2" @if ($selectedQuarter == 2) selected @endif>Q2</option>
                                    <option value="3" @if ($selectedQuarter == 3) selected @endif>Q3</option>
                                    <option value="4" @if ($selectedQuarter == 4) selected @endif>Q4</option>
                                @else
                                    <!-- For the current year, show quarters up to the current quarter -->
                                    @for ($q = 1; $q <= $currentQuarter; $q++)
                                        <option value="{{ $q }}"
                                            @if ($selectedQuarter == $q) selected @endif>Q{{ $q }}
                                        </option>
                                    @endfor
                                @endif
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <i class="fa fa-check pb-1 disabled valid color-green-dark"></i>
                            <i class="fa fa-check pb-1 disabled invalid color-red-dark"></i>
                        </div>
                    </div>
                </div>

                <script>
                    function updateAllFilters() {
                        // Get the IB value from the IB selector, if present.
                        var ibElem = document.getElementById('ibSelector');
                        var ib = ibElem ? ibElem.value : '';

                        // Get the selected year and quarter.
                        var yearElem = document.getElementById('formYear');
                        var quarterElem = document.getElementById('formQuarter');
                        var selectedYear = yearElem ? yearElem.value : '';
                        var selectedQuarter = quarterElem ? quarterElem.value : '';

                        // Build the URL with all parameters.
                        var url = "{{ route('requirement.view') }}";
                        var params = [];

                        if (ib) {
                            params.push("ib=" + encodeURIComponent(ib));
                        }
                        if (selectedYear) {
                            params.push("selectedYear=" + encodeURIComponent(selectedYear));
                        }
                        if (selectedQuarter) {
                            params.push("selectedQuarter=" + encodeURIComponent(selectedQuarter));
                        }
                        if (params.length > 0) {
                            url += "?" + params.join("&");
                        }
                        window.location.href = url;
                    }
                </script>

                <!-- Volume (Lots) Performance -->
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h4 class="mb-5">Volume (Lots)</h4>

                            <div style="position: relative; width: 180px; height: 180px; margin: auto;">
                                <div id="volumeChart" style="width: 180px; height: 180px;"></div>
                                <div id="label50"
                                    style="position: absolute; left: 50%; top: -10%; transform: translate(-50%, -50%); font-size: 12px; color: #27ae60; width:100%;font-weight:bold;">
                                    Best Performance</div>
                                <div id="label100"
                                    style="position: absolute; left: 50%; top: 110%; transform: translate(-50%, -50%); font-size: 12px; color: #f39c12; width:100%;font-weight:bold;">
                                    Moderate</div>
                            </div>
                            <p class="mt-5 mb-0" id="volumeInfo"></p>
                            <p class="mt-1" id="volumeLabel"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Content-->

    <!-- Custom CSS -->
    <style>
        body.theme-dark .card-style {
            box-shadow: 0 4px 24px 0 rgb(96 89 89 / 11%);
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
    <script>
        function updateChart() {
            var volume = {{ $totalLots }};
            var progressValue = volume / 500;

            // Performance Label
            var label = "Low";
            var color = "orange";
            if (progressValue >= 1) {
                label = "Best Performance";
                color = "green";
            } else if (progressValue >= 0.5) {
                label = "Moderate";
                color = "#f39c12";
            }

            document.getElementById("volumeInfo").innerHTML = `Current: ${volume} Lots / Target: 500 Lots`;
            document.getElementById("volumeLabel").innerHTML = `<strong style="color:${color};">${label}</strong>`;


            // Update Circle Progress Bar
            volumeChart.animate(progressValue);
        }

        // Create Circle Progress Chart
        var volumeChart = new ProgressBar.Circle("#volumeChart", {
            strokeWidth: 12,
            trailWidth: 12,
            duration: 1400,
            easing: "easeInOut",
            from: {
                color: "#f39c12",
                width: 12
            },
            to: {
                color: "#27ae60",
                width: 12
            },
            trailColor: "#444",
            text: {
                value: "0%",
                style: {
                    color: "#f0f0f0",
                    position: "absolute",
                    left: "50%",
                    top: "50%",
                    transform: "translate(-50%, -50%)",
                    fontSize: "1.8rem",
                    fontWeight: "bold"
                }
            },
            step: function(state, circle) {
                circle.path.setAttribute("stroke", state.color);
                circle.setText('<span style="color:' + state.color + ';">' + Math.round(circle.value() * 100) +
                    '%</span>');
            }
        });

        // Initial Chart Load
        updateChart();
    </script>
</x-app-layout>
