@extends('layout.master')
@section('head')
    <link href="assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        .weather-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 50px;
        }
        .weather-item {
            display: flex;
            justify-content: space-between;
        }
        .weather-item span {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-pink">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-eye-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Devices</h6>
                    <h2 class="my-2">{{ $devices->count() }}</h2>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-purple">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-wallet-2-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Users</h6>
                    <h2 class="my-2">{{ \App\Models\User::all()->count() }}</h2>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-info">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-shopping-basket-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Organizations</h6>
                    <h2 class="my-2">{{ \App\Models\Organization::all()->count() }}</h2>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-xxl-3 col-sm-6">
            <div class="card widget-flat text-bg-primary">
                <div class="card-body">
                    <div class="float-end">
                        <i class="ri-group-2-line widget-icon"></i>
                    </div>
                    <h6 class="text-uppercase mt-0" title="Customers">Notifications</h6>
                    <h2 class="my-2">{{ \App\Models\Notifications::all()->count() }}</h2>
                </div>
            </div>
        </div> <!-- end col-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets" style="display: flex; align-items: center;">
                        <select id="device" class="form-control select2" data-toggle="select2" name="device" onchange="device(this)" style="margin-right: 40px;">
                            <option>Select Device</option>
                            @foreach($devices as $device)
                                <option value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <a href="javascript:" onclick="device(deviceId)" data-bs-toggle="reload" style="margin-right: 10px;"><i class="ri-refresh-line"></i></a>
                        <a data-bs-toggle="collapse" href="#weeklysales-collapse" role="button" aria-expanded="false" aria-controls="weeklysales-collapse" style="margin-right: 10px;"><i class="ri-subtract-line"></i></a>
                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                    </div>

                    <h5 class="header-title mb-0">Device Graphic</h5>

                    <div id="weeklysales-collapse" class="collapse pt-3 show">
                        <div dir="ltr">
                            <div id="line-chart" class="apex-charts" data-colors="#edc755"></div>
                            <div class="row text-center">
                                <div class="col">
                                    <p class="text-muted mt-3">Device Name</p>
                                    <h3 class=" mb-0">
                                        <span id="device-name">Name</span>
                                    </h3>
                                </div>
                            </div>
                        </div>


                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->


    </div>

    <div class="row">

        <div class="col-xl-12">
            <!-- Todo-->
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="card-widgets">
                            <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                            <a data-bs-toggle="collapse" href="#devices" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">Devices</h5>
                    </div>

                    <div id="devices" class="collapse show">

                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Device Name</th>
                                    <th>UUID</th>
                                    <th>Parameters</th>
                                    <th>Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($devices->take(5) as $device)
                                    <tr>
                                    <td></td>
                                    <td>{{ $device->name }}</td>
                                    <td>{{ $device->uuid }}</td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="getDevice({{$device->id}})"data-bs-toggle="modal" data-bs-target="#device-modal">See Device</button>
                                    </td>
                                    <td>{{ $device->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <div class="modal fade" id="device-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-full-width modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="device-modal-name"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                    data-bs-target="#live-data" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true" href="#aboutme">Live Data</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" onclick="device(this)" data-bs-toggle="tab"
                                                    data-bs-target="#history" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#history">History</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                    data-bs-target="#weather" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#weather">Weather</a></li>
                            <li class="nav-item"><a class="nav-link" onclick="initMap()" data-bs-toggle="tab"
                                                    data-bs-target="#map" type="button" role="tab"
                                                    aria-controls="home" aria-selected="true"
                                                    href="#map">Map</a></li>
                        </ul>

                        <div class="tab-content m-0 p-4">
                            <div class="tab-pane active" id="live-data" role="tabpanel"
                                 aria-labelledby="home-tab" tabindex="0">
                                <div class="row" id="property-area"></div>
                            </div> <!-- about-me -->

                            <!-- History -->
                            <div id="history" class="tab-pane">
                                <h5 class="header-title mb-0">Device Graphic</h5>

                                <div id="weeklysales-collapse" class="collapse pt-3 show">
                                    <div dir="ltr">
                                        <div id="device-line-chart"  class="apex-charts h-auto" data-colors="#edc755"></div>
                                        <div class="row text-center">
                                            <div class="col">
                                                <p class="text-muted mt-3">Device Name</p>
                                                <h3 class=" mb-0">
                                                    <span id="device-name">Name</span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- weather -->
                            <div id="weather" class="tab-pane">
                                <div class="card">
                                    <div class="card-body weather-card">
                                        <div class="weather-item">
                                            <span>Time Stamp:</span>
                                            <span id="timestamp">July 14th 2024, 3 AM</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Air Temperature:</span>
                                            <span id="temp">22.40 Degree Celsius</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Air Humidity:</span>
                                            <span id="humidity">83.70 %</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Air Pressure:</span>
                                            <span id="pressure">911.82 hPa</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Baro Pressure:</span>
                                            <span id="baro-pressure">1006.20 hPa</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Wind Speed:</span>
                                            <span id="wind-speed">23.15 km/hr</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Wind Direction:</span>
                                            <span id="wind-dir">W</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Rain Fall:</span>
                                            <span id="rain-fall">6.36 mm</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Day Length:</span>
                                            <span id="day-length">46140.00 seconds</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Sunshine Hours:</span>
                                            <span id="sunshine-hours">0.80</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Rain Probability:</span>
                                            <span id="rain-prob">70.00 %</span>
                                        </div>
                                        <div class="weather-item">
                                            <span>Cloud Cover:</span>
                                            <span id="cloud-cover">100.00 %</span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- map -->
                            <div id="map" class="tab-pane col-lg-12">
                                <div class=" align-items-center">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1511.5059724325558!2d30.33290805062371!3d40.73976268359937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDDCsDQ0JzIzLjEiTiAzMMKwMjAnMDIuMyJF!5e0!3m2!1str!2str!4v1720960470974!5m2!1str!2str" class="col-lg-12"  height="450"  style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC41c2x2t6QEezb_1Lpn2ltFt5KQ_srm3I"></script>
    <script>
        function initMap() {
            var location = { lat: 40.712776, lng: -74.005974 };
            var map = new google.maps.Map($('#map'), {
                zoom: 12,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>

        function device(deviceId) {
            $.ajax({
                type: 'GET',
                url: '/devices/chart/' + deviceId.value,
                success: function(data) {
                    $('#device-name').text(data.name);
                    var seriesData = [];
                    var categories = [];

                    data.values.forEach(function(value) {
                        var property = value.property.name;
                        var timestamp = new Date(value.created_at).toLocaleString();
                        var existingSeries = seriesData.find(series => series.name === property);

                        if (!existingSeries) {
                            existingSeries = { name: property, data: [] };
                            seriesData.push(existingSeries);
                        }

                        existingSeries.data.push(value.value);
                        if (!categories.includes(timestamp)) {
                            categories.push(timestamp);
                        }
                    });

                    if (window.chart) {
                        window.chart.destroy();
                    }


                    var options = {
                        chart: {
                            height: '200%' ,
                            type: 'line'
                        },
                        series: seriesData,
                        xaxis: {
                            categories: categories
                        }
                    };

                    // Create and render the new chart
                    window.chart = new ApexCharts(document.querySelector("#line-chart"), options);
                    window.chart.render();
                }
            });
        }



        $(document).ready(function() {

            $.ajax({
                type: 'GET',
                url: 'http://api.weatherapi.com/v1/current.json?key=b30aadf79b404ea694d114929241407&q=istanbul&aqi=no',
                headers: {
                    'Authorization': 'Bearer b30aadf79b404ea694d114929241407' // API key
                },
                success: function(response) {
                    const weatherData = response.current;
                    const locationData = response.location;

                    // Example values as per your request
                    $('#timestamp').text('July 14th 2024, 3 AM');
                    $('#temp').text('22.40 Degree Celsius');
                    $('#humidity').text('83.70 %');
                    $('#pressure').text('911.82 hPa');
                    $('#baro-pressure').text('1006.20 hPa');
                    $('#wind-speed').text('23.15 km/hr');
                    $('#wind-dir').text('W');
                    $('#rain-fall').text('6.36 mm');
                    $('#day-length').text('46140.00 seconds');
                    $('#sunshine-hours').text('0.80');
                    $('#rain-prob').text('70.00 %');
                    $('#cloud-cover').text('100.00 %');

                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error: ' + error);
                }
            });
        });
    </script>
    <script>
        function getDevice(deviceId)
        {

            $('#property-area').empty();

            $.ajax({
               type: 'GET',
               url: '/devices/item/' +  deviceId,
                success: function ( data ){
                    $('#device-modal-name').text(data.name);
                    data.values.forEach(function ( value ){
                        let propertyData = `

                                <div class="col-lg-3">
                                    <div class="card card-body border-primary border align-items-center">
                                        <h4 class="card-title ">${value.property.name}:</h4>
                                        <p class="card-text">${value.value}
                                            </p>
                                    </div>
                                </div>

                    `;
                        $('#property-area').append(propertyData);


                    });
                }
            });

            $.ajax({
                type: 'GET',
                url: '/devices/chart/' + deviceId,
                success: function ( data ){

                    $('#device-name').text(data.name);
                    var seriesData = [];
                    var categories = [];

                    data.values.forEach(function(value) {
                        var property = value.property.name;
                        var timestamp = new Date(value.created_at).toLocaleString();
                        var existingSeries = seriesData.find(series => series.name === property);

                        if (!existingSeries) {
                            existingSeries = { name: property, data: [] };
                            seriesData.push(existingSeries);
                        }

                        existingSeries.data.push(value.value);
                        if (!categories.includes(timestamp)) {
                            categories.push(timestamp);
                        }
                    });

                    if (window.chart) {
                        window.chart.destroy();
                    }

                    var options = {
                        chart: {
                            height: '200%' ,
                            type: 'line'
                        },
                        series: seriesData,
                        xaxis: {
                            categories: categories
                        }
                    };

                    // Create and render the new chart
                    window.chart = new ApexCharts(document.querySelector("#device-line-chart"), options);
                    window.chart.render();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }
    </script>
    <script src="assets/vendor/select2/js/select2.min.js"></script>

@endsection
