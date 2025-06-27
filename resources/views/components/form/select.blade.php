@props(['label' => '', 'name' => '', 'placeholder' => '', 'oldval' => '', 'options' => []])

@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

<select id="{{ $name }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror">
    @if ($placeholder)
        <option style="font-weight: bold" value="" selected>{{ $placeholder }}</option>
    @endif
    @foreach ($options as $option)
        <option value="{{ $option->id }}" @if (old($name, $oldval) == $option->id) selected @endif>{{ $option->trans_name }}
        </option>
    @endforeach
</select>
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
