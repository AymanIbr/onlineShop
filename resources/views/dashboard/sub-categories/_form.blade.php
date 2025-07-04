<div class="row">
    <div class="mb-3 col-md-6">
        <x-form.input type="text" name="name" :oldval="$subCategory->name" placeholder="Name" />
        <div id="name_error" class="invalid-feedback"></div>

        <div class="mb-3 mt-3">
            <x-form.select label="Category" name="category_id" :oldval="$subCategory->category_id" placeholder="Select Category"
                :options="$categories" />
            <div id="category_id_error" class="invalid-feedback"></div>

        </div>


        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($subCategory->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div id="status_error" class="invalid-feedback d-block"></div>
        </div>

        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="show_home" id="show_home"
                    @if ($subCategory->show_home) checked @endif>
                <label class="custom-control-label" for="show_home">Show on Home</label>
            </div>
            <div id="show_home_error" class="invalid-feedback d-block"></div>
        </div>



    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label class="d-block" for="image">
                <img class="img-thumbnail prev-img"
                    style="width: 80%; height: 300px; cursor: pointer; object-fit: cover"
                    {{-- src="{{ $subCategory->id ? asset('storage/' . $subCategory->image->path) : asset('backend/img/prev.jpg') }}" --}}
                    src="{{ $subCategory->image_path }}"
                    alt="category Image">
            </label>
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div id="image_error" class="invalid-feedback d-block"></div>

            <div class="d-none">
                <x-form.file name="image" :oldimage="$subCategory->image->path ?? null" />
            </div>
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
    </script>
@endpush
