<div class="mb-3">
    <label for="country" class="form-label">Country</label>
    <select name="country" id="country" class="form-control">
        <option value="">Select a Country</option>
        @foreach ($countries as $code => $name)
            <option value="{{ $code }}"
                {{ old('country', $shipping->country ?? '') == $code ? 'selected' : '' }}>
                {{ $name }}
            </option>
        @endforeach
    </select>
    <div id="country_error" class="invalid-feedback"></div>
</div>

<div class="mb-3">
    <x-form.input type="number" label="Amount" name="amount" :value="old('amount', $shipping->amount)" placeholder="Enter amount" />
    <div id="amount_error" class="invalid-feedback"></div>
</div>
