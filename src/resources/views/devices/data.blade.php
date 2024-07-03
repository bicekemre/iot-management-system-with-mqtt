<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>UUID</th>
        <th>Type</th>
        <th>Organization</th>
        <th>Parameters</th>
        <th>Updated At</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($devices->items() as $device)
        <tr>
            <td>
                {{ $device->name }}
            </td>
            <td> {{ $device->uuid }}</td>
            <td>{{ $device->type->name ?? '' }}</td>
            <td>{{ $device->organization->name ?? '' }}</td>
            <td>
                <button type="button" class="btn btn-info" onclick="getDevice({{$device->id}})" data-bs-toggle="modal" data-bs-target="#device-modal">See Device</button>
            </td>
            <td>{{ $device->updated_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>{{ $device->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

            <td>
                <a href="" class="text-reset fs-16 px-1 delete-device" data-id="{{ $device->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                <a href="#" class="text-reset fs-16 px-1 edit-device" onclick="setUser({{ $device->id }})" data-bs-toggle="modal" data-bs-target="#edit-device-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($devices->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $devices->currentPage() - 1  }})" >Previous</button>
        </li>
    @endif
    @for ($i = 1; $i <= $devices->lastPage(); $i++)
        <li class="page-item {{ $i == $devices->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($devices->currentPage() < $devices->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $devices->currentPage() + 1 }})">Next</button>
        </li>
    @endif
</ul>

<div class="modal fade" id="device-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="device-name"></h4>
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

<script>
    function getDevice(deviceId)
    {
        $('#property-area').empty();

        $.ajax({

            type: 'GET',
            url: '/devices/item/' + deviceId,
            success: function ( data ){
                $('#device-name').text(data.name);
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
