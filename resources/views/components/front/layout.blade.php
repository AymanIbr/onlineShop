<!DOCTYPE html>
<html class="no-js" lang="en_AU" />

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $title ?? 'Home' }} - {{ config('app.name') }}</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />

    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/ion.rangeSlider.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/slick-theme.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/video-js.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/style.css') . '?v=' . rand(111, 999) }}" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    @stack('css')

    {{-- <style>
        .wishlist,
        .wishlist i {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #aaa;
            font-size: 20px;
            transition: color 0.3s;
        }

        .wishlist.active i {
            color: red;
        }
    </style> --}}

</head>

<body data-instant-intensity="mousedown">
    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">

                <div class="col-lg-4 logo">
                    <a href="{{ route('site.index') }}" class="text-decoration-none">
                        <span class="h1 text-uppercase text-primary bg-dark px-2">Online</span>
                        <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">SHOP</span>
                    </a>
                </div>

                <div class="col-lg-6 col-6 text-left d-flex justify-content-end align-items-center gap-3">

                    @guest('web')
                        @if (!request()->routeIs('login'))
                            <a href="{{ route('login') }}" class="btn btn-dark border-width-2 d-none d-lg-inline-block">
                                <span class="mr-2 icon-lock_outline"></span>Log In
                            </a>
                        @endif

                        @if (!request()->routeIs('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark border-width-2 d-none d-lg-inline-block">
                                <span class="mr-2 icon-lock_outline"></span>Register
                            </a>
                        @endif
                    @endguest

                    @auth('web')
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" role="button" id="userMenu"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::guard('web')->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user"></i>
                                        My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('my.order') }}"><i
                                            class="fas fa-shopping-bag"></i> My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('site.wishlist.index') }}"><i
                                            class="fas fa-heart"></i>
                                        Wishlist</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth


                    <!-- Search Form -->
                    <form action="{{ route('site.shop') }}" method="get" class="d-flex ms-3">
                        {{-- @csrf --}}
                        <div class="input-group">
                            <input type="text" name="search" value="{{ Request::get('search') }}"
                                placeholder="Search For Products" class="form-control" aria-label="Search">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>


                    <!-- Hidden Logout Form -->
                    {{-- <form action="{{ route('logout') }}" method="POST" id="logout" style="display: none;">
                        @csrf
                    </form> --}}

                </div>

            </div>
        </div>
    </div>

    <header class="bg-dark">
        <div class="container">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <a href="index.php" class="text-decoration-none mobile-logo">
                    <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                    <span class="h2 text-uppercase text-white px-2">SHOP</span>
                </a>
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        </li> -->

                        @if (getCategories()->isNotEmpty())
                            @foreach (getCategories() as $category)
                                <li class="nav-item dropdown">
                                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        {{ $category->name }}
                                    </button>

                                    @if ($category->sub_categories->isNotEmpty())
                                        <ul class="dropdown-menu dropdown-menu-dark">

                                            @foreach ($category->sub_categories as $SubCategory)
                                                <li><a class="dropdown-item nav-link"
                                                        href="{{ route('site.shop', [$category->slug, $SubCategory->slug]) }}">{{ $SubCategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
                <div class="right-nav py-0">
                    <a href="{{ route('site.carts.index') }}" class="ml-3 d-flex pt-2">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>
            </nav>
        </div>
    </header>


    {{ $slot }}


    <footer class="bg-dark mt-5">
        <div class="container pb-5 pt-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>Get In Touch</h3>
                        <p>No dolore ipsum accusam no lorem. <br>
                            123 Street, New York, USA <br>
                            exampl@example.com <br>
                            000 000 0000</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>Important Links</h3>
                        <ul>

                            @if (staticPages()->isNotEmpty())
                                @foreach (staticPages() as $page)
                                    <li><a href="{{ route('page',$page->slug) }}" title="{{ $page->name }}">{{ $page->name }}</a></li>
                                @endforeach

                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-card">
                        <h3>My Account</h3>
                        <ul>
                            <li><a href="{{ route('login') }}" title="Sell">Login</a></li>
                            <li><a href="{{ route('register') }}" title="Advertise">Register</a></li>
                            <li><a href="{{ route('my.order') }}" title="Contact Us">My Orders</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="copy-right text-center">
                            <p>© Copyright 2022 Amazing Shop. All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        window.onscroll = function() {
            myFunction()
        };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        // cart

        $('.add-to-cart').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: '/carts',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                    quantity: 1,
                },
                success: (response) => {
                    Swal.fire({
                        title: "Item Added!",
                        text: response.message,
                        icon: "success",
                        draggable: true
                    });
                }
            })

        });


        // wishlist
        $('.add-to-wishlist').click(function() {
            let button = $(this);
            let id = button.data('id');

            if (button.hasClass('active')) {
                Swal.fire({
                    title: "Already in Wishlist!",
                    text: "This product is already in your wishlist.",
                    icon: "info",
                    draggable: true
                });
                return;
            }

            $.ajax({
                url: '/wishlist',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: id,
                },
                success: (response) => {

                    button.addClass('active');
                    button.find('i').removeClass('far').addClass('fas');

                    Swal.fire({
                        title: "Added to Wishlist!",
                        text: response.message,
                        icon: "success",
                        draggable: true
                    });
                },
                error: (xhr) => {
                    Swal.fire({
                        title: "Oops!",
                        text: xhr.responseJSON?.message || "Failed to add to wishlist.",
                        icon: "error",
                        draggable: true
                    });
                }
            });
        });
    </script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('js')
</body>

</html>
