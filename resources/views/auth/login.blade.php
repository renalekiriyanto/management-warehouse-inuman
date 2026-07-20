@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center fade-in">
    <div class="col-lg-10 col-xl-9">
        <div class="card card-auth my-5">
            <div class="row g-0">
                <!-- Sebelah Kiri: Branding -->
                <div class="col-md-5 d-none d-md-block">
                    @include('partials.brand')
                </div>

                <!-- Sebelah Kanan: Form -->
                <div class="col-md-7 p-4 p-sm-5">

                    @if(session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if(session('error'))
                        <x-alert type="danger" :message="session('error')" />
                    @endif

                    <div class="text-center d-md-none mb-4">
                        <h2 class="text-primary-sb fw-bold mb-1">SPX Express</h2>
                        <p class="text-gray-500 small">Internal Logistics Portal</p>
                    </div>

                    <div class="mb-4 text-start">
                        <h3 class="fw-bold text-gray-900 mb-1">Welcome Back</h3>
                        <p class="text-muted small">Sign in using your SPX Express Google Account.</p>
                    </div>

                    <!-- Information Card -->
                    <div class="card card-info-blue border-0 rounded-3 mb-4">
                        <div class="card-body p-3.5 text-start">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-info-circle-fill text-primary" style="font-size: 1.25rem; color: #4e73df !important;"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Login Information</h6>
                                    <ul class="mb-0 ps-3 text-muted small" style="line-height: 1.5; font-size: 0.78rem;">
                                        <li>✓ Login is only available using a corporate Google account.</li>
                                        <li>✓ Only <strong class="text-dark">@spxexpress.com</strong> accounts are allowed.</li>
                                        <li>✓ Your Station, Role, and Permissions are automatically loaded after login.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="auth-divider">
                        <span>Continue</span>
                    </div>

                    <!-- Google OAuth Login Button -->
                    <div class="d-grid mb-4">
                        <a href="{{ route('auth.google') }}" class="btn btn-google-oauth">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                            Continue with Google
                        </a>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-0">
                            Don't have an account? <a href="{{ route('register') }}" class="text-primary-sb text-decoration-none fw-bold">Register</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
