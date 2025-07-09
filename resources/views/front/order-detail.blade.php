<x-front.layout title="Order Details">
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('profile') }}">My Account</a></li>
                        <li class="breadcrumb-item">Order Details</li>
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
                                <h2 class="h5 mb-0 pt-2 pb-2">Order #{{ $order->number }}</h2>
                            </div>

                            <div class="card-body pb-0">
                                <div class="card card-sm">
                                    <div class="card-body bg-light mb-3">
                                        <div class="row">
                                            <div class="col-6 col-lg-3">
                                                <h6 class="heading-xxxs text-muted">Order No:</h6>
                                                <p class="mb-lg-0 fs-sm fw-bold">{{ $order->number }}</p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <h6 class="heading-xxxs text-muted">Shipped Date:</h6>
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                    <time datetime="{{ $order->created_at->format('Y-m-d') }}">
                                                        {{ $order->created_at->format('d M, Y') }}
                                                    </time>
                                                </p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <h6 class="heading-xxxs text-muted">Status:</h6>
                                                <p class="mb-0 fs-sm fw-bold">{{ ucfirst($order->status) }}</p>
                                            </div>
                                            <div class="col-6 col-lg-3">
                                                <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                                <p class="mb-0 fs-sm fw-bold">${{ number_format($order->total, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer p-3">
                                <h6 class="mb-7 h5 mt-4">Order Items ({{ $order->items->count() }})</h6>
                                <hr class="my-3">

                                <ul class="list-group">
                                    @foreach ($order->items as $item)
                                        <li class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-md-3 col-xl-2">
                                                    <a href="">
                                                        <img src="{{ $item->product->image_path}}"
                                                            alt="{{ $item->product->title ?? $item->product_name }}"
                                                            class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-4 fs-sm fw-bold">
                                                        <a class="text-body"
                                                            href="">
                                                            {{ $item->product->title ?? $item->product_name }} x
                                                            {{ $item->quantity }}
                                                        </a> <br>
                                                        <span
                                                            class="text-muted">${{ number_format($item->price, 2) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="card card-lg mb-5 mt-3">
                            <div class="card-body">
                                <h6 class="mt-0 mb-3 h5">Order Total</h6>
                                <ul>
                                    <li class="list-group-item d-flex">
                                        <span>Subtotal</span>
                                        <span
                                            class="ms-auto">${{ number_format($order->total - $order->shipping - ($order->discount ?? 0), 2) }}</span>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <span>Tax</span>
                                        <span class="ms-auto">$0.00</span>
                                    </li>
                                    <li class="list-group-item d-flex">
                                        <span>Shipping</span>
                                        <span class="ms-auto">${{ number_format($order->shipping, 2) }}</span>
                                    </li>
                                    @if ($order->discount)
                                        <li class="list-group-item d-flex text-success">
                                            <span>Discount</span>
                                            <span class="ms-auto">- ${{ number_format($order->discount, 2) }}</span>
                                        </li>
                                    @endif
                                    <li class="list-group-item d-flex fs-lg fw-bold">
                                        <span>Total</span>
                                        <span class="ms-auto">${{ number_format($order->total, 2) }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-front.layout>
