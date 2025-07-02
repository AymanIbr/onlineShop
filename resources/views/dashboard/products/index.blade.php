<x-backend.dashboard title="All Products">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800"><span class="count-category">All Products</span>
        </h1>
        <a class="btn btn-primary" href="{{ route('admin.products.create') }}">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Bar -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.index') }}">
                        <div class="row align-items-end">
                            <!-- Search -->
                            <div class="col-md-5 mb-2">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="🔍 Search by product title">
                            </div>

                            <!-- Category Filter -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">📂 All Categories</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('category_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label d-block invisible">Actions</label>
                                <div class="d-flex">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fas fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.products.index') }}"
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
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
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
                                <th>Title</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Active</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a target="_blank" href="{{ $product->image_path }}">
                                            <img width="100px" style="object-fit: cover; height: 100px"
                                                class="img-thumbnail" src="{{ $product->image_path }}" alt="">
                                        </a>
                                    </td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>

                                        @if ($product->active)
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
                                    {{-- <td>
                                        {{ Str::words($product->description, 2, '...') }}
                                    </td> --}}
                                    <td>{{ $product->created_at->diffForHumans() }}</td>
                                    <td>

                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="edit-row btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="confirmDestroy({{ $product->id }},this)"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    </td>
                                @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="9">No Data Found</td>
                                </tr>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $products->links() }}
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
                axios.delete('/admin/dashboard/products/' + id)
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
