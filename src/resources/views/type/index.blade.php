@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">type</li>
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
                    <h4 class="header-title">type</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Add type
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
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                            <div class="mb-3">
                               <a class="btn btn-primary" onclick="addProperty()">Add Property</a>
                            </div>
                        <div id="property-fields">
                            <div class="mb-3">

                            </div>
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

    <div id="edit-type-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-type-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-type-modalLabel">Edit type</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-type-form" method="POST">
                        <input type="hidden" id="edit-type-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="edit-name">
                        </div>
                        <div id="edit-property-fields">
                            <div class="mb-3">
                                <input type="hidden" id="property-id-">
                                <label for="property-name-1" class="form-label">Property Name</label>
                                <input type="text" class="form-control" id="property-name-1" name="property-name-1">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeProperty(this)">Remove</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addEditProperty()">Add Property</button>
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
                <label for="property-name-${propertyCount}" class="form-label">Property Name ${propertyCount}</label>
                <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>
                <input type="text" class="form-control" id="property-name-${propertyCount}" name="property-name-${propertyCount}">
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
                            <label for="edit-property-name-${index}" class="form-label">Property Name ${index + 1}</label>
                            <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>
                            <input type="text" class="form-control" id="edit-property-name-${index}" name="property-name-${index}" value="${property.name}">
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
                <label for="edit-property-name-${index}" class="form-label">Property Name ${index + 1}</label>
                <button type="button" class="btn btn-link p-0" onclick="removeProperty(this)">    <i class="bi bi-x-circle"></i></button>

                <input type="text" class="form-control" id="edit-property-name-${index}" name="property-name-${index}">
            </div>
        `;
            $('#edit-property-fields').append(propertyField);
        }

        function removeProperty(button) {
            $(button).parent().remove();
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
                    if (propertyName) {
                        properties.push(propertyName);
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


            $('#edit-type-form').submit(function (e) {
                e.preventDefault();
                var typeId = $('#edit-type-id').val();
                var type_name = $('#edit-name').val();
                var properties = [];

                $('#edit-property-fields .mb-3').each(function(index, element) {
                    var propertyId = $(element).find('input[type="hidden"]').val();
                    var propertyName = $(element).find('input[type="text"]').val();
                    properties.push({ id: propertyId, name: propertyName });
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


