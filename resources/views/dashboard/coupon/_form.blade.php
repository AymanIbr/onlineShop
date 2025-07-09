<div class="row">
    <div class="col-md-10">
        <div class="mb-3">
            <x-form.input label="Coupon Code" name="code" :oldval="$coupon->code" placeholder="e.g. SAVE20" />
            <div id="code_error" class="invalid-feedback"></div>
        </div>

        <div class="mb-3">
            <x-form.input label="Coupon Name" :oldval="$coupon->name" name="name" placeholder="Optional coupon name" />
        </div>

        <div class="mb-3">
            <x-form.area label="Description" :oldval="$coupon->description" name="description"
                placeholder="Short description of the coupon" />
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" :oldval="$coupon->max_uses" label="Max Uses (Total)" name="max_uses"
                        placeholder="e.g. 100" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" :oldval="$coupon->max_uses_user" label="Max Uses Per User" name="max_uses_user"
                        placeholder="e.g. 1" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="type" class="form-label">Discount Type</label>
                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                        <option value=""> Select Discount Type </option>
                        <option value="percent" {{ old('type', $coupon->type ?? '') == 'percent' ? 'selected' : '' }}>
                            Percentage
                        </option>
                        <option value="fixed" {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>
                            Fixed Amount
                        </option>
                    </select>
                    <div id="type_error" class="invalid-feedback"></div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="number" :oldval="$coupon->discount_amount" step="0.01" label="Discount Amount"
                        name="discount_amount" placeholder="e.g. 10 or 25.5" />
                    <div id="discount_amount_error" class="invalid-feedback"></div>

                </div>
            </div>
        </div>

        <div class="mb-3">
            <x-form.input type="number" step="0.01" :oldval="$coupon->min_amount" label="Minimum Cart Amount (Optional)"
                name="min_amount" placeholder="e.g. 50" />
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="datetime-local" :oldval="$coupon->starts_at" label="Starts At" name="starts_at" />
                    <div id="starts_at_error" class="invalid-feedback"></div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <x-form.input type="datetime-local" :oldval="$coupon->expires_at" label="Expires At" name="expires_at" />
                    <div id="expires_at_error" class="invalid-feedback"></div>

                </div>
            </div>
        </div>

        <div class="form-group mt-4">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" name="active" id="active"
                    @if ($coupon->active) checked @endif>
                <label class="custom-control-label" for="active">Active</label>
            </div>
        </div>
