@props(['label' => '', 'name' => '', 'oldimage' => '', 'can_delete' => false])


@if ($label)
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
@endif


<input type="file" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
    name="{{ $name }}" {{ $attributes }}>

@if ($oldimage)
    <div class="position-relative d-inline-block">
        @if ($can_delete)
            <div id="del_site_image">x</div>
        @endif
        <img width="100" class="img-thumbnail mt-1" src="{{ asset($oldimage) }}" alt="">
    </div>
@endif


@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror



@push('css')
    <style>
        #del_site_image {
            position: absolute;
            width: 20px;
            height: 20px;
            font-size: 12px;
            top: 5px;
            right: 5px;
            background-color: #f00;
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: ease all .3s;
        }

        .position-relative:hover #del_site_image {
            opacity: 1;
            visibility: visible;
        }
    </style>
@endpush
