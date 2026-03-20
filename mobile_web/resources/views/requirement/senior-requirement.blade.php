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


        @if (Auth::user()->position_id == 4)
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
            <!-- NEW CARD FOR SENIOR RANK REQUIREMENTS -->
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

                <!-- Quarter Status -->
                <div class="mb-4 text-center">
                    <h4>Quarter Status</h4>
                    <p>
                        Status: <strong id="quarterStatus"
                            class="{{ $quarterStatus == 'Pass'
                                ? 'text-success'
                                : ($quarterStatus == 'In Progress'
                                    ? 'text-warning'
                                    : 'text-danger') }}">
                            {{ $quarterStatus }}
                        </strong>
                    </p>
                </div>

                <!-- 4 Requirement Cards Row -->
                <div class="row">

                    <!-- Requirement 1: Monthly Sales (Bar Chart) -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">Monthly Sales</h6>
                            <!-- Bar chart canvas for Monthly Sales -->
                            <canvas id="req1BarChart" style="width:200px; height:150px; margin:0 auto;"></canvas>
                            <p class="mt-2 mb-0 req-info" id="req1Info">
                                M1: ${{ number_format($m1Sales) }}
                                @if ($m1Status == 'Pass')
                                    <i class="fa fa-check text-success"></i>
                                @elseif($m1Status == 'Fail')
                                    <i class="fa fa-times text-danger"></i>
                                @else
                                    <i class="fa fa-spinner fa-spin text-warning"></i>
                                @endif
                                <br>
                                M2: ${{ number_format($m2Sales) }}
                                @if ($m2Status == 'Pass')
                                    <i class="fa fa-check text-success"></i>
                                @elseif($m2Status == 'Fail')
                                    <i class="fa fa-times text-danger"></i>
                                @else
                                    <i class="fa fa-spinner fa-spin text-warning"></i>
                                @endif
                                <br>
                                M3: ${{ number_format($m3Sales) }}
                                @if ($m3Status == 'Pass')
                                    <i class="fa fa-check text-success"></i>
                                @elseif($m3Status == 'Fail')
                                    <i class="fa fa-times text-danger"></i>
                                @else
                                    <i class="fa fa-spinner fa-spin text-warning"></i>
                                @endif
                            </p>

                            <span class="req-info d-inline">
                                Status: <span
                                    class="{{ $monthlySalesStatus == 'Pass' ? 'text-success' : ($monthlySalesStatus == 'Fail' ? 'text-danger' : 'text-warning') }}">
                                    {{ $monthlySalesStatus }}
                                </span>
                            </span>


                        </div>
                    </div>

                    <!-- Requirement 2: Group Sales (Circle Chart) -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">Group Sales (Quarter)</h6>
                            <div id="req2Chart" class="mx-auto" style="width:120px; height:120px;"></div>
                            <p class="mt-2 mb-0 req-info" id="req2Info">
                                Current: ${{ number_format($groupSales) }} / Target:
                                ${{ number_format($quarterGroupSalesTarget) }}
                            </p>
                            <span class="req-info d-inline">
                                Status: <span
                                    class="{{ $groupSalesStatus == 'Pass' ? 'text-success' : ($groupSalesStatus == 'Fail' ? 'text-danger' : 'text-warning') }}">
                                    {{ $groupSalesStatus }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Requirement 3: New IB (Battery Bar) -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">New IB</h6>
                            <!-- Bootstrap Progress Bar as battery indicator -->
                            <div id="req3Battery" class="progress" style="height: 30px; width:120px; margin:0 auto;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mt-2 mb-0 req-info" id="req3Info">
                                Current: {{ $newIBs }} / Target: {{ $newIbTarget }}
                            </p>
                            <span class="req-info d-inline">
                                Status: <span
                                    class="{{ $newIbStatus == 'Pass' ? 'text-success' : ($newIbStatus == 'Fail' ? 'text-danger' : 'text-warning') }}">
                                    {{ $newIbStatus }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Requirement 4: New Marketer (Pie Chart) -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">New Marketer</h6>
                            <canvas id="req4PieChart"
                                style="max-width:120px; max-height:120px; margin:0 auto;"></canvas>
                            <p class="mt-2 mb-0 req-info" id="req4Info">
                                Current: {{ $newMarketers }} / Target: {{ $newMarketerTarget }}
                            </p>
                            <span class="req-info d-inline">
                                Status: <span
                                    class="{{ $newMarketerStatus == 'Pass' ? 'text-success' : ($newMarketerStatus == 'Fail' ? 'text-danger' : 'text-warning') }}">
                                    {{ $newMarketerStatus }}
                                </span>
                            </span>
                        </div>
                    </div>

                </div><!-- /row -->
            </div><!-- /card -->
        </div>
    </div>
    <!-- End of Page Content-->

    <!-- Custom CSS for Current/Target Info -->
    <style>
        .req-info {
            font-size: 0.9rem;
        }

        body.theme-dark .card-inside {
            box-shadow: 0 4px 24px 0 rgb(96 89 89 / 11%);
        }
    </style>

    <!-- Scripts -->
    <!-- Include ProgressBar.js and Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Use the numeric data passed from the controller.
        var m1Current = {{ $m1Sales }};
        var m2Current = {{ $m2Sales }};
        var m3Current = {{ $m3Sales }};
        var m1Target = 10000; // as defined in controller
        var m2Target = 10000;
        var m3Target = 10000;

        // Group Sales
        var req2Current = {{ $groupSales }};
        var req2Target = {{ $quarterGroupSalesTarget }};

        // New IB
        var req3Current = {{ $newIBs }};
        var req3Target = {{ $newIbTarget }};

        // New Marketer
        var req4Current = {{ $newMarketers }};
        var req4Target = {{ $newMarketerTarget }};

        //-----------------------
        // 1) Monthly Sales Bar Chart using Chart.js
        //-----------------------
        var req1Ctx = document.getElementById('req1BarChart').getContext('2d');
        var req1Data = {
            labels: ['M1', 'M2', 'M3'],
            datasets: [{
                label: 'Sales ($)',
                data: [m1Current, m2Current, m3Current],
                backgroundColor: ['#3498db', '#3498db', '#3498db']
            }]
        };
        new Chart(req1Ctx, {
            type: 'bar',
            data: req1Data,
            options: {
                responsive: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }]
                }
            }
        });

        //-----------------------
        // 2) Group Sales: Displayed via ProgressBar.js Circle
        //-----------------------
        function createCircleChart(containerId, current, target, useRed) {
            var progressValue = current / target;
            if (progressValue > 1) progressValue = 1; // clamp at 100%
            var fromColor = useRed ? '#c0392b' : '#8e44ad';
            var toColor = useRed ? '#e74c3c' : '#2980b9';
            var bar = new ProgressBar.Circle(containerId, {
                strokeWidth: 12,
                trailWidth: 12,
                duration: 1400,
                easing: 'easeInOut',
                from: {
                    color: fromColor,
                    width: 12
                },
                to: {
                    color: toColor,
                    width: 12
                },
                trailColor: '#444',
                text: {
                    value: '0%',
                    style: {
                        color: '#f0f0f0',
                        position: 'absolute',
                        left: '50%',
                        top: '50%',
                        transform: 'translate(-50%, -50%)',
                        fontSize: '1.8rem',
                        fontWeight: 'bold'
                    }
                },
                step: function(state, circle) {
                    circle.path.setAttribute('stroke', state.color);
                    circle.path.setAttribute('stroke-width', state.width);
                    var percentage = Math.round(circle.value() * 100);
                    circle.setText('<span style="color:' + state.color + ';">' + percentage + '%</span>');
                }
            });
            bar.animate(progressValue);
            return Math.round(progressValue * 100);
        }
        createCircleChart('#req2Chart', req2Current, req2Target, true);

        //-----------------------
        // 3) New IB: Battery Bar
        //-----------------------
        var req3Percent = Math.round((req3Current / req3Target) * 100);
        if (req3Percent > 100) req3Percent = 100;
        var progressBar3 = document.querySelector('#req3Battery .progress-bar');
        progressBar3.style.width = req3Percent + '%';
        progressBar3.setAttribute('aria-valuenow', req3Percent);
        //-----------------------
        // 4) New Marketer: Pie Chart using Chart.js
        //-----------------------
        var req4Ctx = document.getElementById('req4PieChart').getContext('2d');
        var remainder = (req4Current >= req4Target) ? 0 : (req4Target - req4Current);
        var req4Data = {
            labels: ['Achieved', 'Remaining'],
            datasets: [{
                data: [req4Current, remainder],
                backgroundColor: [(req4Current >= req4Target) ? '#9b59b6' : 'orange', '#444'],
                borderWidth: 0
            }]
        };
        new Chart(req4Ctx, {
            type: 'pie',
            data: req4Data,
            options: {
                responsive: false,
                legend: {
                    display: false
                }
            }
        });

        // Since overall quarter status is computed in PHP, we set it directly.
        document.getElementById('quarterStatus').innerText = "{{ $quarterStatus }}";
    </script>

</x-app-layout>
