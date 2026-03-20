<x-app-layout>
    <!-- Include ApexCharts from a CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



    <title>Senior Requirements | TheHillsChamps</title>

    <!-- Add required libraries -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <div class="main-content">
        <!-- Header Card -->
        <div class="card card-style preload-img" data-src="{{ asset('UI/images/pictures/18w.jpg') }}"
            data-card-height="150">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">Requirement</h1>
                <p class="color-white mt-n1 mb-0">Track Your Requirement</p>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
        </div>

        <div class="content mt-0">

            <!-- Stylish Card Container -->
            <div class="card card-style mx-0 mb-3 p-3 text-center">
                <!-- Title -->
                <h3 class="fw-bold mb-1">Monthly Sales</h3>
                <!-- Description -->
                <p class="text-muted mb-0">Achieve a set amount of sales per month to qualify.</p>

                <!-- Chart Container -->
                <div id="circularChart"></div>

                <!-- Target Info -->
                <p class=" mb-0">
                    Target: <strong>$10,000 in sales</strong>
                </p>
            </div>

            <script>
                // ApexCharts configuration for a circular progress
                var options = {
                    series: [70], // current percentage (0-100)
                    chart: {
                        type: 'radialBar',
                        height: 250,
                        // sparkline: { enabled: true } // Uncomment if you want no axes/labels
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: 0,
                            endAngle: 360,
                            hollow: {
                                size: '55%', // donut thickness
                            },
                            track: {
                                background: '#eee',
                                strokeWidth: '100%'
                            },
                            dataLabels: {
                                name: {
                                    show: false
                                },
                                value: {
                                    show: true,
                                    fontSize: '2rem',
                                    fontWeight: 700,
                                    offsetY: 8,
                                    formatter: function(val) {
                                        return val + '%';
                                    }
                                }
                            }
                        }
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            gradientToColors: ['#48C6EF'], // End color
                            inverseColors: true,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 100]
                        },
                        colors: ['#6F86D6'] // Start color
                    },
                    stroke: {
                        lineCap: 'round'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#circularChart"), options);
                chart.render();
            </script>

        </div>

    </div>



</x-app-layout>
