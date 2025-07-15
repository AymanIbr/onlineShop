<x-backend.dashboard title="Manage Product Ratings">

    @push('css')
        <style>
            .star-rating {
                position: relative;
                font-size: 1.25rem;
                color: #d3d3d3;
                display: inline-block;
                unicode-bidi: bidi-override;
                direction: rtl;
            }

            .star-rating .back-stars,
            .star-rating .front-stars {
                display: flex;
                position: relative;
            }

            .star-rating .front-stars {
                color: #ffc107;
                position: absolute;
                top: 0;
                left: 0;
                overflow: hidden;
                white-space: nowrap;
                width: 0;
            }
        </style>
    @endpush

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h3 mb-0 text-gray-800">Product Ratings</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ratings as $rating)
                            <tr id="rating-row-{{ $rating->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rating->product->title }}</td>
                                <td>{{ $rating->username }}</td>
                                <td>{{ $rating->email }}</td>
                                <td>
                                    <div class="star-rating" title="{{ $rating->rating }} Stars">
                                        <div class="back-stars">
                                            @for ($i = 0; $i < 5; $i++)
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            @endfor

                                            <div class="front-stars" style="width: {{ $rating->rating * 20 }}%">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($rating->comment, 50) }}</td>
                                <td id="status-cell-{{ $rating->id }}">
                                    @if ($rating->status == 1)
                                        <a href="javascript:void(0);" onclick="changeStatus(0,'{{ $rating->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                                class="me-1 text-success" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="javascript:void(0);" onclick="changeStatus(1,'{{ $rating->id }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                                class="me-1 text-center align-items-center text-danger" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $rating->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No ratings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $ratings->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            function changeStatus(status, id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to " + (status == 1 ? "approve" : "disapprove") + " this rating?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.change.rating') }}',
                            method: 'get',
                            data: {
                                status: status,
                                id: id
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Updated',
                                    text: 'Rating status updated successfully',
                                    timer: 1200,
                                    showConfirmButton: false
                                });

                                const newStatus = status == 1 ? 0 : 1;

                                const statusHtml = (status == 1) ?
                                    `<a href="javascript:void(0);" onclick="changeStatus(${newStatus}, '${id}')">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                    class="me-1 text-success" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                           </a>` :
                                    `<a href="javascript:void(0);" onclick="changeStatus(${newStatus}, '${id}')">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 40px; height: 40px;"
                                    class="me-1 text-danger" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                           </a>`;

                                $(`#status-cell-${id}`).html(statusHtml);
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.'
                                });
                            }
                        });
                    }
                });
            }
        </script>
    @endpush


</x-backend.dashboard>
