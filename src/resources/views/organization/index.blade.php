@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('home.Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('organization.Organizations') }}</li>
@endsection
@section('title', 'organizations')
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
                    <h4 class="header-title">{{ __('organization.Organizations') }}</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">{{ __('organization.Add Organization') }}
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


                    <div id="organizations-table">
                        @include('organization.data', ['organizations' => $organizations])
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
                    <h4 class="modal-title" id="standard-modalLabel">{{ __('organization.Add Organization') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBusinessForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('organization.Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('organization.Email') }}</label>
                            <input type=email class="form-control " id="email"
                                   name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('organization.Phone') }}</label>
                            <input type="number" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">{{ __('organization.Address') }}</label>
                            <textarea class="form-control " id="address"
                                      name="address" required></textarea>
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

    <div id="edit-organization-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-organization-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-organization-modalLabel">{{ __('organization.Edit Organization') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-organization-form" method="POST">
                        <input type="hidden" id="edit-organization-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">{{ __('organization.Name') }}</label>
                            <input type="text" class="form-control" id="edit-name" name="edit-name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">{{ __('organization.Email') }}</label>
                            <input type=email class="form-control " id="edit-email"
                                   name="edit-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-phone" class="form-label">{{ __('organization.Phone') }}</label>
                            <input type="number" class="form-control" id="edit-phone" name="edit-phone">
                        </div>
                        <div class="mb-3">
                            <label for="edit-address" class="form-label">{{ __('organization.Address') }}</label>
                            <textarea class="form-control " id="edit-address"
                                      name="edit-address" required></textarea>
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
            let search = $('#search').val();
            let limit = $('#limit').val() ?? 10;
            $.ajax({
                type: 'GET',
                url: '/organizations/items/' + offset + '/' + limit,
                data: { search: search },
                success: function(data) {
                    $('#organizations-table').html(data);
                },
            });
        }


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#addBusinessForm').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var address = $('#address').val();

                $.ajax({
                    type: 'POST',
                    url: '/organizations/create',
                    data: {
                        name: name,
                        email: email,
                        phone: phone,
                        address: address,
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



            $('.edit-organization').click(function(e) {
                e.preventDefault();
                var organizationId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'GET',
                    url: '/organizations/edit/' + organizationId,
                    success: function(data) {
                        $('#edit-organization-form').attr('action', '/organizations/update/' + organizationId);
                        $('#edit-organization-id').val(organizationId)
                        $('#edit-name').val(data.name);
                        $('#edit-email').val(data.email);
                        $('#edit-phone').val(data.phone);
                        $('#edit-address').val(data.address);
                        $('#edit-organization-modal').data('row', row);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#danger-alert-modal').modal('show');
                    }
                });
            });


            $('#edit-organization-form').submit(function (e) {
                e.preventDefault();
                var organizationId = $('#edit-organization-id').val()
                var name = $('#edit-name').val();
                var email = $('#edit-email').val();
                var phone = $('#edit-phone').val();
                var address = $('#edit-address').val();
                var row = $('#edit-organization-modal').data('row');

                $.ajax({
                    type: 'POST',
                    url: '/organizations/update/' + organizationId,
                    data: {
                        name: name,
                        email: email,
                        phone: phone,
                        address: address,
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
                        $('#danger-alert-modal').modal('show');
                    }
                });
            });


            $('.delete-organization').click(function(e) {
                e.preventDefault();
                var organizationId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/organizations/delete/' + organizationId,
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

    <!--  Select2 Plugin Js -->
    <script src="{{ assert('assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
@endsection


