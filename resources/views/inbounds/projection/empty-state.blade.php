{{-- =============================================================
     EMPTY STATE PARTIAL
     Include ke: inbounds/projection/index.blade.php
     Tampil saat: $projections->isEmpty()
     ============================================================= --}}

<div class="proj-empty-state">

    {{-- Animated Icon --}}
    <div class="proj-empty-icon">
        <i class="fas fa-chart-line"></i>
    </div>

    {{-- Title --}}
    <p class="proj-empty-title">No projection data available.</p>

    {{-- Subtitle --}}
    <p class="proj-empty-sub">Import your first projection file.</p>

    {{-- CTA Button --}}
    <button
        type="button"
        class="btn-proj btn-proj-yellow"
        data-toggle="modal"
        data-target="#importProjectionModal"
        style="gap: 10px;"
    >
        <i class="fas fa-upload"></i>
        Import Projection
    </button>

</div>
