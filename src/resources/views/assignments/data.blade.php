<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('assignments.Organization') }}</th>
        <th>{{ __('assignments.Device') }}</th>
        <th>{{ __('assignments.User') }}</th>
        <th>{{ __('assignments.Actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($assignments->items() as $assignment)
        <tr>
            <td>
                {{ $assignment->organization->name ?? ''}}
            </td>
            <td>{{ $assignment->device->name ?? ''}}</td>
            <td>{{ $assignment->users->name ?? ''}}</td>

            <td>
                <a href="" class="text-reset fs-16 px-1 delete-role" data-id="{{ $assignment->id }}" onclick="destroy({{$assignment->id}})">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                <a href="#" class="text-reset fs-16 px-1 edit-role" onclick="edit({{ $assignment->id }})" data-bs-toggle="modal" data-bs-target="#edit-role-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($assignments->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $assignments->currentPage() - 1  }})" >{{ __('pagination.Previous') }}</button>
        </li>
    @endif
    @for ($i = 1; $i <= $assignments->lastPage(); $i++)
        <li class="page-item {{ $i == $assignments->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($assignments->currentPage() < $assignments->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $assignments->currentPage() + 1 }})">{{ __('pagination.Next') }}</button>
        </li>
    @endif
</ul>

