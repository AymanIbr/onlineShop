    <div class="mb-3">
        <x-form.input type="text" name="name" :oldval="$page->name" placeholder="Name" />
        <div id="name_error" class="invalid-feedback"></div>
    </div>

    <div class="mb-3">
        <x-form.area label="Content" id="content" name="content" placeholder="Enter Content page" :oldval="$page->content"
            :tiny="true" />
    </div>

    <div class="form-group mt-4">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" name="active" id="active"
                @if ($page->active) checked @endif>
            <label class="custom-control-label" for="active">Active</label>
        </div>
    </div>
