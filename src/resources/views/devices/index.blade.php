@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">devices</li>
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
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="header-title">devices</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Add device
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive-sm">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="margin-right: 10px;">
                            <label for="limit" class="form-label">Per Page</label>
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
                    <h4 class="modal-title" id="standard-modalLabel">Add device</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDeviceForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="uuid" class="form-label">UUID</label>
                            <input type=number class="form-control" id="uuid"
                                   name="uuid" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Select Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="">Select Type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="organization" class="form-label">Organization</label>
                            <select id="organization" name="organization" class="form-control">
                                <option value="NULL">Select Organization</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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
                    <h4 class="modal-title" id="edit-device-modalLabel">Edit device</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-device-form" method="POST">
                        <input type="hidden" id="edit-device-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-uuid" class="form-label">UUID</label>
                            <input type=number class="form-control" id="edit-uuid"
                                   name="edit-uuid" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-type" class="form-label">Type</label>
                            <select id="edit-type" name="type" class="form-control">
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-organization" class="form-label">Business</label>
                            <select id="edit-organization" name="edit-organization" class="form-control">
                                <option value="NULL">Select Organization</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback" id="organization"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <div id="success-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-success">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-check-line h1"></i>
                        <h4 class="mt-2">Well Done!</h4>
                        <p class="mt-3">Your process done with successfully</p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-close-circle-line h1"></i>
                        <h4 class="mt-2">Error!</h4>
                        <p class="mt-3"></p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


@endsection

@section('script')

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
        });

    </script>
    <!-- Vendor js -->

    <!--  Select2 Plugin Js -->
    <script src="assets/vendor/select2/js/select2.min.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
@endsection


