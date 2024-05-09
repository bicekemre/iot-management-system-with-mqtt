<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>Role Name</th>
        <th>Attach Permission</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($roles->items() as $role)
        <tr>
            <td>
                {{ $role->name }}
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td> </td>
            <td>{{ $user->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

            <td>
                <a href="" class="text-reset fs-16 px-1 delete-user" data-id="{{ $user->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                <a href="#" class="text-reset fs-16 px-1 edit-user" onclick="setUser({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#edit-user-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($users->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $users->currentPage() - 1  }})" >Previous</button>
        </li>
    @endif
    @for ($i = 1; $i <= $users->lastPage(); $i++)
        <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($users->currentPage() < $users->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $users->currentPage() + 1 }})">Next</button>
        </li>
    @endif
</ul>

