<x-backend.dashboard title="Order Details - #{{ $order->number }}">

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Order Details <small class="text-muted">#{{ $order->number }}</small></h4>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <div class="card-body">

            <div class="row mb-4">
                <!-- User Details -->
                <div class="col-md-6">
                    <h5>User Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong>
                            {{ $order->user->name ?? ($order->addresses->first()?->first_name . ' ' . $order->addresses->first()?->last_name ?? 'Guest') }}
                        </li>
                        <li class="list-group-item"><strong>Email:</strong>
                            {{ $order->user->email ?? ($order->addresses->first()?->email ?? '-') }}</li>
                        <li class="list-group-item"><strong>Phone:</strong>
                            {{ $order->user->phone ?? ($order->addresses->first()?->mobile ?? '-') }}</li>
                        <li class="list-group-item">
                            <strong>Address:</strong>
                            @if ($order->addresses->isNotEmpty())
                                <ul class="mb-0" style="list-style-type: none; padding-left: 0;">
                                    <li><strong>Street:</strong> {{ $order->addresses->first()->address }}</li>
                                    <li><strong>City:</strong> {{ $order->addresses->first()->city }}</li>
                                    <li><strong>State:</strong> {{ $order->addresses->first()->state ?? '-' }}</li>
                                    <li><strong>ZIP Code:</strong> {{ $order->addresses->first()->zip ?? '-' }}</li>
                                    <li><strong>Country:</strong> {{ $order->addresses->first()->country_name }}</li>
                                </ul>
                            @else
                                <p>—</p>
                            @endif
                        </li>
                        @if ($order->addresses->first()?->appartment)
                            <li class="list-group-item"><strong>Appartment:</strong>
                                {{ $order->addresses->first()->appartment }}</li>
                        @endif
                        @if ($order->addresses->first()?->order_notes)
                            <li class="list-group-item"><strong>Order Notes:</strong>
                                {{ $order->addresses->first()->order_notes }}</li>
                        @endif
                    </ul>
                </div>

                <!-- Order Info -->
                <div class="col-md-6">
                    <h5>Order Information</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Status:</strong>
                            <span
                                class="badge
                                {{ $order->status == 'completed'
                                    ? 'bg-success'
                                    : ($order->status == 'cancelled'
                                        ? 'bg-danger'
                                        : ($order->status == 'processing'
                                            ? 'bg-primary'
                                            : 'bg-warning')) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </li>
                        <li class="list-group-item">
                            <strong>Payment Status:</strong>
                            <span
                                class="badge
                                {{ $order->payment_status == 'paid'
                                    ? 'bg-success'
                                    : ($order->payment_status == 'failed'
                                        ? 'bg-danger'
                                        : 'bg-warning') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Coupon Code:</strong> {{ $order->coupon_code ?? '-' }}</li>
                        <li class="list-group-item">
                            <strong>Payment Method:</strong>
                            @if ($order->payment_method === 'cod')
                                Cash on Delivery
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Order Date:</strong>
                            {{ $order->created_at->format('d M Y, h:i A') }}</li>
                    </ul>
                </div>
            </div>

            <!-- Order Items -->
            <h5 class="mb-3">Order Items ({{ $order->items->count() }})</h5>

            @if ($order->items->count() > 0)
                <div class="table-responsive mb-4">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->title ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->product && $item->product->image_path)
                                            <img src="{{ $item->product->image_path }}" alt="Product Image"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No items found for this order.</p>
            @endif

            <!-- Order Summary -->
            <div class="row justify-content-end">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity), 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Discount</span>
                            <span>${{ number_format($order->discount ?? 0, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Shipping</span>
                            <span>${{ number_format($order->shipping, 2) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between fw-bold bg-light">
                            <span>Total</span>
                            <span>${{ number_format($order->total, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</x-backend.dashboard>
