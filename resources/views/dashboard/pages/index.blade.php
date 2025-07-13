<x-backend.dashboard title="All Pages">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Pages</span></h1>
        <a class="btn btn-primary" href="{{ route('admin.pages.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.pages.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search pages by name...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-end">
                    <button type="button" onclick="window.location.href='{{ route('admin.pages.index') }}'"
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
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Active</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Active</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($pages as $page)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $page->name }}</td>
                                    <td>{{ $page->slug }}</td>
                                    <td>
                                        @if ($page->active)
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px;"
                                                class="text-success" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px;"
                                                class="text-danger" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </td>
                                    <td>{{ $page->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.pages.edit', $page->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="confirmDestroy({{ $page->id }}, this)"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="6">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination mt-3">
                        {{ $pages->links() }}
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
                axios.delete('/admin/dashboard/pages/' + id)
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
