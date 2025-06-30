<x-backend.dashboard title="All Sub Categories">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Sub Categories</span>
        </h1>
        <a class="btn btn-primary" href="{{ route('admin.sub-categories.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.sub-categories.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search sub-categories by name...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-end">
                    <button type="button" onclick="window.location.href='{{ route('admin.sub-categories.index') }}'"
                        class="btn btn-outline-secondary">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>


            <div class="table-content">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Active</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Active</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($subCategory as $sub_category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a target="_blank" href="{{ $sub_category->image_path }}">
                                            <img width="100px" style="object-fit: cover; height: 100px"
                                                class="img-thumbnail" src="{{ $sub_category->image_path }}"
                                                alt="">
                                        </a>
                                    </td>
                                    <td>{{ $sub_category->name }}</td>
                                    <td>{{ $sub_category->category->name }}</td>
                                    <td>

                                        @if ($sub_category->active)
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                                class="me-1 text-success" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                                class="me-1 text-center align-items-center text-danger" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </td>

                                    <td>{{ $sub_category->created_at->diffForHumans() }}</td>
                                    <td>

                                        <a href="{{ route('admin.sub-categories.edit', $sub_category->id) }}"
                                            class="edit-row btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="confirmDestroy({{ $sub_category->id }},this)"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="7">No Data Found</td>
                                </tr>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $subCategory->links() }}
                    </div>
                </div>

            </div>


        </div>
    </div>


    @push('js')
        <script>
            function confirmDestroy(id, reference) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        destroy(id, reference);
                    }
                })
            }

            function destroy(id, reference) {
                axios.delete('/admin/dashboard/sub-categories/' + id)
                    .then(function(response) {
                        ShowMessage(response.data);
                        reference.closest('tr').remove();
                    })
                    .catch(function(error) {
                        ShowMessage(error.response.data)
                    })
            }

            function ShowMessage(data) {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        </script>
    @endpush

</x-backend.dashboard>
