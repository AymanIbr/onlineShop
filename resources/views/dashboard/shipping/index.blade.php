<x-backend.dashboard title="All Shipping">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Shipping</span>
        </h1>
        <a class="btn btn-primary" href="{{ route('admin.shipping.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.shipping.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                placeholder="Search Shipping by country...">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6 text-end">
                    <button type="button" onclick="window.location.href='{{ route('admin.shipping.index') }}'"
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
                                <th>Country</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Country</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($shippings as $shipping)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Symfony\Component\Intl\Countries::getName($shipping->country) }} - ({{ $shipping->country }})</td>
                                    <td>{{ $shipping->amount }}</td>

                                    <td>{{ $shipping->created_at->diffForHumans() }}</td>
                                    <td>

                                        <a href="{{ route('admin.shipping.edit', $shipping->id) }}"
                                            class="edit-row btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="confirmDestroy({{ $shipping->id }},this)"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="5">No Data Found</td>
                                </tr>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $shippings->links() }}
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
                axios.delete('/admin/dashboard/shipping/' + id)
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
