@props([
    'name' => '',
    'id' => null,
    'required' => false,
    'searchable' => false
])

<select
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    aria-label="{{ $name }}"
    @if($searchable) data-search="true" @endif
    {{ $required ? 'required' : '' }}
    {{ $attributes->merge(['class' => 'form-select ' . ($errors->has($name) ? 'is-invalid' : '')]) }}
>
    {{ $slot }}
</select>

@error($name)
    <div class="invalid-feedback d-block">
        <strong>{{ $message }}</strong>
    </div>
@enderror

@if($searchable)
<!-- Script inisialisasi select searchable menggunakan standard library pilihan (misal: TomSelect atau SlimSelect) -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectEl = document.getElementById('{{ $id ?? $name }}');
        if (selectEl && typeof SlimSelect !== 'undefined') {
            new SlimSelect({
                select: selectEl,
                settings: {
                    placeholderText: selectEl.getAttribute('placeholder') || 'Pilih Opsi',
                    searchPlaceholder: 'Cari...',
                }
            });
        }
    });
</script>
@endpush
@endif
