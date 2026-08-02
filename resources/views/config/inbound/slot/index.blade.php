@extends('layouts.index')

@section('title', 'Slots')

@section('content')
    <div class="container-fluid" x-data="slotPage()">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Slots</h1>
                <p class="text-muted small mb-0">Kelola data slot per station</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addSlotModal">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Slot
            </button>
        </div>

        <!-- Filter Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('config.inbound.slot.index') }}" class="row g-2 align-items-end">
                    @if ($isManager)
                        <div class="col-md-4 mb-2">
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
                    @endif
                    <div class="col-md-4 mb-2">
                        <label class="small font-weight-bold text-gray-700">Cari Nama Slot</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama slot..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 mb-2 d-flex">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('config.inbound.slot.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Slot</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Slot</th>
                                <th>ETA</th>
                                <th>Station</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($slots as $slot)
                                <tr>
                                    <td class="font-weight-bold">{{ $slot->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($slot->eta)->format('H:i') }}</td>
                                    <td>{{ $slot->station->name ?? '-' }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary mr-1"
                                            data-toggle="modal" data-target="#editSlotModal"
                                            @click="openEdit({
                                                id: {{ $slot->id }},
                                                name: @js($slot->name),
                                                eta: @js(\Carbon\Carbon::parse($slot->eta)->format('H:i')),
                                                station_id: {{ $slot->station_id ?? 'null' }},
                                                url: @js(route('config.inbound.slot.update', $slot->id))
                                            })">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                            data-target="#deleteSlotModal"
                                            @click="openDelete({
                                                id: {{ $slot->id }},
                                                name: @js($slot->name),
                                                url: @js(route('config.inbound.slot.destroy', $slot->id))
                                            })">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Belum ada data slot.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($slots instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-3">
                        {{ $slots->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal: Tambah Slot -->
        <div class="modal fade" id="addSlotModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('config.inbound.slot.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Tambah Slot</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">Nama Slot <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Slot 1"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">ETA <span class="text-danger">*</span></label>
                                <input type="time" name="eta" class="form-control @error('eta') is-invalid @enderror"
                                    required>
                                @error('eta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($isManager)
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-gray-700">Station <span
                                            class="text-danger">*</span></label>
                                    <select name="station_id"
                                        class="form-control @error('station_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Pilih Station</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('station_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
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

        <!-- Modal: Edit Slot (Alpine-driven) -->
        <div class="modal fade" id="editSlotModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form @submit.prevent="updateSlot">
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Edit Slot</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">Nama Slot <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" x-model="editForm.name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold text-gray-700">ETA <span
                                        class="text-danger">*</span></label>
                                <input type="time" name="eta" class="form-control" x-model="editForm.eta"
                                    required>
                            </div>

                            @if ($isManager)
                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-gray-700">Station <span
                                            class="text-danger">*</span></label>
                                    <select name="station_id" class="form-control" x-model="editForm.station_id"
                                        required>
                                        <option value="" disabled>Pilih Station</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <select name="station_id" class="form-control" x-model="editForm.station_id">
                                    <option value="{{ $user->station_id }}"></option>
                                </select>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Hapus Slot (Alpine-driven) -->
        <div class="modal fade" id="deleteSlotModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form :action="deleteForm.url" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title font-weight-bold">Hapus Slot</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">Yakin ingin menghapus slot <strong x-text="deleteForm.name"></strong>?
                                Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function slotPage() {
            return {
                editForm: {
                    id: null,
                    name: '',
                    eta: '',
                    station_id: '',
                    url: ''
                },
                deleteForm: {
                    id: null,
                    name: '',
                    url: ''
                },
                loading: false,
                errors: {},
                openEdit(slot) {
                    console.log('Open edit:', slot)
                    this.editForm.id = slot.id;
                    this.editForm.name = slot.name;
                    this.editForm.eta = slot.eta;
                    this.editForm.station_id = slot.station_id;
                    this.editForm.url = slot.url;

                    // trigger select2 kalau field station pakai select2 juga
                    this.$nextTick(() => {
                        $('#editSlotModal select[name="station_id"]').trigger('change');
                    });
                },
                openDelete(slot) {
                    this.deleteForm.id = slot.id;
                    this.deleteForm.name = slot.name;
                    this.deleteForm.url = slot.url;
                },
                async updateSlot() {
                    this.loading = true;
                    this.errors = {};

                    try {
                        const res = await axios.put(this.editForm.url, {
                            name: this.editForm.name,
                            eta: this.editForm.eta,
                            station: this.editForm.station_id
                        })

                        $('#editSlotModal').modal('hide');

                        await Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.data.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        location.reload();
                    } catch (error) {
                        console.error(error);
                        alert('Terjadi kesalahan');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }

        $(document).ready(function() {
            // Select2 untuk filter station tetap pakai jQuery, tidak ada konflik dengan Alpine
            $('.select2-station').select2({
                placeholder: 'Pilih Station',
                width: '100%'
            });
        });
    </script>
@endpush
