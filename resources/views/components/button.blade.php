@props([
    'type' => 'submit'
])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn btn-primary-sb py-2.5 fw-bold']) }}
>
    {{ $slot }}
</button>
