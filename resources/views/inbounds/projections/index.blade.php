@extends('layouts.index')

@push('styles')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.25rem + 2px);
            color: #6e707e;
            padding-left: .75rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.25rem + 2px);
        }

        .filter-card {
            background: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}

                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-times-circle mr-2"></i>
                {{ session('error') }}

                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">

            {{-- Header --}}
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Inbound Projection
                </h6>

                <button class="btn btn-success btn-sm"
                    data-toggle="modal"
                    data-target="#importModal">

                    <i class="fas fa-file-upload mr-1"></i>
                    Import Data

                </button>
            </div>

            {{-- Filter --}}
            <div class="card-body filter-card">

                <form method="GET" action="{{ route('inbounds.projection') }}">

                    <div class="form-row">

                        <div class="form-group col-lg-3 col-md-6">
                            <label>Tanggal Mulai</label>
                            <input
                                type="date"
                                class="form-control"
                                name="start_date"
                                value="{{ request('start_date') }}">
                        </div>

                        <div class="form-group col-lg-3 col-md-6">
                            <label>Tanggal Selesai</label>
                            <input
                                type="date"
                                class="form-control"
                                name="end_date"
                                value="{{ request('end_date') }}">
                        </div>

                        <div class="form-group col-lg-4 col-md-8">
                            <label>Station</label>

                            <select
                                name="station_id"
                                class="form-control select2">

                                <option></option>

                                @foreach ($stations as $station)
                                    <option
                                        value="{{ $station->id }}"
                                        {{ request('station_id') == $station->id ? 'selected' : '' }}>

                                        {{ $station->name }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="form-group col-lg-2 col-md-4">

                            <label>&nbsp;</label>

                            <div class="d-flex">

                                <button
                                    type="submit"
                                    class="btn btn-primary flex-fill mr-2">

                                    <i class="fas fa-search mr-1"></i>
                                    Filter

                                </button>

                                <a
                                    href="{{ route('inbounds.projection') }}"
                                    class="btn btn-outline-secondary">

                                    <i class="fas fa-sync-alt"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            {{-- Table --}}
            <div class="card-body">

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-hover"
                        id="dataTable"
                        width="100%">

                        <thead class="thead-light">
                            <tr>
                                <th width="35%">Station</th>
                                <th width="25%">Date</th>
                                <th width="20%">Qty Projected</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)

                                <tr>

                                    <td>{{ $item->station->name }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}
                                    </td>

                                    <td>
                                        {{ number_format($item->qty_projected) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Tidak ada data.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- Modal Import --}}
    <div class="modal fade" id="importModal" tabindex="-1">

        <div class="modal-dialog">

            <form
                action="{{ route('inbound.projection.import') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Import Inbound Projection
                        </h5>

                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="form-group">

                            <label>Pilih File Excel</label>

                            <input
                                type="file"
                                name="file"
                                class="form-control"
                                accept=".xlsx,.xls,.csv"
                                required>

                            <small class="text-muted">
                                Format yang didukung: .xlsx, .xls, .csv
                            </small>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fas fa-upload mr-1"></i>
                            Upload

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        $('.select2').select2({
            placeholder: 'Semua Station',
            allowClear: true,
            width: '100%'
        });

    });
</script>
@endpush
