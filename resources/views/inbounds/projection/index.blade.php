@extends('layouts.app')

@section('title', 'Projection')

@push('styles')
{{-- Bootstrap 4 CSS (required for Bootstrap Modal) --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
{{-- Select2 CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endpush

@section('content')
    <!-- {{-- ============================================================
         FILTER CARD
    ============================================================ --}} -->
    <div class="proj-card">
        <div class="proj-card-header">
            <h5>
                <span class="card-icon"><i class="fas fa-filter"></i></span>
                Filter
            </h5>
        </div>
        <div class="proj-card-body">
            <form method="GET" action="{{ route('inbound.projection.index') }}" id="filterForm">
                <div class="filter-row">

                    {{-- Filter Left: Station Select --}}
                    <div class="filter-left">
                        <div class="form-group-proj">
                            <label for="station_filter">
                                <i class="fas fa-map-marker-alt mr-1"></i> Station
                            </label>
                            <select
                                id="station_filter"
                                name="station_id"
                                class="select2-projection"
                                style="width: 100%;"
                            >
                                <option value="">Semua Station</option>
                                @foreach($stations as $station)
                                    <option
                                        value="{{ $station->id }}"
                                        {{ request('station_id') == $station->id ? 'selected' : '' }}
                                    >
                                        {{ $station->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Filter Right: Action Buttons --}}
                    <div class="filter-right">
                        {{-- Download Template --}}
                        <a
                            href="{{ route('inbound.projection.template') }}"
                            class="btn-proj btn-proj-outline"
                            title="Download Template Excel"
                        >
                            <i class="fas fa-download"></i>
                            Download Template
                        </a>

                        {{-- Import Projection --}}
                        <button
                            type="button"
                            class="btn-proj btn-proj-yellow"
                            data-toggle="modal"
                            data-target="#importProjectionModal"
                            title="Import Projection dari Excel"
                        >
                            <i class="fas fa-upload"></i>
                            Import Projection
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================
         PROJECTION LIST CARD
    ============================================================ --}}
    <div class="proj-card">
        <div class="proj-card-header">
            <h5>
                <span class="card-icon"><i class="fas fa-table"></i></span>
                Projection List
            </h5>
            <span style="font-size: 0.8rem; font-weight: 700; color: var(--color-gray-600);">
                <i class="fas fa-database mr-1"></i>
                @if($projections->isEmpty())
                    0 Records
                @else
                    {{ $projections->total() }} Records
                @endif
            </span>
        </div>
        <div class="proj-card-body" style="padding: 0;">

            @if($projections->isEmpty())

                {{-- ===== EMPTY STATE ===== --}}
                @include('inbounds.projection.empty-state')

            @else

                {{-- ===== PROJECTION TABLE ===== --}}
                @include('inbounds.projection.projection-table')

            @endif

        </div>
    </div>

    {{-- ============================================================
         IMPORT MODAL
    ============================================================ --}}
    @include('inbounds.projection.import-modal')

@endsection

@push('scripts')
{{-- jQuery (required for Bootstrap 4 modals and Select2) --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
{{-- Bootstrap 4 JS Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Select2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- Projection Specific Script --}}
@vite('resources/js/projection.js')
@endpush
