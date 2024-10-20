<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('devices.Name') }}</th>
        <th>{{ __('devices.UUID') }}</th>
        <th>{{ __('devices.Type') }}</th>
        <th>{{ __('devices.Organization') }}</th>
        <th>{{ __('devices.Parameters') }}</th>
        <th>{{ __('devices.Connection') }}</th>
        <th>{{ __('devices.Updated At') }}</th>
        <th>{{ __('devices.Created At') }}</th>
        <th>{{ __('devices.Action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($devices->items() as $device)
        <tr>
            <td>
                {{ $device->name }}
            </td>
            <td>{{ $device->uuid }}</td>
            <td>{{ $device->type->name ?? '' }}</td>
            <td>{{ $device->organization->name ?? '' }}</td>
            <td>
                <button type="button" class="btn btn-info" onclick="getDevice({{$device->id}})" data-bs-toggle="modal" data-bs-target="#device-modal">{{ __('devices.See Device') }}</button>
            </td>
            <td>
                <button type="button"  onclick="connectionStatus({{ $device->id }})" class="btn btn-primary">{{ __('devices.Connection') }}</button>
            </td>
            <td>{{ $device->updated_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>{{ $device->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>
                @if((new \App\Models\User())->check('devices_delete'))
                <a href="" class="text-reset fs-16 px-1 delete-device" data-id="{{ $device->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                @endif
                @if((new \App\Models\User())->check('devices_update'))
                <a href="#" class="text-reset fs-16 px-1 edit-device" onclick="setUser({{ $device->id }})" data-bs-toggle="modal" data-bs-target="#edit-device-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($devices->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $devices->currentPage() - 1  }})">{{ __('pagination.Previous') }}</button>
        </li>
    @endif
    @for ($i = 1; $i <= $devices->lastPage(); $i++)
        <li class="page-item {{ $i == $devices->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($devices->currentPage() < $devices->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $devices->currentPage() + 1 }})">{{ __('pagination.Next') }}</button>
        </li>
    @endif
</ul>
<div id="connection-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">{{ __('devices.MQTT Connection') }}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('modals.Close') }}"></button>
            </div>
            <div class="modal-body">
                <form id="addDeviceForm">
                    @csrf
                    <input type="hidden" id="connection-device-id">
                    <div class="mb-3">
                        <label for="topic" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="topic" name="topic">
                    </div>
                    <div class="mb-3">
                        <button type="button" id="start-button" style="display: none;" onclick="connectDevice()" class="btn btn-primary">{{ __('devices.Connect') }}</button>

                        <button type="button" id="stop-button" style="display: none;" onclick="disconnectDevice()" class="btn btn-danger">{{ __('devices.Disconnect') }}</button>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    function  connectionStatus(deviceId) {
        $('#connection-modal').modal('show');
        $('#connection-device-id').val(deviceId);

        $.ajax({
            url: '/device/connection-status/' + deviceId,
            method: 'get',
            success: function ( response ){

                $('#topic').val(response.topic);

                if (response.status === 'running') {
                    $('#start-button').hide();
                    $('#stop-button').show();
                } else {
                    $('#start-button').show();
                    $('#stop-button').hide();
                }
            }
        });
    }
    function connectDevice()
    {
        var deviceId =  $('#connection-device-id').val();
        var topic = $('#topic').val();
        $.ajax({
            url:'/device/connect',
            method: 'post',
            data: {
                deviceId: deviceId,
                topic: topic
            },
            success: function ( data ){
                connectionStatus(deviceId);
                $('#connection-modal').modal('hide');
                $('#success-alert-modal').modal('show');
            },
            error: function ( data ){
                $('#danger-alert-modal').modal('show');
            }
        });
    }

    function disconnectDevice()
    {
        var device_id =  $('#connection-device-id').val();
        $.ajax({
            url: '/device/disconnect',
            method: 'post',
            data: {
                device_id: device_id,
            },
            success: function ( data ){
                connectionStatus(device_id);
                $('#connection-modal').modal('hide');
                $('#success-alert-modal').modal('show');
            },
            error: function ( data ){
                $('#danger-alert-modal').modal('show');
            }
        });
    }
</script>
