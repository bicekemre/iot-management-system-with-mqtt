@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Organizations</li>
@endsection
@section('title', 'Organizations')
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
                    <h4 class="header-title">Organizations</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Add Organizations
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

                    <div id="organizations-table">
                        @include('organizations.data', ['organizations' => $organizations])
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
                    <h4 class="modal-title" id="standard-modalLabel">Add Organizations</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                   name="email" value="{{ old('email') }}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
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

    <div id="edit-organization-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-organization-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-organization-modalLabel">Edit Organization</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-organization-form" method="POST">
                        <input type="hidden" id="edit-organization-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="edit-email" name="email">
                            <div class="invalid-feedback"></div>
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
                        <div class="invalid-feedback" id="business"></div>
                        <div class="mb-3">
                            <label for="edit-role" class="form-label">Role</label>
                            <select id="edit-role" name="role" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                url: '/organizations/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#organizations-table' ).html ( data );
                },
            } );
        }

        function setUser(userId) {
            $.ajax({
                type: 'GET',
                url: '/organizations/edit/' + userId,
                success: function(data) {

                    $('#edit-organization-form').attr('action', '/organizations/update/' + userId);
                    $('#edit-organization-id').val(userId)
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
                    url: '/organizations/create',
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


            $('#edit-organization-form').submit(function (e) {
                e.preventDefault();
                var userId = $('#edit-organization-id').val()
                var name = $('#edit-name').val();
                var email = $('#edit-email').val();
                var role = $('#edit-role').val();
                var organization = $('#edit-organization').val();
                var row = $('#edit-organization-modal').data('row');

                $.ajax({
                    type: 'POST',
                    url: '/organizations/update/' + userId,
                    data: {
                        name: name,
                        email: email,
                        role: role,
                        organization: organization,
                    },
                    success: function(data) {
                        $('#edit-organization-modal').modal('hide');
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


            $('.delete-organization').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/organizations/delete/' + userId,
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


