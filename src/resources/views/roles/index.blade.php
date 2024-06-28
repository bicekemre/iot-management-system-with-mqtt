@extends('layout.master')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
    <li class="breadcrumb-item active">Roles</li>
@endsection
@section('title', 'Users')
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
                    <h4 class="header-title">Roles</h4>


                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#standard-modal">Add Role
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

                    <div id="roles-table">
                        @include('roles.data', ['roles' => $roles])
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
                    <h4 class="modal-title" id="standard-modalLabel">Roles and Permissions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add-role" action="{{ route('roles.create') }}" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="name"></textarea>
                        </div>
                        <label for="permissions" class="form-label">Permissions</label>

                        <div class="mb-3">
                            <!-- Users Permissions -->
                            <input type="checkbox" class="form-check-input" id="user-permissions-checkbox" onclick="toggleAllPermissions('user-permission-options', 'user-permissions-checkbox')">
                            <a href="#" id="user-permissions" onclick="permission('user-permission-options')">Users --></a>
                            <div id="user-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="create-user-permission" onclick="toggleParentCheckbox('user-permission-options', 'user-permissions-checkbox')">
                                <label class="form-check-label" for="create-user-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="update-user-permission" onclick="toggleParentCheckbox('user-permission-options', 'user-permissions-checkbox')">
                                <label class="form-check-label" for="update-user-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="read-user-permission" onclick="toggleParentCheckbox('user-permission-options', 'user-permissions-checkbox')">
                                <label class="form-check-label" for="read-user-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="delete-user-permission" onclick="toggleParentCheckbox('user-permission-options', 'user-permissions-checkbox')">
                                <label class="form-check-label" for="delete-user-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Organizations Permissions -->
                            <input type="checkbox" class="form-check-input" id="organization-permissions-checkbox" onclick="toggleAllPermissions('organization-permission-options', 'organization-permissions-checkbox')">
                            <a href="#" id="organization-permissions" onclick="permission('organization-permission-options')">Organizations --></a>
                            <div id="organization-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="create-organization-permission" onclick="toggleParentCheckbox('organization-permission-options', 'organization-permissions-checkbox')">
                                <label class="form-check-label" for="create-organization-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="update-organization-permission" onclick="toggleParentCheckbox('organization-permission-options', 'organization-permissions-checkbox')">
                                <label class="form-check-label" for="update-organization-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="read-organization-permission" onclick="toggleParentCheckbox('organization-permission-options', 'organization-permissions-checkbox')">
                                <label class="form-check-label" for="read-organization-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="delete-organization-permission" onclick="toggleParentCheckbox('organization-permission-options', 'organization-permissions-checkbox')">
                                <label class="form-check-label" for="delete-organization-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">

                            <!-- Devices Permissions -->
                            <input type="checkbox" class="form-check-input" id="device-permissions-checkbox" onclick="toggleAllPermissions('device-permission-options', 'device-permissions-checkbox')">
                            <a href="#" id="device-permissions" onclick="permission('device-permission-options')">Devices --></a>
                            <div id="device-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="create-device-permission" onclick="toggleParentCheckbox('device-permission-options', 'device-permissions-checkbox')">
                                <label class="form-check-label" for="create-device-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="update-device-permission" onclick="toggleParentCheckbox('device-permission-options', 'device-permissions-checkbox')">
                                <label class="form-check-label" for="update-device-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="read-device-permission" onclick="toggleParentCheckbox('device-permission-options', 'device-permissions-checkbox')">
                                <label class="form-check-label" for="read-device-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="delete-device-permission" onclick="toggleParentCheckbox('device-permission-options', 'device-permissions-checkbox')">
                                <label class="form-check-label" for="delete-device-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Roles Permissions -->
                            <input type="checkbox" class="form-check-input" id="role-permissions-checkbox" onclick="toggleAllPermissions('role-permission-options', 'role-permissions-checkbox')">
                            <a href="#" id="role-permissions" onclick="permission('role-permission-options')">Roles --></a>
                            <div id="role-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="create-role-permission" onclick="toggleParentCheckbox('role-permission-options', 'role-permissions-checkbox')">
                                <label class="form-check-label" for="create-role-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="update-role-permission" onclick="toggleParentCheckbox('role-permission-options', 'role-permissions-checkbox')">
                                <label class="form-check-label" for="update-role-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="read-role-permission" onclick="toggleParentCheckbox('role-permission-options', 'role-permissions-checkbox')">
                                <label class="form-check-label" for="read-role-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="delete-role-permission" onclick="toggleParentCheckbox('role-permission-options', 'role-permissions-checkbox')">
                                <label class="form-check-label" for="delete-role-permission">Delete</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="create()">Save changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="edit-role-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit-role-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="edit-role-modalLabel">Edit Role</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-role-form" method="POST">
                        <input type="hidden" id="edit-role-id">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="edit-description" name="description"></textarea>
                        </div>
                        <label for="edit-permissions" class="form-label">Permissions</label>

                        <div class="mb-3">
                            <!-- Users Permissions -->
                            <input type="checkbox" class="form-check-input" id="edit-user-permissions-checkbox" onclick="toggleAllPermissions('edit-user-permission-options', 'edit-user-permissions-checkbox')">
                            <a href="#" id="edit-user-permissions" onclick="permission('edit-user-permission-options')">Users --></a>
                            <div id="edit-user-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="edit-create-user-permission" onclick="toggleParentCheckbox('edit-user-permission-options', 'edit-user-permissions-checkbox')">
                                <label class="form-check-label" for="edit-create-user-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="edit-update-user-permission" onclick="toggleParentCheckbox('edit-user-permission-options', 'edit-user-permissions-checkbox')">
                                <label class="form-check-label" for="edit-update-user-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="edit-read-user-permission" onclick="toggleParentCheckbox('edit-user-permission-options', 'edit-user-permissions-checkbox')">
                                <label class="form-check-label" for="edit-read-user-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="edit-delete-user-permission" onclick="toggleParentCheckbox('edit-user-permission-options', 'edit-user-permissions-checkbox')">
                                <label class="form-check-label" for="edit-delete-user-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Organizations Permissions -->
                            <input type="checkbox" class="form-check-input" id="edit-organization-permissions-checkbox" onclick="toggleAllPermissions('edit-organization-permission-options', 'edit-organization-permissions-checkbox')">
                            <a href="#" id="edit-organization-permissions" onclick="permission('edit-organization-permission-options')">Organizations --></a>
                            <div id="edit-organization-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="edit-create-organization-permission" onclick="toggleParentCheckbox('edit-organization-permission-options', 'edit-organization-permissions-checkbox')">
                                <label class="form-check-label" for="edit-create-organization-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="edit-update-organization-permission" onclick="toggleParentCheckbox('edit-organization-permission-options', 'edit-organization-permissions-checkbox')">
                                <label class="form-check-label" for="edit-update-organization-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="edit-read-organization-permission" onclick="toggleParentCheckbox('edit-organization-permission-options', 'edit-organization-permissions-checkbox')">
                                <label class="form-check-label" for="edit-read-organization-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="edit-delete-organization-permission" onclick="toggleParentCheckbox('edit-organization-permission-options', 'edit-organization-permissions-checkbox')">
                                <label class="form-check-label" for="edit-delete-organization-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Devices Permissions -->
                            <input type="checkbox" class="form-check-input" id="edit-device-permissions-checkbox" onclick="toggleAllPermissions('edit-device-permission-options', 'edit-device-permissions-checkbox')">
                            <a href="#" id="edit-device-permissions" onclick="permission('edit-device-permission-options')">Devices --></a>
                            <div id="edit-device-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="edit-create-device-permission" onclick="toggleParentCheckbox('edit-device-permission-options', 'edit-device-permissions-checkbox')">
                                <label class="form-check-label" for="edit-create-device-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="edit-update-device-permission" onclick="toggleParentCheckbox('edit-device-permission-options', 'edit-device-permissions-checkbox')">
                                <label class="form-check-label" for="edit-update-device-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="edit-read-device-permission" onclick="toggleParentCheckbox('edit-device-permission-options', 'edit-device-permissions-checkbox')">
                                <label class="form-check-label" for="edit-read-device-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="edit-delete-device-permission" onclick="toggleParentCheckbox('edit-device-permission-options', 'edit-device-permissions-checkbox')">
                                <label class="form-check-label" for="edit-delete-device-permission">Delete</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Roles Permissions -->
                            <input type="checkbox" class="form-check-input" id="edit-role-permissions-checkbox" onclick="toggleAllPermissions('edit-role-permission-options', 'edit-role-permissions-checkbox')">
                            <a href="#" id="edit-role-permissions" onclick="permission('edit-role-permission-options')">Roles --></a>
                            <div id="edit-role-permission-options" class="align-top" style="display: none;">
                                <input type="checkbox" class="form-check-input" id="edit-create-role-permission" onclick="toggleParentCheckbox('edit-role-permission-options', 'edit-role-permissions-checkbox')">
                                <label class="form-check-label" for="edit-create-role-permission">Create</label>

                                <input type="checkbox" class="form-check-input" id="edit-update-role-permission" onclick="toggleParentCheckbox('edit-role-permission-options', 'edit-role-permissions-checkbox')">
                                <label class="form-check-label" for="edit-update-role-permission">Update</label>

                                <input type="checkbox" class="form-check-input" id="edit-read-role-permission" onclick="toggleParentCheckbox('edit-role-permission-options', 'edit-role-permissions-checkbox')">
                                <label class="form-check-label" for="edit-read-role-permission">Read</label>

                                <input type="checkbox" class="form-check-input" id="edit-delete-role-permission" onclick="toggleParentCheckbox('edit-role-permission-options', 'edit-role-permissions-checkbox')">
                                <label class="form-check-label" for="edit-delete-role-permission">Delete</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="update()">Save changes</button>
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
                url: '/roles/items/' + offset + '/' + limit,
                data: { search: search },
                success: function ( data ) {
                    $ ( '#roles-table' ).html ( data );
                },
            } );
        }

        function create() {
            var formData = {
                name: $ ( '#name' ).val (),
                description: $ ( '#description' ).val (),
                permissions: {
                    users_create: $ ( '#create-user-permission' ).is ( ':checked' ),
                    users_update: $ ( '#update-user-permission' ).is ( ':checked' ),
                    users_read: $ ( '#read-user-permission' ).is ( ':checked' ),
                    users_delete: $ ( '#delete-user-permission' ).is ( ':checked' ),

                    organizations_create: $ ( '#create-organization-permission' ).is ( ':checked' ),
                    organizations_update: $ ( '#update-organization-permission' ).is ( ':checked' ),
                    organizations_read: $ ( '#read-organization-permission' ).is ( ':checked' ),
                    organizations_delete: $ ( '#delete-organization-permission' ).is ( ':checked' ),

                    devices_create: $ ( '#create-device-permission' ).is ( ':checked' ),
                    devices_update: $ ( '#update-device-permission' ).is ( ':checked' ),
                    devices_read: $ ( '#read-device-permission' ).is ( ':checked' ),
                    devices_delete: $ ( '#delete-device-permission' ).is ( ':checked' ),


                    roles_create: $ ( '#create-role-permission' ).is ( ':checked' ),
                    roles_update: $ ( '#update-role-permission' ).is ( ':checked' ),
                    roles_read: $ ( '#read-role-permission' ).is ( ':checked' ),
                    roles_delete: $ ( '#delete-role-permission' ).is ( ':checked' ),
                },
            };

            $.ajax({
                type: 'POST',
                url: 'roles/create',
                data: formData,
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

        function editItem(roleId) {
            $.ajax({
                type: 'GET',
                url: '/roles/edit/' + roleId,
                success: function(data) {
                    $('#edit-role-id').val(roleId);
                    $('#edit-name').val(data.name);
                    $('#edit-description').val(data.description);

                    // Uncheck all checkboxes
                    $('#edit-role-form input[type="checkbox"]').prop('checked', false);

                    // Set user permissions
                    $('#edit-create-user-permission').prop('checked', data.permissions.users_create);
                    $('#edit-update-user-permission').prop('checked', data.permissions.users_update);
                    $('#edit-read-user-permission').prop('checked', data.permissions.users_read);
                    $('#edit-delete-user-permission').prop('checked', data.permissions.users_delete);

                    // Set organization permissions
                    $('#edit-create-organization-permission').prop('checked', data.permissions.organizations_create);
                    $('#edit-update-organization-permission').prop('checked', data.permissions.organizations_update);
                    $('#edit-read-organization-permission').prop('checked', data.permissions.organizations_read);
                    $('#edit-delete-organization-permission').prop('checked', data.permissions.organizations_delete);

                    // Set device permissions
                    $('#edit-create-device-permission').prop('checked', data.permissions.devices_create);
                    $('#edit-update-device-permission').prop('checked', data.permissions.devices_update);
                    $('#edit-read-device-permission').prop('checked', data.permissions.devices_read);
                    $('#edit-delete-device-permission').prop('checked', data.permissions.devices_delete);

                    // Set role permissions
                    $('#edit-create-role-permission').prop('checked', data.permissions.roles_create);
                    $('#edit-update-role-permission').prop('checked', data.permissions.roles_update);
                    $('#edit-read-role-permission').prop('checked', data.permissions.roles_read);
                    $('#edit-delete-role-permission').prop('checked', data.permissions.roles_delete);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#danger-alert-modal').modal('show');
                }
            });
        }

        function update(){
            var roleId = $('#edit-role-id').val();
            var formData = {
                name: $ ( '#edit-name' ).val (),
                description: $ ( '#edit-description' ).val (),
                permissions: {
                    users_create:  $('#edit-create-user-permission').is ( ':checked' ),
                    users_update:  $('#edit-update-user-permission').is ( ':checked' ),
                    users_read:    $('#edit-read-user-permission').is ( ':checked' ),
                    users_delete:  $('#edit-delete-user-permission').is ( ':checked' ),

                    organizations_create:  $('#edit-create-organization-permission').is ( ':checked' ),
                    organizations_update:  $('#edit-update-organization-permission').is ( ':checked' ),
                    organizations_read:    $('#edit-read-organization-permission').is ( ':checked' ),
                    organizations_delete:  $('#edit-delete-organization-permission').is ( ':checked' ),

                    devices_create: $('#edit-create-device-permission').is ( ':checked' ),
                    devices_update: $('#edit-update-device-permission').is ( ':checked' ),
                    devices_read:   $('#edit-read-device-permission').is ( ':checked' ),
                    devices_delete: $('#edit-delete-device-permission').is ( ':checked' ),


                    roles_create: $('#edit-create-role-permission').is ( ':checked' ),
                    roles_update: $('#edit-update-role-permission').is ( ':checked' ),
                    roles_read:   $('#edit-read-role-permission').is ( ':checked' ),
                    roles_delete: $('#edit-delete-role-permission').is ( ':checked' ),
                },
            };

            $.ajax({
                type: 'POST',
                url: 'roles/update/'+ roleId,
                data: formData,
                success: function(data) {
                    $('#edit-role-modal').modal('hide');

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





        $(document).ready(function() {

            // $("#inline-permissions").editable({
            //     pk:1,
            //     limit:3,
            //     title:"select",
            //     mode:"inline",
            //     inputclass:"form-control-sm",
            //     source:[
            //         {value:1,text:"Banana"},
            //         {value:2,text:"Peach"},
            //         {value:3,text:"Apple"},
            //         {value:4,text:"Watermelon"},
            //         {value:5,text:"Orange"}
            //     ]
            // });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.delete-role').click(function(e) {
                e.preventDefault();
                var roleId = $(this).data('id');
                var row = $(this).closest('tr');

                $.ajax({
                    type: 'DELETE',
                    url: '/roles/delete/' + roleId,
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



        function permission(id) {
            const element = document.getElementById(id);
            if (element.style.display === "none") {
                element.style.display = "block";
            } else {
                element.style.display = "none";
            }
        }

        function toggleAllPermissions(permissionOptionsId, parentCheckboxId) {
            const options = document.getElementById(permissionOptionsId);
            const checkboxes = options.querySelectorAll('input[type="checkbox"]');
            const parentCheckbox = document.getElementById(parentCheckboxId);
            const isChecked = parentCheckbox.checked;

            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
        }

        function toggleParentCheckbox(permissionOptionsId, parentCheckboxId) {
            const options = document.getElementById(permissionOptionsId);
            const checkboxes = options.querySelectorAll('input[type="checkbox"]');
            const parentCheckbox = document.getElementById(parentCheckboxId);

            let allChecked = true;
            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) {
                    allChecked = false;
                }
            });

            parentCheckbox.checked = allChecked;
        }
    </script>


@endsection


