@props([
    'type' => 'info',
    'message' => ''
])

@php
    $icons = [
        'success' => 'bi-check-circle-fill',
        'danger' => 'bi-exclamation-triangle-fill',
        'warning' => 'bi-exclamation-circle-fill',
        'info' => 'bi-info-circle-fill'
    ];
    $icon = $icons[$type] ?? 'bi-info-circle-fill';
@endphp

<div class="alert alert-{{ $type }} alert-dismissible fade show d-flex align-items-center rounded-3 p-3 mb-4" role="alert" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <i class="bi {{ $icon }} me-3" style="font-size: 1.25rem;"></i>
    <div class="small fw-semibold">
        {{ $message }}
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.75rem;"></button>
</div>
