<x-front.layout title="Home">

    @if (session()->has('swal'))
        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const options = @json(session('swal'));
                    Swal.fire(options);
                });
            </script>
        @endpush
    @endif
    <main>
        <section class="section-1">
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('front-assets/images/carousel-1-m.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('front-assets/images/carousel-1.jpg') }}" />
                            <img src="images/carousel-1.jpg" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                                    stet
                                    amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('site.shop') }}">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">

                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('front-assets/images/carousel-2-m.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('front-assets/images/carousel-2.jpg') }}" />
                            <img src="images/carousel-2.jpg" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                                    stet
                                    amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('front-assets/images/carousel-3-m.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('front-assets/images/carousel-3.jpg') }}" />
                            <img src="{{ asset('front-assets/images/carousel-2.jpg') }}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes
                                </h1>
                                <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                                    stet
                                    amet amet ndiam elitr ipsum diam</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <section class="section-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-3">
            <div class="container">
                <div class="section-title">
                    <h2>Categories</h2>
                </div>
                <div class="row pb-3">
                    @if (getCategories()->isNotEmpty())
                        @foreach (getCategories() as $category)
                            <div class="col-lg-3">
                                <div class="cat-card">
                                    <div class="left" style="width: 200px; height: 150px; overflow: hidden;">
                                        <img src="{{ $category->image_path }}" alt="" class="img-fluid"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="right">
                                        <div class="cat-data">
                                            <h2>{{ $category->name }}</h2>
                                            @if ($category->products_count)
                                                <p>{{ $category->products_count }} Products</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </section>

        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Featured Products</h2>
                </div>
                <div class="row pb-3">
                    @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                            <div class="col-md-3">

                                @include('front.parts.item')

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Latest Produsts</h2>
                </div>
                <div class="row pb-3">

                    @if ($latestProduct->isNotEmpty())
                        @foreach ($latestProduct as $product)
                            <div class="col-md-3">
                                @include('front.parts.item')
                            </div>
                        @endforeach
                    @endif


                </div>
            </div>
        </section>
    </main>


</x-front.layout>
