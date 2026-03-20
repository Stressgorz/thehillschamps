<x-app-layout>
    <title>You are the Boss | TheHillsChamps</title>

    <!-- Start of Page Content-->
    <div class="main-content">

        <!-- Header Image Card -->
        <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}"
            data-card-height="150">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">You are the Boss</h1>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>

        @if (Auth::user()->position_id == 2 || Auth::user()->position_id == 4))
            <!-- IB Selector -->
            <div class="card card-style mb-3">
                <div class="content m-0 mb-n3">
                    <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                        <select id="ibSelector" class="border-0" onchange="updatePerformance();">
                            <option value="" disabled>Select IB</option>
                            @foreach ($activeUsers as $activeUser)
                                <option value="{{ $activeUser->id }}"
                                    {{ (request('ib') ? request('ib') == $activeUser->id : Auth::user()->id == $activeUser->id) ? 'selected' : '' }}>
                                    {{ $activeUser->firstname }} {{ $activeUser->lastname }}
                                </option>
                            @endforeach
                        </select>
                        <span><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
        @endif



        <!-- Year Selector -->
        <div class="card card-style mb-3">
            <div class="content m-0 mb-n3">
                <div class="input-style input-style-always-active has-borders no-icon mb-n3">
                    <select id="yearSelect" class="border-0" onchange="updatePerformance();">
                        <option value="" disabled>Select Year</option>
                        @foreach ($years as $y)
                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                    <span><i class="fa fa-chevron-down"></i></span>
                </div>
            </div>
        </div>

        <script>
            function updatePerformance() {
                // Get the IB value if selector exists (for director)
                var ibElem = document.getElementById('ibSelector');
                var ib = ibElem ? ibElem.value : '';

                // Get the year value
                var year = document.getElementById('yearSelect').value;

                // Build the destination URL with both query parameters
                var url = "{{ route('performance.view') }}";
                var params = [];

                if (ib) {
                    params.push("ib=" + encodeURIComponent(ib));
                }
                if (year) {
                    params.push("year=" + encodeURIComponent(year));
                }
                if (params.length > 0) {
                    url += '?' + params.join('&');
                }

                // Redirect to the constructed URL
                window.location = url;
            }
        </script>


        <!-- Performance Data Display -->
        @foreach ($performanceData as $m => $data)
            <div class="content mt-0">
                <div class="card card-style mx-0 mb-3 p-3">
                    <!-- Month Record -->
                    <div class="month-record">
                        <h1 class="mb-3">{{ $data['month_name'] }} {{ $year }}</h1>
                        <div class="row mb-2">
                            <div class="col text-start">
                                <h5 class="d-block font-13 pt-1">Personal Sales</h5>
                                <h2 class="mb-n1 font-18 color-blue-dark">{{ $data['personal_sales'] }}</h2>
                                <p class="font-12 opacity-50">
                                    @if (isset($data['percentage_change']['personal_sales']))
                                        @if (floatval($data['percentage_change']['personal_sales']) < 0)
                                            - {{ ltrim($data['percentage_change']['personal_sales'], '-') }}
                                        @else
                                            + {{ $data['percentage_change']['personal_sales'] }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                            @if ($user->position_id == 2)
                                <div class="col text-start">
                                    <h5 class="d-block font-13 pt-1">Team Sales</h5>
                                    <h2 class="mb-n1 font-18 color-green-dark">{{ $data['team_sales'] ?? '$0.00' }}
                                    </h2>
                                    <p class="font-12 opacity-50">
                                        @if (isset($data['percentage_change']['team_sales']))
                                            @if (floatval($data['percentage_change']['team_sales']) < 0)
                                                - {{ ltrim($data['percentage_change']['team_sales'], '-') }}
                                            @else
                                                + {{ $data['percentage_change']['team_sales'] }}
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            @endif
                            <div class="col text-start">
                                <h5 class="d-block font-13 pt-1">New Clients</h5>
                                <h2 class="mb-n1 font-18 color-red-dark">{{ $data['new_clients'] }}</h2>
                                <p class="font-12 opacity-50">
                                    @if (isset($data['percentage_change']['new_clients']))
                                        @if (floatval($data['percentage_change']['new_clients']) < 0)
                                            - {{ ltrim($data['percentage_change']['new_clients'], '-') }}
                                        @else
                                            + {{ $data['percentage_change']['new_clients'] }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                            
                            @if ($user->position_id == 1)
                            <div class="col text-start">
                            <h5 class="font-12 pt-1">Projected Comms</h5>
                                <h2 class="mb-n1 font-18 color-red-dark">
                                    ${{ number_format($data['projected_comm'], 2) }} </h2>
                                <!-- Optionally, add percentage change here if computed -->
                                {{-- <p class="font-12 opacity-50">30% of P.Sales</p> --}}
                            </div>
                            @endif
                            
                        </div>
                    </div>
                    <hr>
                    <!-- Additional Data (computed values) -->
                    <div class="month-record">
                        <div class="row">
                            
                            
                            <div class="col text-start">
                                <h5 class="d-block font-13 pt-1">Self Lots</h5>
                                <h2 class="mb-n1 font-18 color-teal-dark">{{ number_format($data['volume_selfs'], 2) }}
                                    Lot</h2>
                                <!-- Optionally, add percentage change here if computed -->
                                <p class="font-12 opacity-50">
                                    @if (isset($data['percentage_change']['volume_selfs']))
                                        @if (floatval($data['percentage_change']['volume_selfs']) < 0)
                                            - {{ ltrim($data['percentage_change']['volume_selfs'], '-') }}
                                        @else
                                            + {{ $data['percentage_change']['volume_selfs'] }}
                                        @endif
                                    @endif
                                </p>

                            </div>
                            <div class="col text-start">
                                <h5 class="d-block font-13 pt-1">Direct Lots</h5>
                                <h2 class="mb-n1 font-18 color-teal-dark">{{ number_format($data['volume_lots'], 2) }}
                                    Lot</h2>
                                <!-- Optionally, add percentage change here if computed -->
                                <p class="font-12 opacity-50">
                                    @if (isset($data['percentage_change']['volume_lots']))
                                        @if (floatval($data['percentage_change']['volume_lots']) < 0)
                                            - {{ ltrim($data['percentage_change']['volume_lots'], '-') }}
                                        @else
                                            + {{ $data['percentage_change']['volume_lots'] }}
                                        @endif
                                    @endif
                                </p>
                                  

                            </div>
                            <div class="col text-start">
                                <h5 class="d-block font-13 pt-1">Group Lots</h5>
                                <h2 class="mb-n1 font-18 color-teal-dark">{{ number_format($data['volume_groups'], 2) }}
                                    Lot</h2>
                                <!-- Optionally, add percentage change here if computed -->
                                <p class="font-12 opacity-50">
                                    @if (isset($data['percentage_change']['volume_groups']))
                                        @if (floatval($data['percentage_change']['volume_groups']) < 0)
                                            - {{ ltrim($data['percentage_change']['volume_groups'], '-') }}
                                        @else
                                            + {{ $data['percentage_change']['volume_groups'] }}
                                        @endif
                                    @endif
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <!-- End of Page Content-->
</x-app-layout>
