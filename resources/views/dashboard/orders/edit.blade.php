<x-backend.dashboard title="Edit Order #{{ $order->number }}">

    <div class="card">
        <div class="card-body">
            <form id="order-edit-form">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label><strong>Order Number:</strong></label>
                        <input type="text" class="form-control" value="{{ $order->number }}" disabled>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label><strong>User:</strong></label>
                        <input type="text" class="form-control" value="{{ $order->user->name ?? 'Guest' }}" disabled>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Status</strong></label>
                        <select name="status" class="form-control">
                            @foreach (['pending', 'processing', 'delivering', 'completed', 'cancelled', 'refunded'] as $status)
                                <option value="{{ $status }}" @selected($order->status == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Payment Status</strong></label>
                        <select name="payment_status" class="form-control">
                            @foreach (['pending', 'paid', 'failed'] as $payment_status)
                                <option value="{{ $payment_status }}" @selected($order->payment_status == $payment_status)>
                                    {{ ucfirst($payment_status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label><strong>Payment Method</strong></label>
                        <select name="payment_method" class="form-control">
                            @foreach (['cod' => 'Cash on Delivery', 'stripe' => 'Stripe'] as $key => $label)
                                <option value="{{ $key }}" @selected($order->payment_method == $key)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Order
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script>
            $('#order-edit-form').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin.orders.update', $order->id) }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message || 'Order updated successfully!',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('admin.orders.index') }}";
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Something went wrong.',
                            icon: 'error'
                        });
                    }
                });
            });
        </script>
    @endpush

</x-backend.dashboard>
