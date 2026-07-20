@extends('layouts.auth')

@section('title', 'Lengkapi Profil')

@section('content')
    @push('styles')
        <style>
            [x-cloak] {
                display: none !important;
            }

            .searchable-menu {
                display: none;
                position: absolute;
                z-index: 1000;
                width: 100%;
                background: #fff;
                border: 1px solid #d1d3e2;
                border-radius: 10px;
                margin-top: 4px;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .searchable-menu.show {
                display: block;
            }

            .searchable-dropdown {
                position: relative;
            }

            .searchable-item {
                padding: 0.5rem 0.75rem;
                cursor: pointer;
                font-size: 0.9rem;
            }

            .searchable-item:hover {
                background-color: #f8f9fc;
            }
        </style>
    @endpush
    <div class="row justify-content-center fade-in">
        <div class="col-lg-10 col-xl-9">
            <div class="card card-auth my-4">
                <div class="row g-0">
                    <!-- Sebelah Kiri: Branding -->
                    <div class="col-md-5 d-none d-md-block">
                        @include('partials.brand')
                    </div>

                    <!-- Sebelah Kanan: Form -->
                    <div class="col-md-7 p-4 p-sm-5">

                        <div class="text-center d-md-none mb-4">
                            <h2 class="text-primary-sb fw-bold mb-1">SPX Express</h2>
                            <p class="text-gray-500 small">Internal Logistics Portal</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="fw-bold text-gray-900 mb-1">Lengkapi Profil</h3>
                            <p class="text-muted small">Lengkapi informasi stasiun operasional dan peran kerja Anda</p>
                        </div>

                        <!-- Google Profile Summary (Read-Only) -->
                        <div class="google-profile-card mb-4 text-start">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $user = Auth::user();
                                    $avatar = $user->profile->avatar ?? null;
                                @endphp
                                <div class="position-relative">
                                    <img src="{{ $avatar
                                        ? asset('storage/' . $avatar)
                                        : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '?d=mp' }}"
                                        alt="Avatar" class="rounded-circle border"
                                        style="width: 56px; height: 56px; object-fit: cover;">
                                    <span
                                        class="position-absolute bottom-0 end-0 bg-white rounded-circle p-0.5 d-flex align-items-center justify-content-center border"
                                        style="width: 20px; height: 20px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                                            alt="G" style="width: 12px; height: 12px;">
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <h6 class="fw-bold text-dark mb-0">{{ Auth::user()->name }}</h6>
                                        <span class="badge-google">
                                            <i class="bi bi-patch-check-fill text-primary" style="font-size: 0.85rem;"></i>
                                            Signed in with Google
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Completion Form -->
                        <form id="completeProfileForm" action="{{ route('auth.complete-profile.submit') }}" method="POST"
                            novalidate>
                            @csrf

                            <!-- Station Searchable Select -->
                            <div class="mb-3 text-start"
                                x-data='{
                                    stations: @json($stations->map(fn($s) => ['id' => $s->id, 'name' => $s->name])),
                                    open: false,
                                    search: "",
                                    selectedId: "{{ old('station_id') }}",
                                    selectedName: "{{ old('station_name') }}",
                                    get filteredStations() {
                                        return this.stations.filter(s =>
                                            s.name.toLowerCase().includes(this.search.toLowerCase())
                                        );
                                    }
                                }'
                                @click.outside="open = false">

                                <label class="form-label fw-semibold text-gray-700 mb-1">Station <span
                                        class="text-danger">*</span></label>

                                <input type="hidden" name="station_id" id="station_id" x-model="selectedId">

                                <div class="searchable-dropdown">
                                    <div class="form-control d-flex justify-content-between align-items-center {{ $errors->has('station_id') ? 'border-danger' : '' }}"
                                        style="cursor: pointer;"
                                        @click="open = !open; if(open) $nextTick(() => $refs.search.focus())">
                                        <span :class="selectedName ? 'text-dark fw-semibold' : 'text-muted'"
                                            x-text="selectedName || 'Pilih Station'"></span>
                                        <i class="bi bi-chevron-down text-muted"></i>
                                    </div>

                                    @error('station_id')
                                        <div class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror

                                    <!-- Dropdown Menu -->
                                    <div class="searchable-menu" :class="{ 'show': open }" x-cloak>
                                        <div class="p-2 border-bottom">
                                            <input type="text" class="form-control form-control-sm"
                                                placeholder="Cari Station..." x-ref="search" x-model="search" @click.stop>
                                        </div>
                                        <div style="max-height: 160px; overflow-y: auto;">
                                            <template x-for="station in filteredStations" :key="station.id">
                                                <div class="searchable-item"
                                                    @click="selectedId = station.id; selectedName = station.name; open = false; search = ''">
                                                    <i class="bi bi-geo-alt me-2"></i>
                                                    <span x-text="station.name"></span>
                                                </div>
                                            </template>
                                            <div class="text-muted small px-2 py-2" x-show="filteredStations.length === 0">
                                                Station tidak ditemukan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Role Select Input -->
                            <div class="mb-4 text-start">
                                <label for="role" class="form-label fw-semibold text-gray-700 mb-1">Role <span
                                        class="text-danger">*</span></label>
                                <select name="role" id="role"
                                    class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Save & Continue Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-sb">
                                    <i class="bi bi-check2-circle"></i>Save &amp; Continue
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
