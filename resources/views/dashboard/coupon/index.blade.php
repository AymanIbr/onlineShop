<x-backend.dashboard title="All Coupons">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800">All Coupons</h1>
        <a class="btn btn-primary" href="{{ route('admin.coupons.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.coupons.index') }}">
                        <div class="row align-items-end">
                            <!-- Search by Code -->
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="🔍 Search by coupon code or name">
                            </div>

                            <!-- Type Filter -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Discount Type</label>
                                <select name="type" class="form-control">
                                    <option value="">All Types</option>
                                    <option value="percent" {{ request('type') == 'percent' ? 'selected' : '' }}>
                                        Percentage</option>
                                    <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Fixed
                                        Amount</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label d-block invisible">Actions</label>
                                <div class="d-flex">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.coupons.index') }}"
                                        class="btn btn-outline-secondary w-100 ml-2">
                                        <i class="fas fa-sync-alt"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-content">
                <div class="table-responsive">
                    <table class="table table-bordered" id="couponsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Discount Amount</th>
                                <th>Min. Order</th>
                                <th>Active</th>
                                <th>Starts At</th>
                                <th>Expires At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Discount Amount</th>
                                <th>Min. Order</th>
                                <th>Active</th>
                                <th>Starts At</th>
                                <th>Expires At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($coupons as $coupon)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>{{ $coupon->name ?? '-' }}</td>
                                    <td>{{ ucfirst($coupon->type) }}</td>
                                    <td>
                                        @if ($coupon->type == 'percent')
                                            {{ $coupon->discount_amount }} %
                                        @else
                                            ${{ number_format($coupon->discount_amount, 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->min_amount)
                                            ${{ number_format($coupon->min_amount, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $coupon->starts_at->format('Y-m-d') }}</td>
                                    <td>{{ $coupon->expires_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDestroy({{ $coupon->id }}, this)"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-danger">No Coupons Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $coupons->links() }}
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
                    icon: 'warning',
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
                axios.delete('/admin/dashboard/coupons/' + id)
                    .then(function(response) {
                        showMessage(response.data);
                        reference.closest('tr').remove();
                    })
                    .catch(function(error) {
                        showMessage(error.response.data);
                    });
            }

            function showMessage(data) {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.text,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        </script>
    @endpush

</x-backend.dashboard>
