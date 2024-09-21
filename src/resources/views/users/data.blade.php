<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>{{ __('users.User Name') }}</th>
        <th>{{ __('users.Email') }}</th>
        <th>{{ __('users.Role') }}</th>
        <th>{{ __('users.Organization') }}</th>
        <th>{{ __('users.Updated At') }}</th>
        <th>{{ __('users.Created At') }}</th>
        <th>{{ __('users.Actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users->items() as $user)
        <tr>
            <td>
                {{ $user->name }}
            </td>
            <td> {{ $user->email }}</td>
            <td>{{ $user->role->name ?? '' }}</td>
            <td>{{ $user->organization->name ?? '' }}</td>
            <td>{{ $user->updated_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>{{ $user->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

            <td>
                @if((new \App\Models\User())->check('users_delete'))
                <a href="" class="text-reset fs-16 px-1 delete-user" data-id="{{ $user->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                @endif
                @if((new \App\Models\User())->check('users_update'))
                <a href="#" class="text-reset fs-16 px-1 edit-user" onclick="setUser({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#edit-user-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($users->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $users->currentPage() - 1  }})" >{{ __('pagination.Previous') }}</button>
        </li>
    @endif
    @for ($i = 1; $i <= $users->lastPage(); $i++)
        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($users->currentPage() < $users->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $users->currentPage() + 1 }})">{{ __('pagination.Next') }}</button>
        </li>
    @endif
</ul>

