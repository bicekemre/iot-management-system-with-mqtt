<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="header-title">User</h4>


                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#standard-modal">Add User
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

                <div id="users-table">
                    <table id="table" class="table table-striped">
                        <thead>
                        <tr>
                            @foreach($heads as $head)
                                <th>{{ $head }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @include($dataBlade, ['items' => $paginate->items()])

                        </tbody>
                    </table>
                    <ul class="pagination pagination-rounded mb-0">
                        @if ($paginate->currentPage() > 1)
                            <li class="page-item">
                                <button class="page-link" onclick="getData({{ $paginate->currentPage() - 1  }})" >Previous</button>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $paginate->lastPage(); $i++)
                            <li class="page-item {{ $i == $paginate->currentPage() ? 'active' : '' }}">
                                <button class="page-link"  onclick="getData({{ $i }})">{{ $i }}</button>
                            </li>
                        @endfor
                        @if ($paginate->currentPage() < $paginate->lastPage())
                            <li class="page-item">
                                <button class="page-link" onclick="getData({{  $paginate->currentPage() + 1 }})">Next</button>
                            </li>
                        @endif
                    </ul>


                </div>
            </div>
            <!-- end table-responsive-->
        </div> <!-- end card body-->

    </div> <!-- end card -->
</div><!-- end col-->
