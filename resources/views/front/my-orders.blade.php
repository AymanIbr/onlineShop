<x-front.layout title="My Orders">


    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('profile') }}">My Account</a></li>
                        <li class="breadcrumb-item">My Orders</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class=" section-11 ">
            <div class="container  mt-5">
                <div class="row">
                    <div class="col-md-3">
                        @include('front.parts.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Order Number</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Payment</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('order.details', $order->id) }}">
                                                            {{ $order->number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        @php
                                                            $statusColors = [
                                                                'pending' => 'warning',
                                                                'processing' => 'info',
                                                                'delivering' => 'primary',
                                                                'completed' => 'success',
                                                                'cancelled' => 'danger',
                                                                'refunded' => 'secondary',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if ($order->payment_status === 'paid')
                                                            <span class="badge bg-success">Paid</span>
                                                        @elseif ($order->payment_status === 'pending')
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        @else
                                                            <span class="badge bg-danger">Failed</span>
                                                        @endif
                                                    </td>
                                                    <td>${{ number_format($order->total, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">You have no orders
                                                        yet.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-front.layout>
