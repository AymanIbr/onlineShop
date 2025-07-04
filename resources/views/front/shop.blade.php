<x-front.layout title="Shop">

    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{ route('site.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Shop</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-6 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <div class="sub-title">
                            <h2>Categories</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="accordion accordion-flush" id="accordionExample">

                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{ $category->id }}">
                                                    @if ($category->sub_categories->isNotEmpty())
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $category->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </button>
                                                    @else
                                                        <a href="{{ route('site.shop', $category->slug) }}"
                                                            style="font-size: 18px;"
                                                            class="nav-item nav-link {{ $categorySlug == $category->slug ? 'text-primary' : '' }}">{{ $category->name }}</a>
                                                    @endif
                                                </h2>
                                                @if ($category->sub_categories->isNotEmpty())
                                                    <div id="collapse{{ $category->id }}"
                                                        class="accordion-collapse collapse {{ $categorySlug == $category->slug ? 'show' : '' }}"
                                                        aria-labelledby="heading{{ $category->id }}"
                                                        data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                @foreach ($category->sub_categories as $SubCategory)
                                                                    <a href="{{ route('site.shop', [$category->slug, $SubCategory->slug]) }}"
                                                                        class="nav-item nav-link {{ $subCategorySlug == $SubCategory->slug ? 'text-primary' : '' }}">{{ $SubCategory->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Brand</h3>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                @php
                                    $brandNames = request()->query('brands');
                                    $selectedBrands = $brandNames ? explode(',', $brandNames) : [];
                                    $selectedBrands = array_map('trim', $selectedBrands);
                                @endphp
                                @if ($brands->isNotEmpty())
                                    @foreach ($brands as $brand)
                                        <div class="form-check mb-2">
                                            <input @if (in_array(trim($brand->name), $selectedBrands)) checked @endif
                                                class="form-check-input brand-label" name="brand[]" type="checkbox"
                                                value="{{ $brand->name }}" id="brand-{{ $brand->id }}">
                                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

                        <div class="sub-title mt-5">
                            <h2>Price</h3>
                        </div>
                        {{-- http://ionden.com/a/plugins/ion.rangeSlider/start.html --}}
                        <div class="card">
                            <div class="card-body">
                                <input type="text" class="js-range-slider" name="my_range" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row pb-3">
                            <div class="col-12 pb-1">
                                <div class="d-flex align-items-center justify-content-end mb-4">
                                    <div class="ml-2">
                                        <select name="sort" id="sort" class="form-control">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Latest</option>
                                            <option value="price_desc"
                                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High
                                            </option>
                                            <option value="price_asc"
                                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                    <div class="col-md-4">
                                        @include('front.parts.item')
                                    </div>
                                @endforeach
                            @endif


                            <div class="col-md-12 pt-5">
                                {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-custom') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>


    @push('js')
        <script>
            // Slider

            rangeSlider = $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: 0,
                max: 1000,
                from: {{ $priceMin }},
                step: 10,
                to: {{ $priceMax }},
                skin: "round",
                max_postfix: "+",
                prefix: "$",
                onFinish: function() {
                    apply_filters();
                }
            });

            var slider = $(".js-range-slider").data("ionRangeSlider");

            $("#sort").change(function() {
                apply_filters();
            });

            $(".brand-label").change(function() {
                apply_filters();
            });

            function apply_filters() {
                let selectedBrands = [];
                $(".brand-label:checked").each(function() {
                    if ($(this).is(":checked") == true) {
                        selectedBrands.push($(this).val());
                    }
                });

                let url = '{{ url()->current() }}';
                let params = [];

                const priceMin = slider.result.from;
                const priceMax = slider.result.to;
                // slider
                if (priceMin !== 0 || priceMax !== 1000) {
                    params.push("price_min=" + priceMin);
                    params.push("price_max=" + priceMax);
                }

                if (selectedBrands.length > 0) {
                    params.push("brands=" + selectedBrands.join(","));
                }

                // Sorting filter
                const sortValue = $("#sort").val();
                if (sortValue) {
                    params.push("sort=" + sortValue);
                }

                if (params.length > 0) {
                    url += "?" + params.join("&");
                }
                window.location.href = url;
            }
        </script>
    @endpush


</x-front.layout>
