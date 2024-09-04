@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('home.Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('users.Users') }}</li>
@endsection

@section('title')
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
                    <h4 class="header-title">{{ __('users.Users') }}</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">{{ __('users.Add User') }}
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

                    <div id="users-table">
                        @include('users.data', ['users' => $users])
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
                    <h4 class="modal-title" id="standard-modalLabel">{{ __('users.Add User') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('users.User Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('users.Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email" value="{{ old('email') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('users.Password') }}</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">{{ __('users.Role') }}</label>
                            <select id="role" name="role" class="form-control">
                                <option value="">{{ __('users.Select Role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="organization" class="form-label">{{ __('users.Organization') }}</label>
                            <select id="organization" name="organization" class="form-control">
                                <option value="NULL">{{ __('users.Select Organization') }}</option>
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

    <div id="edit-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-user-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-user-modalLabel">{{ __('users.Edit User') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-user-form" method="POST">
                        <input type="hidden" id="edit-user-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">{{ __('users.User Name') }}</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">{{ __('users.Email') }}</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="edit-organization" class="form-label">{{ __('users.Organization') }}</label>
                            <select id="edit-organization" name="edit-organization" class="form-control">
                                <option value="NULL">{{ __('users.Select Organization') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="invalid-feedback" id="business"></div>
                        <div class="mb-3">
                            <label for="edit-role" class="form-label">{{ __('users.Role') }}</label>
                            <select id="edit-role" name="role" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                url: '/users/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#users-table' ).html ( data );
                },
            } );
        }

        function setUser(userId) {
            $.ajax({
                type: 'GET',
                url: '/users/edit/' + userId,
                success: function(data) {

                    $('#edit-user-form').attr('action', '/users/update/' + userId);
                    $('#edit-user-id').val(userId)
                    $('#edit-name').val(data.name);
                    $('#edit-email').val(data.email);
                    $('#edit-role').val(data.role);
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
            $('#addUserForm').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var role = $('#role').val();
                var organization = $('#organization').val();

                $.ajax({
                    type: 'POST',
                    url: '/users/create',
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        role: role,
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
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#email + .invalid-feedback').html(errors.email[0]);
                            $('#password').addClass('is-invalid');
                            $('#password + .invalid-feedback').html(errors.password[0]);
                        }else{
                            $('#danger-alert-modal').modal('show');

                        }

                    }
                });
            });


            $('#edit-user-form').submit(function (e) {
                e.preventDefault();
                var userId = $('#edit-user-id').val();
                var name = $('#edit-name').val();
                var email = $('#edit-email').val();
                var role = $('#edit-role').val();
                var organization = $('#edit-organization').val();
                var row = $('#edit-user-modal').data('row');

                $.ajax({
                    type: 'POST',
                    url: '/users/update/' + userId,
                    data: {
                        name: name,
                        email: email,
                        role: role,
                        organization: organization,
                    },
                    success: function(data) {
                        $('#edit-user-modal').modal('hide');
                        $('#success-alert-modal').modal('show');

                        $('.modal-backdrop').remove();

                        getData();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.email) {
                            $('#email').addClass('is-invalid');
                            $('#email + .invalid-feedback').html(errors.email[0]);
                        }else{
                            $('#danger-alert-modal').modal('show');
                        }

                    }
                });
            });


            $('.delete-user').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/users/delete/' + userId,
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


