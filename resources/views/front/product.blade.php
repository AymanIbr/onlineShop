<x-front.layout>



    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.shop') }}">Shop</a></li>
                        <li class="breadcrumb-item">{{ $product->title }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col-md-5">
                        <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner bg-light">
                                @if ($product->gallery->isNotEmpty())
                                    @foreach ($product->gallery as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image"
                                                style="width: 100%; height: 400px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="carousel-item active">
                                        <img src="{{ $product->image_path }}" alt="Main Image"
                                            style="width: 100%; height: 400px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                            <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="bg-light right">
                            <h1>{{ $product->title }}</h1>
                            <div class="d-flex mb-3">
                                <div class="text-primary mr-2">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star-half-alt"></small>
                                    <small class="far fa-star"></small>
                                </div>
                                <small class="pt-1">(99 Reviews)</small>
                            </div>
                            <h2 class="price text-secondary"><del>${{ $product->compare_price }}</del></h2>
                            <h2 class="price ">${{ $product->price }}</h2>

                            {{-- {{ Str::words($product->description, 2, '...') }} --}}
                            <p>{!! \Illuminate\Support\Str::words(strip_tags($product->description), 10, '...') !!}</p>


                            @if ($product->track_qty == 1)
                                @if ($product->quantity > 0)
                                    <button type="button" class="btn btn-dark add-to-cart"
                                        data-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART
                                    </button>
                                @else
                                    <button type="button" class="btn btn-dark">
                                        Out Of Stock
                                    </button>
                                @endif
                            @else
                                <button type="button" class="btn btn-dark add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-light">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab"
                                        aria-controls="description" aria-selected="true">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                        data-bs-target="#shipping" type="button" role="tab"
                                        aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                        data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                        aria-selected="false">Reviews</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <p>
                                        {!! $product->description !!}
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="shipping" role="tabpanel"
                                    aria-labelledby="shipping-tab">
                                    <p>{!! $product->shipping_returns !!}</p>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel"
                                    aria-labelledby="reviews-tab">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pt-5 section-8">
            <div class="container">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
                <div class="col-md-12">
                    <div id="related-products" class="carousel">


                        @if ($relatedProducts->isNotEmpty())
                            @foreach ($relatedProducts as $product)
                                @include('front.parts.item')
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </main>


</x-front.layout>
