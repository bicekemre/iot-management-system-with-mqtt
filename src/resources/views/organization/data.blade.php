<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('organization.Name') }}</th>
        <th>{{ __('organization.Email') }}</th>
        <th>{{ __('organization.Address') }}</th>
        <th>{{ __('organization.Phone') }}</th>
        <th>{{ __('organization.Updated At') }}</th>
        <th>{{ __('organization.Created At') }}</th>
        <th>{{ __('organization.Action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($organizations->items() as $organization)
        <tr>
            <td>
                {{ $organization->name }}
            </td>
            <td> {{ $organization->email }}</td>
            <td>{{ $organization->address }}</td>
            <td>{{ $organization->phone }}</td>
            <td>{{ $organization->updated_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>{{ $organization->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

            <td>
                <a href="" class="text-reset fs-16 px-1 delete-organization" data-id="{{ $organization->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                <a href="#" class="text-reset fs-16 px-1 edit-organization" data-id="{{ $organization->id }}" data-bs-toggle="modal" data-bs-target="#edit-organization-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
                <a href="" class="text-reset fs-16 px-1" onclick="setCookie({{ $organization->id }})">
                    <i class="ri-search-eye-line"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($organizations->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $organizations->currentPage() - 1  }})" >{{ __('pagination.Previous') }}</button>
        </li>
    @endif
    @for ($i = 1; $i <= $organizations->lastPage(); $i++)
        <li class="page-item {{ $i == $organizations->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($organizations->currentPage() < $organizations->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $organizations->currentPage() + 1 }})">{{ __('pagination.Next') }}</button>
        </li>
    @endif
</ul>

