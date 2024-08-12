@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home', ['locale' => app()->getLocale()]) }}">{{ __('home.Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('type.Type') }}</li>
@endsection
@section('title', 'type')
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
                    <h4 class="header-title">{{ __('type.Type') }}</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">{{ __('type.Add Type') }}
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

                    <div id="type-table">
                        @include('type.data', ['types' => $type])
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
                    <h4 class="modal-title" id="standard-modalLabel">Add type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add-type-form">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('type.Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                            <div class="mb-3">
                               <a class="btn btn-primary" onclick="addProperty()">{{ __('type.Add Property') }}</a>
                            </div>
                        <div id="property-fields">
                            <div class="mb-3">

                            </div>
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

    <div id="edit-type-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-type-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-type-modalLabel">{{ __('type.Edit Type') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-type-form" method="POST">
                        <input type="hidden" id="edit-type-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">{{ __('type.Name') }}</label>
                            <input type="text" class="form-control" id="edit-name" name="edit-name">
                        </div>
                        <div id="edit-property-fields">
                            <div class="mb-3">
                                <input type="hidden" id="property-id-">
                                <label for="property-name-1" class="form-label">{{ __('type.Property Name') }}</label>
                                <input type="text" class="form-control" id="property-name-1" name="property-name-1">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeProperty(this)">{{ __('type.Remove') }}</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addEditProperty()">{{ __('type.Add Property') }}</button>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('modals.Close') }}</button>
                            <button type="submit" class="btn btn-primary" onclick="update()">{{ __('modals.Save changes') }}</button>
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
                url: '/type/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#type-table' ).html ( data );
                },
            } );
        }

        let propertyCount = 0;

        function addProperty() {
            propertyCount++;
            const newPropertyDiv = `
            <div class="mb-3">
                <label for="property-name-${propertyCount}" class="form-label">{{ __('type.Property Name') }} ${propertyCount}</label>
                <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>
                <input type="text" class="form-control" id="property-name-${propertyCount}" name="property-name-${propertyCount}">
               <label for=ideal-values" class="form-label">Ideal</label>
                <input type="number" id="min-value-${propertyCount}" class="form-control mb-1" placeholder="min">
                <input type="number" id="max-value-${propertyCount}" class="form-control mb-1" placeholder="max">
            </div>
        `;
            $('#property-fields').append(newPropertyDiv);
        }


        function setType(typeId) {
            $.ajax({
                type: 'GET',
                url: '/type/edit/' + typeId,
                success: function(data) {
                    $('#edit-type-form').attr('action', '/type/update/' + typeId);
                    $('#edit-type-id').val(typeId);
                    $('#edit-name').val(data.name);

                    // Clear existing property fields
                    $('#edit-property-fields').empty();

                    // Add property fields
                    data.properties.forEach(function(property, index) {
                        const propertyField = `
                        <div class="mb-3">
                            <input type="hidden" id="edit-property-id-${index}" value="${property.id}">
                            <label for="edit-property-name-${index}" class="form-label">{{ __('type.Property Name') }} ${index + 1}</label>
                            <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>
                            <input type="text" class="form-control" id="edit-property-name-${index}" name="property-name-${index}" value="${property.name}">
                            <label for=edit-min-value" class="form-label">Ideal </label>
                            <input type="number" id="edit-min-value-${index}" class="form-control mb-1" placeholder="min" value="${property.min}">
                            <input type="number" id="edit-max-value-${index}" class="form-control mb-1" placeholder="max" value="${property.max}">
                        </div>

                    `;
                        $('#edit-property-fields').append(propertyField);
                    });

                    // Show the modal
                    $('#edit-type-modal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }

        function addEditProperty() {
            const index = $('#edit-property-fields').children().length;
            const propertyField = `
            <div class="mb-3">
                <input type="hidden" id="edit-property-id-${index}" value="">
                <label for="edit-property-name-${index}" class="form-label">{{ __('type.Property Name') }} ${index + 1}</label>
                <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>

                <input type="text" class="form-control" id="edit-property-name-${index}" name="property-name-${index}">

                <label for=edit-min-value" class="form-label">Ideal </label>
                <input type="number" id="edit-min-value-${index}" class="form-control mb-1" placeholder="min">
                <input type="number" id="edit-max-value-${index}" class="form-control mb-1" placeholder="max">
            </div>
        `;
            $('#edit-property-fields').append(propertyField);
        }

        function removeProperty(button) {
            $(button).parent().remove();
        }



        function update() {
            $('#edit-type-form').submit(function (e) {
                e.preventDefault();
                var typeId = $('#edit-type-id').val();
                var type_name = $('#edit-name').val();
                var properties = [];

                $('#edit-property-fields .mb-3').each(function(index, element) {
                    var propertyId = $(element).find('input[type="hidden"]').val();
                    var propertyName = $(element).find('input[type="text"]').val();
                    var min = $(`#edit-min-value-${index}`).val();
                    var max = $(`#edit-max-value-${index}`).val();
                    properties.push({
                        id: propertyId,
                        name: propertyName,
                        min: min,
                        max: max
                    });
                });

                $.ajax({
                    type: 'POST',
                    url: '/type/update/' + typeId,
                    data: JSON.stringify({ type_name: type_name, properties: properties }),
                    contentType: 'application/json',
                    success: function(response) {
                        // Handle success response
                        $('#edit-type-modal').modal('hide');
                        $('#success-alert-modal').modal('show');
                        getData(); // Refresh the page or update the table accordingly
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        $('#danger-alert-modal').modal('show');
                    }
                });
            });
        }
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#add-type-form').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                const properties = [];
                for (let i = 1; i <= propertyCount; i++) {
                    const propertyName = $(`#property-name-${i}`).val();
                    let min = $(`#min-value-${i}`).val();
                    let max = $(`#max-value-${i}`).val();
                    if (propertyName) {
                        properties.push({
                            name: propertyName,
                            min: min,
                            max: max
                        });
                    }
                }


                $.ajax({
                    type: 'POST',
                    url: '/type/create',
                    data: {
                        name: name,
                        properties: properties
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


            $('.delete-type').click(function(e) {
                e.preventDefault();
                var typeId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/type/delete/' + typeId,
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

@endsection


