<x-front.layout>
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.shop') }}">Shop</a></li>
                        <li class="breadcrumb-item">Checkout</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-9 pt-4">
            <div class="container">

                <form action="" method="POST" name="orderForm" id="orderForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="sub-title">
                                <h2>Shipping Address</h2>
                            </div>
                            <div class="card shadow-lg border-0">
                                <div class="card-body checkout-form">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('first_name') }}" name="first_name"
                                                    id="first_name" class="form-control" placeholder="First Name">
                                                <div id="first_name_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('last_name') }}" name="last_name"
                                                    id="last_name" class="form-control" placeholder="Last Name">
                                                <div id="last_name_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('email') }}" name="email"
                                                    id="email" class="form-control" placeholder="Email">
                                                <div id="email_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select a Country</option>
                                                    @foreach ($countries as $code => $name)
                                                        <option value="{{ $code }}"
                                                            {{ old('country') == $code ? 'selected' : '' }}>
                                                            {{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="country_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="address" value="{{ old('address') }}" id="address" cols="30" rows="3" placeholder="Address"
                                                    class="form-control"></textarea>
                                                <div id="address_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('appartment') }}" name="appartment"
                                                    id="appartment" class="form-control"
                                                    placeholder="Apartment, suite, unit, etc. (optional)">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('city') }}" name="city"
                                                    id="city" class="form-control" placeholder="City">
                                                <div id="city_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" value="{{ old('state') }}" name="state"
                                                    id="state" class="form-control" placeholder="State">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <input type="text" name="zip" value="{{ old('zip') }}"
                                                    id="zip" class="form-control" placeholder="Zip">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <input type="text" name="mobile" value="{{ old('mobile') }}"
                                                    id="mobile" class="form-control" placeholder="Mobile No.">
                                                <div id="mobile_error" class="invalid-feedback"></div>

                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <textarea name="order_notes" value="{{ old('order_notes') }}" id="order_notes" cols="30" rows="2"
                                                    placeholder="Order Notes (optional)" class="form-control"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="sub-title">
                                <h2>Order Summery</h3>
                            </div>
                            <div class="card cart-summery">
                                <div class="card-body">
                                    @foreach ($cart->get() as $item)
                                        <div class="d-flex justify-content-between pb-2">
                                            <div class="h6">{{ $item->product->title }} x {{ $item->quantity }}
                                            </div>
                                            <div class="h6">
                                                ${{ number_format($item->product->price * $item->quantity) }}</div>
                                        </div>
                                    @endforeach
                                    <div class="d-flex justify-content-between summery-end">
                                        <div class="h6"><strong>Subtotal</strong></div>
                                        <div class="h6"><strong>${{ number_format($cart->total()) }}</strong>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="h6"><strong>Shipping</strong></div>
                                        <div class="h6"><strong>$20</strong></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 summery-end">
                                        <div class="h5"><strong>Total</strong></div>
                                        <div class="h5"><strong>${{ number_format($cart->total() + 20) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card payment-form ">
                                <h3 class="card-title h5 mb-3">Payment Method</h3>
                                <div>
                                    <input checked type="radio" name="payment_method" value="cod"
                                        id="payment_method_one">
                                    <label for="payment_method_one">Cash on Delivery</label>
                                </div>

                                <div>
                                    <input type="radio" name="payment_method" value="stripe"
                                        id="payment_method_two">
                                    <label for="payment_method_two">Stripe</label>
                                </div>



                                {{-- <h3 class="card-title h5 mb-3">Payment Details</h3> --}}
                                <div class="card-body p-0 d-none mt-3" id="card-payment-form">
                                    <div class="mb-3">
                                        <label for="card_number" class="mb-2">Card Number</label>
                                        <input type="text" name="card_number" id="card_number"
                                            placeholder="Valid Card Number" class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="mb-2">Expiry Date</label>
                                            <input type="text" name="expiry_date" id="expiry_date"
                                                placeholder="MM/YYYY" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="mb-2">CVV Code</label>
                                            <input type="text" name="expiry_date" id="expiry_date"
                                                placeholder="123" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4">
                                    <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>
        </section>
    </main>


    @push('js')
        <script>
            $("#payment_method_one").click(function() {

                if ($(this).is(":checked") == true) {
                    $("#card-payment-form").addClass("d-none");
                }

            });

            $("#payment_method_two").click(function() {

                if ($(this).is(":checked") == true) {
                    $("#card-payment-form").removeClass("d-none");
                }

            });


            $('#orderForm').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('checkout') }}",
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success(response.message || 'Order placed successfully!');

                        window.location.href = response.redirect;
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            $('.is-invalid').removeClass('is-invalid');
                            $('.invalid-feedback').text('');

                            for (let field in errors) {
                                let errorField = $(`[name="${field}"]`);
                                let errorMsg = errors[field][0];

                                if (errorField.length) {
                                    errorField.addClass('is-invalid');
                                    $(`#${field}_error`).text(errorMsg);
                                } else {
                                    toastr.error(errorMsg);
                                }
                            }
                        } else if (xhr.status === 400) {
                            let message = xhr.responseJSON.message ||
                                "Requested quantity is not available.";
                            toastr.error(message);
                        } else {
                            toastr.error("Something went wrong. Please try again.");
                            console.log(xhr.responseText);
                        }
                    }
                });
            });
        </script>
    @endpush

</x-front.layout>
