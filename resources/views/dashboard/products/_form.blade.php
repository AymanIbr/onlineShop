<div class="row">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <x-form.input label="Title" name="title" :oldval="$product->title" placeholder="Enter product Title" />
                    <div id="title_error" class="invalid-feedback"></div>

                </div>
            </div>

        </div>


        <div class="row">
            <!-- English Name -->
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" label="Price" name="price" :oldval="$product->price"
                        placeholder="Enter product price" />
                    <div id="price_error" class="invalid-feedback"></div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" label="Compare Price" name="compare_price" :oldval="$product->compare_price"
                        placeholder="Enter product Compare Price" />
                    <div id="compare_price_error" class="invalid-feedback d-block"></div>

                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Category -->
                <div class="mb-3">
                    <x-form.select label="Category" name="category_id" :oldval="$product->category_id" placeholder="Select Category"
                        :options="$categories" />
                    <div id="category_id_error" class="invalid-feedback"></div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.select label="Sub Category" name="sub_category_id" :oldval="$product->sub_category_id"
                        placeholder="Select SubCategory" :options="$subCategory" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Category -->
                <div class="mb-3">
                    <x-form.select label="Brand" name="brand_id" :oldval="$product->brand_id" placeholder="Select Brand"
                        :options="$brands" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" label="Quantity" name="quantity" :oldval="$product->quantity"
                        placeholder="Enter product quantity" />
                    <div id="quantity_error" class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input label="SKU" name="sku" :oldval="$product->sku" placeholder="Enter SKU" />
                    <div id="sku_error" class="invalid-feedback"></div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input label="Barcode" name="barcode" :oldval="$product->barcode" placeholder="Enter Barcode" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Gallery -->
                <div class="mb-3">
                    <x-form.file label="Gallery" name="gallery[]" multiple />
                    @error('gallery')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @if ($product->gallery)
                        <div class="gallery-wrapper">
                            @foreach ($product->gallery as $item)
                                <div>
                                    <img class="gallery-image img-thumbnail mt-1"
                                        src="{{ asset('storage/' . $item->path) }}" alt="">
                                    <span onclick="delImg(event, {{ $item->id }})">x</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Content -->
                <div class="mb-3">
                    <x-form.area label="Description" id="description" name="description"
                        placeholder="Enter Product description" :oldval="$product->description" :tiny=false />
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-3">
        <!-- Image Upload and Preview -->
        <div class="mb-3">
            <label class="d-block" for="image">
                <img class="img-thumbnail prev-img"
                    style="width: 100%; height: 300px; cursor: pointer; object-fit: cover"
                    src="{{ $product->id ? asset('storage/' . $product->image->path) : asset('backend/img/prev.jpg') }}"
                    alt="Product Image">
            </label>
            <div id="image_error" class="invalid-feedback d-block"></div>
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div class="d-none">
                <x-form.file name="image" :oldimage="$product->image->path ?? null" />
            </div>
        </div>


        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_featured">Featured Product</label>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($product->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div id="status_error" class="invalid-feedback d-block"></div>
        </div>

        <div class="form-group">
            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" name="track_qty" id="track_qty"
                    @if ($product->track_qty) checked @endif>
                <label class="custom-control-label" for="track_qty">Track Quantity</label>
            </div>
            <div id="track_qty_error" class="invalid-feedback d-block"></div>
        </div>

    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#image').on('change', function() {
                let file = this.files[0];
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.prev-img').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            })
        });

        function delImg(e, id) {
            const url = "{{ route('delete_img', ':id') }}".replace(':id', id);

            $.ajax({
                type: 'get',
                url: url,
                success: (res) => {
                    if (res) {
                        e.target.closest('div').remove();
                    }
                },
                error: (err) => {
                    console.log(err);
                }
            })
        }
    </script>

    @push('css')
        <style>
            .gallery-image {
                width: 80px;
                height: 100px;
                object-fit: cover;
            }

            .gallery-wrapper {
                display: flex;
            }

            .gallery-wrapper div {
                position: relative;
            }

            .gallery-wrapper div span {
                position: absolute;
                width: 15px;
                height: 15px;
                top: 5px;
                right: 5px;
                background: #ff8282;
                display: flex;
                justify-content: center;
                align-items: center;
                color: white;
                border-radius: 50%;
                cursor: pointer;
                opacity: 0;
                visibility: hidden;
                transition: all .3s ease;
            }

            .gallery-wrapper div:hover span {
                opacity: 1;
                visibility: visible;
            }

            .gallery-wrapper div span:hover {
                background: #f00;
            }
        </style>
    @endpush
@endpush
