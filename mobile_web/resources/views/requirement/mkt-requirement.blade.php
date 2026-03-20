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

        <div class="content mt-0">
            <!-- NEW CARD FOR MARKETER REQUIREMENTS -->
            <div class="card card-style mx-0 mb-3 p-3">
                <!-- Marketer to IB Status -->
                <div class="mb-4 text-center">
                    <h4>Marketer to IB Status</h4>
                    <p>Status: <strong id="marketerStatus" class="text-success">In Progress</strong></p>
                </div>

                <!-- Requirements Row -->
                <div class="row">
                    <!-- Requirement 1: Personal Sales (Circle Chart) -->
                    <div class="col-md-6 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">Personal Sales</h6>
                            <div id="salesChart" class="mx-auto" style="width:120px; height:120px;"></div>
                            <p class="mt-2 mb-0 req-info" id="salesInfo"></p>
                            <p class="mb-0 req-info" id="salesStatus"></p>
                        </div>
                    </div>
                    <!-- Requirement 2: New Clients (Bar Chart) -->
                    <div class="col-md-6 mb-3">
                        <div class="card card-style p-2 text-center card-inside">
                            <h6 class="mb-2">New Clients</h6>
                            <canvas id="clientsChart" style="width:200px; height:150px; margin:0 auto;"></canvas>
                            <p class="mt-2 mb-0 req-info" id="clientsInfo"></p>
                            <p class="mb-0 req-info" id="clientsStatus"></p>
                        </div>
                    </div>
                    <!-- Display congratulatory message if both statuses are passed -->
                    @if ($personalSalesStatus == 'Pass' && $newClientsStatus == 'Pass')
                        <p class="text-center text-success">
                            <strong >
                                Congratulations! 
                            </strong>
                            </br>You passed the MARKETER TEST,</br> please inform your Introducer.
                        </p>
                    @endif
                </div>
            </div>
            <!-- End of New Card -->
        </div>
    </div>
    <!-- End of Page Content-->

    <!-- Custom CSS -->
    <style>
        .req-info {
            font-size: 0.9rem;
        }

        body.theme-dark .card-inside {
            box-shadow: 0 4px 24px 0 rgb(96 89 89 / 11%);
        }
    </style>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log("{{ $startDate }}");
        console.log("{{ $endDate }}");
        // Dummy data
        var salesCurrent = {{ $personalSales }},
            salesTarget = 3000;
        var clientsCurrent = {{ $newClients }},
            clientsTarget = 3;

        // Status Logic: No "Fail" for Marketer, only "In Progress" or "Passed"
        function getStatus(current, target) {
            return current >= target ? {
                status: "Passed",
                color: "green"
            } : {
                status: "In Progress",
                color: "orange"
            };
        }

        // 1. Personal Sales (Circle Progress)
        function createCircleChart(containerId, current, target) {
            var progressValue = current / target;
            var bar = new ProgressBar.Circle(containerId, {
                strokeWidth: 12,
                trailWidth: 12,
                duration: 1400,
                easing: 'easeInOut',
                from: {
                    color: '#f39c12',
                    width: 12
                },
                to: {
                    color: '#27ae60',
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
                    circle.setText('<span style="color:' + state.color + ';">' + Math.round(circle.value() *
                        100) + '%</span>');
                }
            });
            bar.animate(progressValue);
        }
        createCircleChart("#salesChart", salesCurrent, salesTarget);
        var salesStatusObj = getStatus(salesCurrent, salesTarget);
        document.getElementById("salesInfo").innerHTML = 'Current: $' + salesCurrent.toLocaleString() + ' / Target: $' +
            salesTarget.toLocaleString();
        document.getElementById("salesStatus").innerHTML = '<strong style="color:' + salesStatusObj.color + '">Status: ' +
            salesStatusObj.status + '</strong>';

        // 2. New Clients (Bar Chart)
        var clientsCtx = document.getElementById("clientsChart").getContext("2d");
        var clientsData = {
            labels: ["New Clients"],
            datasets: [{
                label: "Clients",
                data: [clientsCurrent],
                backgroundColor: ["#f39c12"]
            }]
        };
        var clientsChart = new Chart(clientsCtx, {
            type: "bar",
            data: clientsData,
            options: {
                responsive: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: clientsTarget,
                            stepSize: 1
                        }
                    }]
                }
            }
        });

        var clientsStatusObj = getStatus(clientsCurrent, clientsTarget);
        document.getElementById("clientsInfo").innerHTML = 'Current: ' + clientsCurrent + ' / Target: ' + clientsTarget;
        document.getElementById("clientsStatus").innerHTML = '<strong style="color:' + clientsStatusObj.color +
            '">Status: ' + clientsStatusObj.status + '</strong>';

        // 3. Overall Status
        document.getElementById("marketerStatus").innerText = (salesStatusObj.status === "Passed" && clientsStatusObj
            .status === "Passed") ? "Passed" : "In Progress";
    </script>
</x-app-layout>
