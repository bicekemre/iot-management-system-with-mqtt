@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('home.Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('assignments',  ['locale' => app()->getLocale()]) }}">{{ __('assignments.Assignments') }}</a></li>
    <li class="breadcrumb-item active">{{ __('assignments.Assignments') }}</li>
@endsection
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">



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
                    <h4 class="header-title">{{ __('assignments.Assignments') }}</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">{{ __('assignments.Add Assignments') }}
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

                    <div id="assignments-table">
                        @include('assignments.data', ['assignments' => $assignments])
                    </div>
                </div>
                <!-- end table-responsive-->
            </div> <!-- end card body-->

        </div> <!-- end card -->
    </div><!-- end col-->

    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">{{ __('assignments.Assignments') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-assignment" action="{{ route('assignments.create') }}" method="POST">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create-organization" class="form-label">{{ __('assignments.Organization') }}</label>
                            <select name="create-organization" id="create-organization" class="form-control" onchange="setAssignments()" required>
                                <option value="0">{{ __('assignments.Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 d-none" id="device">
                            <label for="create-device" class="form-label">{{ __('assignments.Device') }}</label>
                            <select name="create-device" id="create-device" class="form-control" required>
                                <option value="0">{{ __('assignments.Select Device') }}</option>
                            </select>
                        </div>
                        <div class="mb-3 d-none" id="user">
                            <label for="create-user" class="form-label">{{ __('assignments.User') }}</label>
                            <select name="create-user" id="create-user" class="form-control" required>
                                <option value="0">{{ __('assignments.Select User') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('modals.Close') }}</button>
                        <button type="button" class="btn btn-primary" onclick="create()">{{ __('modals.Save changes') }}</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="edit-assignments-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-assignments-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-assignments-modalLabel">{{ __('assignments.Edit Assignments') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-assignments-form" method="POST">
                        <input type="hidden" id="edit-assignments-id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit-organization" class="form-label">{{ __('assignments.Organization') }}</label>
                                <select name="edit-organization" id="edit-organization" class="form-control" onchange="setEdit()" required>
                                    <option value="0">{{ __('assignments.Select Organization') }}</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit-device" class="form-label">{{ __('assignments.Device') }}</label>
                                <select name="edit-device" id="edit-device" class="form-control" required>
                                    <option value="0">{{ __('assignments.Select Device') }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit-user" class="form-label">{{ __('assignments.User') }}</label>
                                <select name="edit-user" id="edit-user" class="form-control" required>
                                    <option value="0">{{ __('assignments.Select User') }}</option>
                                </select>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('modals.Close') }}</button>
                    <button type="button" class="btn btn-primary" onclick="update()">{{ __('modals.Save changes') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    @include('modals.success')

    @include('modals.error')

@endsection
@section('script')
    <script>
        function getData(offset = 1) {
            let search = $ ( '#search' ).val ();
            let limit = $ ( '#limit' ).val () ?? 10;
            $.ajax ( {
                type: 'GET',
                url: '/assignments/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#assignments-table' ).html ( data );
                },
            } );
        }

        function setAssignments() {
            var organizationID = $('#create-organization').val();

            $.ajax({
                url: '/assignments/set/' + organizationID,
                method: 'get',
                success: function (data) {
                    $('#device').removeClass('d-none');
                    $('#user').removeClass('d-none');

                    $('#create-device').empty().append('<option value="0">{{ __('assignments.Select Device') }}</option>');
                    $('#create-user').empty().append('<option value="0">{{ __('assignments.Select User') }}</option>');

                    data.devices.forEach(function (device) {
                        $('#create-device').append('<option value="' + device.id + '">' + device.name + '</option>');
                    });

                    data.users.forEach(function (user) {
                        $('#create-user').append('<option value="' + user.id + '">' + user.name + '</option>');
                    });
                },
                error: function () {
                    alert('Error loading data');
                }
            });
        }



        function create()
        {
            var organizationID = $('#create-organization').val();
            var deviceID = $('#create-device').val();
            var userID = $('#create-user').val();

            $.ajax({
                url: '/assignments/create',
                method: 'POST',
                data: {
                    organizationID: organizationID,
                    deviceID: deviceID,
                    userID: userID
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
        }

        function edit(assignmentId)
        {
            $('#edit-assignments-modal').modal('show');


            $.ajax({
               url: '/assignments/edit/' + assignmentId,
                method: 'GET',
                success: function ( data ){
                  $('#edit-assignments-id').val(data.id);
                  $('#edit-organization').val(data.organization_id);

                   setEdit();

                  $('#edit-device').val(data.device_id).trigger('change');
                  $('#edit-user').val(data.user_id).trigger('change');


                },
            });
        }

        function setEdit()
        {
            var organizationID = $('#edit-organization').val();

            $.ajax({
                url: '/assignments/set/' + organizationID,
                method: 'get',
                success: function ( data ){
                    $('#edit-device').empty();
                    $('#edit-user').empty();


                    data.devices.forEach(function (device) {
                        $('#edit-device').append('<option value="' + device.id + '">' + device.name + '</option>');
                    });

                    data.users.forEach(function (user) {
                        $('#edit-user').append('<option value="' + user.id + '">' + user.name + '</option>');
                    });
                },
            });
        }

        function update()
        {
            var assignmentId = $('#edit-assignments-id').val();
            var organizationID = $('#edit-organization').val();
            var deviceID = $('#edit-device').val();
            var userID = $('#edit-user').val();

            $.ajax({
                url: '/assignments/update/' + assignmentId,
                method: 'POST',
                data: {
                    organizationID: organizationID,
                    deviceID: deviceID,
                    userID: userID
                },
                success: function(data) {
                    $('#edit-assignments-modal').modal('hide');

                    $('.modal-backdrop').remove();
                    $('#success-alert-modal').modal('show');
                    getData();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }

        function destroy(assignmentId)
        {
            $.ajax({
               url: '/assignments/delete/' + assignmentId,
                method: 'delete',
                success: function(data) {
                    row.remove();
                    $('#success-alert-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }
    </script>
@endsection
