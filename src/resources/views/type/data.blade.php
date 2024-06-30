<table id="table" class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Updated At</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($types->items() as $type)
        <tr>
            <td>
                {{ $type->name }}
            </td>
            <td>{{ $type->updated_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>
            <td>{{ $type->created_at->timezone('GMT+3')->format('d-m-Y, H:i')}}</td>

            <td>
                <a href="" class="text-reset fs-16 px-1 delete-type" data-id="{{ $type->id }}">
                    <i class="ri-delete-bin-2-line"></i>
                </a>
                <a href="#" class="text-reset fs-16 px-1 edit-type" onclick="setType({{ $type->id }})" data-bs-toggle="modal" data-bs-target="#edit-type-modal">
                    <i class="ri-edit-2-fill"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<ul class="pagination pagination-rounded mb-0">
    @if ($types->currentPage() > 1)
        <li class="page-item">
            <button class="page-link" onclick="getData({{ $types->currentPage() - 1  }})" >Previous</button>
        </li>
    @endif
    @for ($i = 1; $i <= $types->lastPage(); $i++)
        <li class="page-item {{ $i == $types->currentPage() ? 'active' : '' }}">
            <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
        </li>
    @endfor
    @if ($types->currentPage() < $types->lastPage())
        <li class="page-item">
            <button class="page-link" onclick="getData({{  $types->currentPage() + 1 }})">Next</button>
        </li>
    @endif
</ul>

