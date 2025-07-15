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
                        <div class="bg-light right p-3">
                            <h1>{{ $product->title }}</h1>
                            <div class="d-flex mb-3 align-items-center">
                                <div class="star-rating product mt-2" title="">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>

                                        <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <small class="pt-2 ps-1 product-rating-count">
                                    ({{ $product->ratings_count > 1 ? $product->ratings_count . ' Reviews' : $product->ratings_count . ' Review' }})
                                </small>
                            </div>

                            <h2 class="price text-secondary"><del>${{ $product->compare_price }}</del></h2>
                            <h2 class="price">${{ $product->price }}</h2>

                            <p>{!! \Illuminate\Support\Str::words(strip_tags($product->description), 10, '...') !!}</p>

                            @if ($product->track_qty == 1)
                                @if ($product->quantity > 0)
                                    <button type="button" class="btn btn-dark add-to-cart"
                                        data-id="{{ $product->id }}">
                                        <i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART
                                    </button>
                                @else
                                    <button type="button" class="btn btn-dark" disabled>Out Of Stock</button>
                                @endif
                            @else
                                <button type="button" class="btn btn-dark add-to-cart" data-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-light p-4">
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
                                        data-bs-target="#reviews" type="button" role="tab"
                                        aria-controls="reviews" aria-selected="false">Reviews</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <p>{!! $product->description !!}</p>
                                </div>

                                <div class="tab-pane fade" id="shipping" role="tabpanel"
                                    aria-labelledby="shipping-tab">
                                    <p>{!! $product->shipping_returns !!}</p>
                                </div>

                                <div class="tab-pane fade" id="reviews" role="tabpanel"
                                    aria-labelledby="reviews-tab">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <form id="ratingForm" name="ratingForm" method="POST"
                                                action="javascript:void(0)">
                                                <h3 class="h4 pb-3">Write a Review</h3>
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                <div class="row">
                                                    <div class="form-group col-md-6 mb-3">
                                                        <label for="username">User Name</label>
                                                        <input type="text" class="form-control" name="username"
                                                            id="username" placeholder="username">
                                                        <div id="username_error" class="invalid-feedback"></div>
                                                    </div>

                                                    <div class="form-group col-md-6 mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="text" class="form-control" name="email"
                                                            id="email" placeholder="Email">
                                                        <div id="email_error" class="invalid-feedback"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="rating">Rating</label><br>
                                                    <div class="rating" style="width: 10rem;">
                                                        <input id="rating-5" type="radio" name="rating"
                                                            value="5" />
                                                        <label for="rating-5"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-4" type="radio" name="rating"
                                                            value="4" />
                                                        <label for="rating-4"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-3" type="radio" name="rating"
                                                            value="3" />
                                                        <label for="rating-3"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-2" type="radio" name="rating"
                                                            value="2" />
                                                        <label for="rating-2"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-1" type="radio" name="rating"
                                                            value="1" />
                                                        <label for="rating-1"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                    </div>
                                                    <div id="rating_error" class="invalid-feedback d-block"></div>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="comment">How was your overall experience?</label>
                                                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="5"
                                                        placeholder="How was your overall experience?"></textarea>
                                                    <div id="comment_error" class="invalid-feedback"></div>
                                                </div>

                                                <div>
                                                    <button type="submit" id="submit"
                                                        class="btn btn-dark">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-5">
                                        <div class="overall-rating mb-3">
                                            <div class="d-flex align-items-center">
                                                <h1 class="h3 pe-3 average-rating-value">{{ $avgRating }}</h1>
                                                <div class="star-rating mt-2" title="">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-2 ps-2 overall-rating-count">
                                                    ({{ $product->ratings_count > 1 ? $product->ratings_count . ' Reviews' : $product->ratings_count . ' Review' }})
                                                </div>
                                            </div>
                                        </div>

                                        <div class="reviews-list mt-4">
                                            @if ($product->ratings->isNotEmpty())
                                                @foreach ($product->ratings as $rating)
                                                    @php
                                                        $ratingPer = ($rating->rating * 100) / 5;
                                                    @endphp
                                                    <div class="rating-group mb-4">
                                                        <span><strong>{{ $rating->username }}</strong></span>
                                                        <div class="star-rating mt-2" title="">
                                                            <div class="back-stars">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                                <div class="front-stars"
                                                                    style="width: {{ $ratingPer }}%">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="my-3">
                                                            <p>{{ $rating->comment }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
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

    @push('js')
        <script>
            $('#ratingForm').submit(function(event) {
                event.preventDefault();

                let formData = new FormData(this);
                $("#submit").prop("disabled", true);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('site.rating.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#submit").prop("disabled", false);
                        toastr.success(response.message || 'Rating successfully');
                        $('#ratingForm')[0].reset();
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        let rating = response.rating;
                        let ratingPercent = (rating.rating * 100) / 5;

                        let newRatingHtml = `
        <div class="rating-group mb-4">
            <span><strong>${rating.username}</strong></span>
            <div class="star-rating mt-2" title="">
                <div class="back-stars">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>

                    <div class="front-stars" style="width: ${ratingPercent}%">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="my-3">
                <p>${rating.comment}</p>
            </div>
        </div>
    `;
                        $('.reviews-list').append(newRatingHtml);

                        let ratingsCount = response.ratings_count;
                        let ratingsCountText = `${ratingsCount} ${ratingsCount > 1 ? 'Reviews' : 'Review'}`;

                        $('.overall-rating-count').text(`(${ratingsCountText})`);
                        $('.product-rating-count').text(`(${ratingsCountText})`);
                        $('.average-rating-value').text(parseFloat(response.ratings_rating).toFixed(1));

                        $('.overall-rating .front-stars').css('width', (response.ratings_rating * 100 / 5) +
                            '%');
                        let avgRatingPercent = (response.ratings_rating * 100) / 5;
                        $('.star-rating.product .front-stars').css('width', avgRatingPercent + '%');
                    },
                    error: function(xhr) {
                        $("#submit").prop("disabled", false);
                        if (xhr.status === 422) {
                            let response = xhr.responseJSON;

                            if (response.errors) {
                                let errors = response.errors;

                                if (errors.username) {
                                    $('#username').addClass('is-invalid');
                                    $('#username_error').text(errors.username[0]);
                                } else {
                                    $('#username').removeClass('is-invalid');
                                    $('#username_error').text('');
                                }

                                if (errors.email) {
                                    $('#email').addClass('is-invalid');
                                    $('#email_error').text(errors.email[0]);
                                } else {
                                    $('#email').removeClass('is-invalid');
                                    $('#email_error').text('');
                                }

                                if (errors.comment) {
                                    $('#comment').addClass('is-invalid');
                                    $('#comment_error').text(errors.comment[0]);
                                } else {
                                    $('#comment').removeClass('is-invalid');
                                    $('#comment_error').text('');
                                }

                                if (errors.rating) {
                                    $('#rating_error').addClass('is-invalid').text(errors.rating[0]);
                                } else {
                                    $('#rating_error').removeClass('is-invalid').text('');
                                }
                            } else if (response.message) {
                                toastr.error(response.message);
                            }
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
