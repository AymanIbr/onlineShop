<x-backend.dashboard title="All Users">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800">All Users</h1>
        <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                   placeholder="Search by name or email...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <button onclick="window.location.href='{{ route('admin.users.index') }}'" class="btn btn-outline-secondary">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                                <td>
                                    @if ($user->active == true)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDestroy({{ $user->id }}, this)" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function confirmDestroy(id, reference) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        destroy(id, reference);
                    }
                });
            }

            function destroy(id, reference) {
                axios.delete('/admin/dashboard/users/' + id)
                    .then(response => {
                        Swal.fire({
                            icon: response.data.icon,
                            title: response.data.title,
                            text: response.data.text,
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        reference.closest('tr').remove();
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                        });
                    });
            }
        </script>
    @endpush

</x-backend.dashboard>
