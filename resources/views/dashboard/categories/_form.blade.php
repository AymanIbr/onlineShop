<div class="row">
    <div class="mb-3 col-md-6">
        <x-form.input type="text" name="name" :oldval="$category->name" placeholder="Name" />
        <div id="name_error" class="invalid-feedback"></div>

        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($category->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div id="status_error" class="invalid-feedback d-block"></div>
        </div>

        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="show_home" id="show_home"
                    @if ($category->show_home) checked @endif>
                <label class="custom-control-label" for="show_home">Show on Home</label>
            </div>
            <div id="show_home_error" class="invalid-feedback d-block"></div>
        </div>

    </div>

    <div class="col-md-6">
        {{-- <div class="mb-3">
            <form action="{{ route('admin.categories.upload') }}" class="dropzone" id="image-dropzone">
                @csrf
            </form>
            <input type="hidden" name="image_path" id="image_path">
            <div id="image_error" class="invalid-feedback d-block"></div>
        </div> --}}
        <!-- Image Upload and Preview -->
        <div class="mb-3">
            <label class="d-block" for="image">
                <img class="img-thumbnail prev-img"
                    style="width: 80%; height: 300px; cursor: pointer; object-fit: cover" {{-- $post->image ? $post->image --}}
                    {{-- src="{{ $category->id ? asset('storage/' . $category->image->path) : asset('backend/img/prev.jpg') }}" --}} src="{{ $category->image_path }}" alt="category Image">
            </label>
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div id="image_error" class="invalid-feedback d-block"></div>

            <div class="d-none">
                <x-form.file name="image" :oldimage="$category->image->path ?? null" />
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
