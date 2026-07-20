@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-lg-10 col-xl-9">
        <div class="card card-auth my-4">
            <div class="row g-0">
                <!-- Sebelah Kiri: Branding -->
                <div class="col-md-5 d-none d-md-block">
                    @include('partials.brand')
                </div>

                <!-- Sebelah Kanan: Google Sign-In Action -->
                <div class="col-md-7 p-4 p-sm-5">

                    <div class="text-center d-md-none mb-4">
                        <h2 class="text-primary-sb fw-bold mb-1">SPX Express</h2>
                        <p class="text-gray-500 small">Internal Logistics Portal</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="fw-bold text-gray-900 mb-1">Register</h3>
                        <p class="text-muted small">Sign up using your SPX Express Google Account.</p>
                    </div>

                    <!-- Information Card -->
                    <div class="card bg-light border-0 rounded-3 mb-4">
                        <div class="card-body p-3.5 text-start">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-info-circle-fill text-primary" style="font-size: 1.25rem;"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Informasi Pendaftaran</h6>
                                    <ul class="mb-0 ps-3 text-muted small" style="line-height: 1.5; font-size: 0.78rem;">
                                        <li>Hanya akun Google dengan domain <strong class="text-dark">@spxexpress.com</strong> yang diperbolehkan.</li>
                                        <li>Setelah sign-in, Anda akan diarahkan ke halaman melengkapi profil (Station &amp; Role).</li>
                                        <li>Aktivasi akun sepenuhnya bergantung pada persetujuan administrator sistem.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="auth-divider">
                        <span>Continue</span>
                    </div>

                    <!-- Google OAuth Button -->
                    <div class="d-grid mb-4">
                        <a href="{{ route('auth.google') }}" class="btn btn-google-oauth">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                            Continue with Google
                        </a>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-0">
                            Already have an account? <a href="{{ route('login') }}" class="text-primary-sb text-decoration-none fw-bold" style="transition: color 0.2s;">Login</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
