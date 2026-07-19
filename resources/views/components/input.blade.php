@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'autocomplete' => null
])

@if($label)
    <label for="{{ $name }}" class="form-label fw-semibold text-gray-700 mb-1">
        {{ $label }} @if($required)<span class="text-danger">*</span>@endif
    </label>
@endif

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    autocomplete="{{ $autocomplete }}"
    aria-label="{{ $label ?? $placeholder }}"
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
>

@error($name)
    <div class="invalid-feedback">
        <strong>{{ $message }}</strong>
    </div>
@enderror
