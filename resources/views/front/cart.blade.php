<x-front.layout title="Cart">

    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.shop') }}">Shop</a></li>
                        <li class="breadcrumb-item">Cart</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-9 pt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">

                            @if ($cart->get()->isEmpty())
                                <div class="text-center py-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="#6c757d"
                                        class="mb-3" viewBox="0 0 16 16">
                                        <path
                                            d="M0 1a1 1 0 0 1 1-1h2.22a.5.5 0 0 1 .485.379L4.89 4H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 13H4a.5.5 0 0 1-.491-.408L1.01 2H1a1 1 0 0 1-1-1zm3.14 5l1.25 6h7.22l1.25-6H3.14z" />
                                    </svg>
                                    <h3 class="text-secondary mb-2">Your cart is empty</h3>
                                    <p class="text-muted">Looks like you haven't added any items yet.</p>
                                    <a href="{{ route('site.shop') }}" class="btn btn-dark mt-3">Start Shopping</a>
                                </div>
                            @else
                                <div id="cart-table-wrapper">
                                    <table class="table" id="cart">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart->get() as $item)
                                                <tr id="{{ $item->id }}">
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <a target="_blank"
                                                                href="{{ asset('storage/' . $item->product->image->path) }}">
                                                                <img src="{{ asset('storage/' . $item->product->image->path) }}"
                                                                    alt="Product Image" width="100">
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a style="color: black"
                                                            href="{{ route('site.product', $item->product->slug) }}">
                                                            {{ $item->product->title }}
                                                        </a>
                                                    </td>
                                                    <td>${{ $item->product->price }}</td>
                                                    <td>
                                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </div>
                                                            <input type="text"
                                                                class="form-control form-control-sm border-0 text-center qty"
                                                                value="{{ $item->quantity }}"
                                                                data-id="{{ $item->id }}"
                                                                data-stock="{{ $item->product->quantity }}"
                                                                data-track="{{ $item->product->track_qty ? '1' : '0' }}">
                                                            <div class="input-group-btn">
                                                                <button
                                                                    class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        $<span class="price" data-price="{{ $item->product->price }}">
                                                            {{ $item->quantity * $item->product->price }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger remove-item"
                                                            data-id="{{ $item->id }}">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif


                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card cart-summery">
                            <div class="sub-title">
                                <h2 class="bg-white">Cart Summery</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Subtotal</div>
                                    <div>$<span id="subtotal">{{ $cart->total() }}</span></div>
                                </div>
                                <div class="d-flex justify-content-between pb-2">
                                    <div>Shipping</div>
                                    <div>$20</div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div>Total</div>
                                    <div>$<span id="grandtotal">{{ $cart->total() + 20 }}</span></div>
                                </div>
                                <div class="pt-5">
                                    @if ($cart->get()->count() == 0)
                                        <a href="javascript:void(0)"
                                            class="btn-dark btn btn-block w-100 btn-proceed-checkout empty-cart">Cart
                                            Empty</a>
                                    @else
                                        <a href="{{ route('checkout') }}"
                                            class="btn-dark btn btn-block w-100 btn-proceed-checkout">Proceed to
                                            Checkout</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="input-group apply-coupan mt-4">
                            <input type="text" placeholder="Coupon Code" class="form-control">
                            <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    @push('js')
        <script>
            document.querySelector('.empty-cart').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Your cart is empty!',
                    confirmButtonText: 'OK'
                });
            });

            $(document).ready(function() {
                $(document).on('click', '.btn-minus', function() {
                    var input = $(this).closest('.input-group').find('.qty');
                    var quantity = parseInt(input.val());
                    if (quantity > 1) {
                        input.val(quantity - 1).trigger('change');
                        updateQuantity(input);
                        updateTotal(input);
                    }
                });

                $(document).on('click', '.btn-plus', function() {
                    var input = $(this).closest('.input-group').find('.qty');
                    var quantity = parseInt(input.val());
                    input.val(quantity + 1).trigger('change');
                    updateQuantity(input);
                    updateTotal(input);
                });

                $(document).on('change', '.qty', function() {
                    updateQuantity($(this));
                    updateTotal($(this));
                });

                // remove item from cart

                $(document).on('click', '.remove-item', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you really want to remove this item?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/carts/' + id,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: () => {
                                    $(`#${id}`).remove();
                                    Swal.fire('Deleted!', 'The item has been removed.',
                                        'success');
                                },
                                error: () => {
                                    Swal.fire('Error!', 'Something went wrong.', 'error');
                                }
                            });
                        }
                    });
                });

            });

            function updateQuantity(inputElement) {
                var quantity = inputElement.val();
                var cartId = inputElement.data('id');


                // tracing quantity
                var stock = parseInt(inputElement.data('stock'));
                var track = inputElement.data('track'); // 1 or 0

                if (track && quantity > stock) {
                    quantity = stock;
                    inputElement.val(stock);
                    Swal.fire('Oops!', 'You can only order up to ' + stock + ' item(s).', 'warning');
                }
                // ------

                $.ajax({
                    url: '/carts/' + cartId,
                    method: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        quantity: quantity
                    },
                    success: function() {
                        console.log('Quantity updated on server.');
                    }
                });
            }

            function updateTotal(inputElement) {
                let row = inputElement.closest('tr');
                let pricePerUnit = parseFloat(row.find('.price').data('price'));
                let quantity = parseInt(inputElement.val());

                let total = (pricePerUnit * quantity).toFixed(0);
                row.find('.price').text(total);

                updateCartSummary();
            }

            function updateCartSummary() {
                let subtotal = 0;
                $('.price').each(function() {
                    subtotal += parseFloat($(this).text());
                });
                $('#subtotal').text(subtotal.toFixed(0));
                let shipping = 20;
                let grandTotal = subtotal + shipping;
                $('#grandtotal').text(grandTotal.toFixed(0));
            }
        </script>
    @endpush

</x-front.layout>
