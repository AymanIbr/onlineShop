<div class="row">
    {{-- Name --}}
    <div class="mb-3 col-md-6">
        <x-form.input label="Name" type="text" name="name" :oldval="$user->name ?? ''" placeholder="Enter full name" />
        <div id="name_error" class="invalid-feedback d-block"></div>
    </div>

    {{-- Email --}}
    <div class="mb-3 col-md-6">
        <x-form.input label="Email" type="email" name="email" :oldval="$user->email ?? ''" placeholder="Enter email address" />
        <div id="email_error" class="invalid-feedback d-block"></div>
    </div>

    {{-- Phone --}}
    <div class="mb-3 col-md-6">
        <x-form.input label="Phone" type="text" name="phone" :oldval="$user->phone ?? ''" placeholder="Enter phone number" />
        <div id="phone_error" class="invalid-feedback d-block"></div>
    </div>

    {{-- Address --}}
    <div class="mb-3 col-md-6">
        <x-form.input label="Address" type="text" name="address" :oldval="$user->address ?? ''" placeholder="Enter address" />
        <div id="address_error" class="invalid-feedback d-block"></div>
    </div>

    {{-- Status Switch --}}
        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($user->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
            <div id="active_error" class="invalid-feedback d-block"></div>
        </div>
