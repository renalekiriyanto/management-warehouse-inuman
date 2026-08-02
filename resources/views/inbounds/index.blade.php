@extends('layouts.index')

@section('title', 'Inbounds')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Inbounds</h1>
                <p class="text-muted small mb-0">Kelola data inbound stasiun</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addInboundModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inbound
            </button>
        </div>

        <!-- Filter Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('inbounds.index') }}" class="row g-2 align-items-end">
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-gray-700">Station</label>
                        <select name="station_id" class="form-control select2-station">
                            <option value="">Semua Station</option>
                            @foreach ($stations as $station)
                                <option value="{{ $station->id }}"
                                    {{ request('station_id') == $station->id ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-gray-700">Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Process</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-3 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('inbounds.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Inbound</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>No. Inbound</th>
                                <th>Tanggal</th>
                                <th>Station</th>
                                <th>Slot</th>
                                <th>ATA</th>
                                <th>Qty Order</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inbounds as $inbound)
                                <tr>
                                    <td class="font-weight-bold">{{ $inbound->no_inbound ?? '#' . $inbound->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inbound->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td>{{ $inbound->station->name ?? '-' }}</td>
                                    <td>{{ $inbound->slot }}</td>
                                    <td>{{ \Carbon\Carbon::parse($inbound->ata)->format('H:i') }}</td>
                                    <td>{{ $inbound->qty_order }}</td>
                                    <td>
                                        @php
                                            $statusBadge = match ($inbound->status) {
                                                'pending' => 'warning',
                                                'process' => 'info',
                                                'completed' => 'success',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span
                                            class="badge badge-{{ $statusBadge }}">{{ ucfirst($inbound->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                            data-target="#detailInboundModal" data-id="{{ $inbound->id }}"
                                            data-no="{{ $inbound->no_inbound ?? '#' . $inbound->id }}"
                                            data-tanggal="{{ \Carbon\Carbon::parse($inbound->tanggal)->translatedFormat('d M Y') }}"
                                            data-station="{{ $inbound->station->name ?? '-' }}"
                                            data-slot="{{ $inbound->slot }}"
                                            data-ata="{{ \Carbon\Carbon::parse($inbound->ata)->format('H:i') }}"
                                            data-qty="{{ $inbound->qty_order }}"
                                            data-status="{{ ucfirst($inbound->status) }}"
                                            data-catatan="{{ $inbound->catatan ?? '-' }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data inbound.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($inbounds instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $inbounds->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal: Tambah Inbound -->
        <div class="modal fade" id="addInboundModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('inbounds.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Tambah Inbound</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if ($isManager)
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Station <span
                                            class="text-danger">*</span></label>
                                    <select name="station_id" class="form-control @error('station_id') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>Pilih Station</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('station_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Station <span
                                            class="text-danger">*</span></label>
                                    <select name="station_id"
                                        class="form-control @error('station_id') is-invalid @enderror" required>
                                        <option value="{{ $user->station_id ?? null }}" selected>Pilih Station</option>
                                    </select>
                                </div>
                            @endif

                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">Tanggal <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-gray-700">Slot <span
                                            class="text-danger">*</span></label>
                                    <select name="slot" class="form-control @error('slot') is-invalid @enderror"
                                        required>
                                        <option value="" disabled selected>Pilih Slot</option>
                                        @foreach (['Slot 1', 'Slot 2', 'Slot 3', 'Slot 4', 'Slot 5', 'Slot 6'] as $slot)
                                            <option value="{{ $slot }}">{{ $slot }}</option>
                                        @endforeach
                                    </select>
                                    @error('slot')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-gray-700">ATA <span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="ata"
                                        class="form-control @error('ata') is-invalid @enderror" required>
                                    @error('ata')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">Qty Order <span
                                        class="text-danger">*</span></label>
                                <input type="number" min="0" name="qty_order"
                                    class="form-control @error('qty_order') is-invalid @enderror" required>
                                @error('qty_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Detail Inbound -->
        <div class="modal fade" id="detailInboundModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold">Detail Inbound</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <dl class="row mb-0">
                            <dt class="col-5 text-muted font-weight-normal">No. Inbound</dt>
                            <dd class="col-7 font-weight-bold" id="detail-no"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Tanggal</dt>
                            <dd class="col-7" id="detail-tanggal"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Station</dt>
                            <dd class="col-7" id="detail-station"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Slot</dt>
                            <dd class="col-7" id="detail-slot"></dd>

                            <dt class="col-5 text-muted font-weight-normal">ATA</dt>
                            <dd class="col-7" id="detail-ata"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Qty Order</dt>
                            <dd class="col-7" id="detail-qty"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Status</dt>
                            <dd class="col-7" id="detail-status"></dd>

                            <dt class="col-5 text-muted font-weight-normal">Catatan</dt>
                            <dd class="col-7" id="detail-catatan"></dd>
                        </dl>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Select2 untuk Station filter (opsional, karena select2 sudah di-load di layout)
            $('.select2-station').select2({
                placeholder: 'Pilih Station',
                width: '100%'
            });

            // Populate modal detail saat dibuka
            $('#detailInboundModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                $('#detail-no').text(button.data('no'));
                $('#detail-tanggal').text(button.data('tanggal'));
                $('#detail-station').text(button.data('station'));
                $('#detail-slot').text(button.data('slot'));
                $('#detail-ata').text(button.data('ata'));
                $('#detail-qty').text(button.data('qty'));
                $('#detail-status').text(button.data('status'));
                $('#detail-catatan').text(button.data('catatan'));
            });
        });
    </script>
@endpush
