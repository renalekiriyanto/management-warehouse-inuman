@extends('layouts.auth')

@section('title', 'Registrasi')

@section('content')
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
                        <h3 class="fw-bold text-gray-900 mb-1">Registrasi Akun</h3>
                        <p class="text-muted small">Daftarkan akun karyawan untuk operasional logistik</p>
                    </div>

                    <form action="{{ route('register') }}" method="POST" novalidate>
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <x-input
                                label="Nama Lengkap"
                                type="text"
                                name="name"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                required
                                autocomplete="name"
                            />
                        </div>

                        <!-- Email Corporate -->
                        <div class="mb-3">
                            <x-input
                                label="Email Corporate"
                                type="email"
                                name="email"
                                placeholder="nama@spxexpress.com"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                            />
                        </div>

                        <!-- Password & Konfirmasi Password (Grid Responsive) -->
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <x-input
                                    label="Password"
                                    type="password"
                                    name="password"
                                    placeholder="Min. 8 karakter"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                            <div class="col-sm-6">
                                <x-input
                                    label="Konfirmasi Password"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required
                                    autocomplete="new-password"
                                />
                            </div>
                        </div>

                        <!-- Station (Searchable Select Component) -->
                        <div class="mb-3">
                            <label for="station_id" class="form-label fw-semibold text-gray-700">Station</label>
                            <x-select
                                name="station_id"
                                id="station_id"
                                placeholder="Pilih Station"
                                searchable="true"
                                required
                            >
                                <option value="" disabled selected>Pilih Station</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
                                        {{ $station->name }}
                                    </option>
                                @endforeach
                            </x-select>
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="form-label fw-semibold text-gray-700">Role</label>
                            <x-select
                                name="role"
                                id="role"
                                required
                            >
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                                <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                                <option value="shift_leader" {{ old('role') == 'shift_leader' ? 'selected' : '' }}>Shift Leader</option>
                                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            </x-select>
                        </div>

                        <!-- Register Button -->
                        <div class="d-grid mb-3">
                            <x-button type="submit" class="btn-primary-sb">
                                <i class="bi bi-person-plus-fill"></i>Daftarkan Akun
                            </x-button>
                        </div>

                        <!-- Divider -->
                        <div class="auth-divider">
                            <span>Atau daftar dengan</span>
                        </div>

                        <!-- Google OAuth Login -->
                        <div class="d-grid mb-4">
                            <a href="{{ route('auth.google') }}" class="btn btn-google-oauth">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                                Continue with Google
                            </a>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-0">
                            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-primary-sb text-decoration-none fw-bold">Login</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
