@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('home.Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('devices.Devices') }}</li>
@endsection
@section('title', 'devices')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Select2 css -->
    <link href="{{ asset('assets/vendor/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>

    <style>
        .select2-container--open {
            z-index: 9999999 !important;
        }

    </style>
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
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="header-title">{{ __('devices.Devices') }}</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">{{ __('devices.Add Device') }}
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="margin-right: 10px;">
                            <label for="limit" class="form-label">{{ __('pagination.Per Page') }}</label>
                            <select id="limit" name="limit" onchange="getData()" class="form-control">
                                <option value="10" selected>10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div style="margin-left: auto;">
                            <input type="search" id="search" onchange="getData()" class="form-control form-control-sm" placeholder="Search">
                        </div>
                    </div>

                    <div id="devices-table">
                        @include('devices.data', ['devices' => $devices])
                    </div>
                </div>
                <!-- end table-responsive-->
            </div> <!-- end card body-->

        </div> <!-- end card -->
    </div><!-- end col-->

    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">{{ __('devices.Add Device') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('modals.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <form id="addDeviceForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('devices.Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="uuid" class="form-label">UUID</label>
                            <input type=number class="form-control" id="uuid"
                                   name="uuid" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('devices.Select Type') }}</label>
                            <select id="type" name="type" class="form-control">
                                <option value="">{{ __('devices.Select Type') }}</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="organization" class="form-label">{{ __('devices.Organization') }}</label>
                            <select id="organization" name="organization" class="form-control">
                                <option value="NULL">{{ __('devices.Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('modals.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('modals.Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="edit-device-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-device-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-device-modalLabel">{{ __('devices.Edit device') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('modals.Close') }}"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-device-form" method="POST">
                        <input type="hidden" id="edit-device-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">{{ __('devices.Name') }}</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-uuid" class="form-label">UUID</label>
                            <input type=number class="form-control" id="edit-uuid"
                                   name="edit-uuid" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-type" class="form-label">{{ __('devices.Select Type') }}</label>
                            <select id="edit-type" name="type" class="form-control">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-organization" class="form-label">{{ __('devices.Organization') }}</label>
                            <select id="edit-organization" name="edit-organization" class="form-control">
                                <option value="NULL">{{ __('devices.Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback" id="organization"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('modals.Close') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('modals.Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

   @include('modals.success')

    @include('modals.error')

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
                                                aria-controls="home" aria-selected="true" href="#live-data">{{ __('devices.Live Data') }}</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#history" type="button" role="tab"
                                                aria-controls="home" aria-selected="true"
                                                href="#history">{{ __('devices.History') }}</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#weather" type="button" role="tab"
                                                aria-controls="home" aria-selected="true"
                                                href="#weather">{{ __('devices.Weather') }}</a></li>
                        <li class="nav-item"><a class="nav-link" onclick="initMap()" data-bs-toggle="tab"
                                                data-bs-target="#map" type="button" role="tab"
                                                aria-controls="home" aria-selected="true"
                                                href="#map">{{ __('devices.Map') }}</a></li>
                    </ul>

                    <div class="tab-content m-0 p-4">
                        <div class="tab-pane active" id="live-data" role="tabpanel"
                             aria-labelledby="home-tab" tabindex="0">
                            <div class="row" id="property-area"></div>
                        </div> <!-- about-me -->

                        <!-- History -->
                        <div id="history" class="tab-pane">
                            <h5 class="header-title mb-0">{{ __('devices.Device Graphic') }}</h5>

                            <div id="weeklysales-collapse" class="collapse pt-3 show">
                                <div dir="ltr">
                                    <div id="device-line-chart"  class="apex-charts h-auto"></div>
                                    <div class="row text-center">
                                        <div class="col">
                                            <p class="text-muted mt-3"></p>
                                            <h3 class=" mb-0">
                                                <span id="device-name">{{ __('devices.Name') }}</span>
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
                                        <span>{{ __('devices.Time Stamp') }}:</span>
                                        <span id="timestamp">July 14th 2024, 3 AM</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Air Temperature') }}:</span>
                                        <span id="temp">22.40 Degree Celsius</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Air Humidity') }}:</span>
                                        <span id="humidity">83.70 %</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Air Pressure') }}:</span>
                                        <span id="pressure">911.82 hPa</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Baro Pressure') }}:</span>
                                        <span id="baro-pressure">1006.20 hPa</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Wind Speed') }}:</span>
                                        <span id="wind-speed">23.15 km/hr</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Wind Direction') }}:</span>
                                        <span id="wind-dir">W</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Rain Fall') }}:</span>
                                        <span id="rain-fall">6.36 mm</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Day Length') }}:</span>
                                        <span id="day-length">46140.00 seconds</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Sunshine Hours') }}:</span>
                                        <span id="sunshine-hours">0.80</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Rain Probability') }}:</span>
                                        <span id="rain-prob">70.00 %</span>
                                    </div>
                                    <div class="weather-item">
                                        <span>{{ __('devices.Cloud Cover') }}:</span>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        function getData(offset = 1) {
            let search = $ ( '#search' ).val ();
            let limit = $ ( '#limit' ).val () ?? 10;
            $.ajax ( {
                type: 'GET',
                url: '/devices/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#devices-table' ).html ( data );
                },
            } );
        }

        function setUser(deviceId) {
            $.ajax({
                type: 'GET',
                url: '/devices/edit/' + deviceId,
                success: function(data) {

                    $('#edit-device-form').attr('action', '/devices/update/' + deviceId);
                    $('#edit-device-id').val(deviceId)
                    $('#edit-name').val(data.name);
                    $('#edit-uuid').val(data.uuid);
                    $('#edit-role').val(data.type);
                    $('#edit-organization').val(data.organization);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }


        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#addDeviceForm').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var uuid = $('#uuid').val();
                var type = $('#type').val();
                var organization = $('#organization').val();

                $.ajax({
                    type: 'POST',
                    url: '/devices/create',
                    data: {
                        name: name,
                        uuid: uuid,
                        type: type,
                        organization: organization,
                    },
                    success: function(data) {
                        $('#standard-modal').modal('hide');

                        $('.modal-backdrop').remove();
                        $('#success-alert-modal').modal('show');
                        getData();

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#danger-alert-modal').modal('show');
                    }
                });
            });


            $('#edit-device-form').submit(function (e) {
                e.preventDefault();
                var deviceId = $('#edit-device-id').val();
                var name = $('#edit-name').val();
                var uuid = $('#edit-uuid').val();
                var type = $('#edit-type').val();
                var organization = $('#edit-organization').val();
                var row = $('#edit-device-modal').data('row');

                $.ajax({
                    type: 'POST',
                    url: '/devices/update/' + deviceId,
                    data: {
                        name: name,
                        uuid: uuid,
                        type: type,
                        organization: organization,
                    },
                    success: function(data) {
                        $('#edit-device-modal').modal('hide');
                        $('#success-alert-modal').modal('show');

                        $('.modal-backdrop').remove();

                        getData();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        var errors = xhr.responseJSON.errors;

                            $('#danger-alert-modal').modal('show');
                    }
                });
            });


            $('.delete-device').click(function(e) {
                e.preventDefault();
                var deviceId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/devices/delete/' + deviceId,
                    success: function(data) {
                        row.remove();
                        $('#success-alert-modal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#danger-alert-modal').modal('show');
                    }
                });
            });

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
    <!-- Vendor js -->
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
                                        <p class="card-text">${value.value}</p>
                                        <h4 class="card-title">Ideal: ${value.property.min} - ${value.property.max}</h4>
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
    <!--  Select2 Plugin Js -->
    <script src="assets/vendor/select2/js/select2.min.js"></script>

@endsection


