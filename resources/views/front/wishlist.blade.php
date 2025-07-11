<x-front.layout>
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('profile') }}">My Account</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-11">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.parts.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                            </div>
                            <div class="card-body p-4" id="wishlist-items">
                                @forelse ($wishlist as $item)
                                    <div class="d-sm-flex justify-content-between mb-4 pb-3 border-bottom wishlist-item"
                                        data-id="{{ $item->product_id }}">
                                        <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                            <a class="d-block flex-shrink-0 mx-auto me-sm-4"
                                                href="{{ route('site.product', $item->product->slug) }}"
                                                style="width: 10rem;">
                                                <img src="{{ asset('storage/' . $item->product->image->path) }}"
                                                    alt="{{ $item->product->title }}"
                                                    style="width: 100%; height: 100px; object-fit: cover;">
                                            </a>
                                            <div class="pt-2">
                                                <h3 class="product-title fs-base mb-2">
                                                    <a
                                                        href="{{ route('site.product', $item->product->slug) }}">{{ $item->product->title }}</a>
                                                </h3>
                                                <div class="fs-lg text-accent pt-2">
                                                    ${{ number_format($item->product->price, 2) }}</div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                            <button class="btn btn-outline-danger btn-sm btn-remove-wishlist"
                                                type="button" data-id="{{ $item->product_id }}">
                                                <i class="fas fa-trash-alt me-2"></i>Remove
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p>Your wishlist is empty.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    @push('js')
        <script>
            $(document).ready(function() {
                $('.btn-remove-wishlist').click(function() {
                    let button = $(this);
                    let productId = button.data('id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to remove this product from your wishlist?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/wishlist/' + productId,
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    button.closest('.wishlist-item').remove();
                                    Swal.fire(
                                        'Removed!',
                                        response.message,
                                        'success'
                                    );

                                    if ($('#wishlist-items').children().length == 0) {
                                        $('#wishlist-items').html(
                                            '<p>Your wishlist is empty.</p>');
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'Something went wrong, please try again.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
</x-front.layout>
