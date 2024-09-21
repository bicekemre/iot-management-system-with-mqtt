<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('devices.Name') }}</th>
        <th>{{ __('devices.UUID') }}</th>
        <th>{{ __('devices.Type') }}</th>
        <th>{{ __('devices.Organization') }}</th>
        <th>{{ __('devices.Parameters') }}</th>
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
