@extends('layout.master')

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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <label for="device" class="form-label"></label>
                        <select id="device" name="device"  onchange="device(this)">
                            <option>Select Device </option>
                            @foreach($devices as $device)
                                <option  value="{{ $device->id }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <a href="javascript:;" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                        <a data-bs-toggle="collapse" href="#weeklysales-collapse" role="button" aria-expanded="false" aria-controls="weeklysales-collapse"><i class="ri-subtract-line"></i></a>
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

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-widgets">
                        <a href="javascript:" data-bs-toggle="reload"><i class="ri-refresh-line"></i></a>
                        <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                        <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                    </div>
                    <h5 class="header-title mb-0">Device Battery</h5>

                    <div id="yearly-sales-collapse" class="collapse pt-3 show">
                        <div dir="ltr">
                            <div id="chart-battery" class="apex-charts" data-colors="#3bc0c3,#1a2942,#d1d7d973"></div>
                        </div>

                        <div class="row text-center">
                            <div class="col">
                                <p class="text-muted mt-3">Device Name</p>
                                <h3 class=" mb-0">
                                    <span id="device-name">Sensor 1</span>
                                </h3>
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
                            <a data-bs-toggle="collapse" href="#yearly-sales-collapse" role="button" aria-expanded="false" aria-controls="yearly-sales-collapse"><i class="ri-subtract-line"></i></a>
                            <a href="#" data-bs-toggle="remove"><i class="ri-close-line"></i></a>
                        </div>
                        <h5 class="header-title mb-0">Projects</h5>
                    </div>

                    <div id="yearly-sales-collapse" class="collapse show">

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
                                        <button type="button" class="btn btn-info" onclick="getDevice({{$device->id}})" data-bs-toggle="modal" data-bs-target="#device-modal">See Device</button>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="device-modal-name"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="device-item" class="table">
                        <thead>
                        <tr>
                            <th>Property Name</th>
                            <th>Property Value</th>
                        </tr>
                        </thead>
                        <tbody id="property-area">

                        </tbody>
                    </table>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection
@section('script')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function getDevice(deviceId)
        {
            $('#property-area').empty();

            $.ajax({

                type: 'GET',
                url: '/devices/item/' + deviceId,
                success: function ( data ){
                    $('#device-modal-name').text(data.name);
                    data.values.forEach(function ( value ){
                        let propertyData = `
                        <tr>
                            <th>${value.property.name}</th>
                            <th>${value.value}</th>
                        </tr>

                    `;
                        $('#property-area').append(propertyData);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }
    </script>
    <script>

        // Initialize the chart with empty data
        var options = {
            chart: {
                type: 'line'
            },
            series: [],
            xaxis: {
                categories: []
            }
        };

        // Create and render the initial empty chart
        window.chart = new ApexCharts(document.querySelector("#line-chart"), options);
        window.chart.render();
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

            var options = {
                chart: {
                    height: 350,
                    type: 'radialBar',
                },
                series: [70],
                labels: ['Progress'],
            }

            var chartBattery = new ApexCharts(document.querySelector("#chart-battery"), options);

            chartBattery.render();

        });
    </script>

@endsection
