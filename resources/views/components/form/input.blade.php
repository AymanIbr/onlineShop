@props(['label' => '', 'name' => '', 'placeholder' => '', 'oldval' => '', 'type' => 'text'])


@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif

{{-- @php
    $inputClass = 'form-control';
    if ($errors->has($name)) {
        $inputClass .= ' is-invalid';
    }
@endphp --}}

<input type="{{ $type }}" id="{{ $name }}"
    name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes->class(['form-control', 'is-invalid'=>$errors->has($name)]) }} value="{{ old($name, $oldval) }}">
   {{-- name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $attributes->merge(['class' => $inputClass]) }} value="{{ old($name, $oldval) }}"> --}}
@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
