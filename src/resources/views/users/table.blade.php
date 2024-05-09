@foreach($users->items() as $user)
    <tr>
        <td>
            {{ $user->name }}
        </td>
        <td> {{ $user->email }}</td>
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
