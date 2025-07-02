    <div class="mb-3">
        <x-form.input type="text" name="name" :oldval="$brand->name" placeholder="Name" />
        <div id="name_error" class="invalid-feedback"></div>
    </div>


          <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($brand->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div id="status_error" class="invalid-feedback d-block"></div>
        </div>
