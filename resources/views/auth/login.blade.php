@extends('layouts.auth')

@section('title', 'Login')

@section('content')
@push('styles')
    <style>
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f8f9fc;
            color: #858796;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card-auth {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background-color: #fff;
            overflow: hidden;
        }

        .bg-brand-sidebar {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            color: #fff;
            padding: 3.5rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            min-height: 460px;
        }

        .text-brand-title {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }

        .btn-primary-sb {
            background-color: #4e73df;
            border-color: #4e73df;
            color: #fff;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary-sb:hover, .btn-primary-sb:focus {
            background-color: #2e59d9;
            border-color: #264bbf;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        /* Modern Google OAuth Button */
        .btn-google-oauth {
            background-color: #ffffff;
            border: 1px solid #dadce0;
            color: #3c4043;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.01em;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-google-oauth:hover, .btn-google-oauth:focus {
            background-color: #f8f9fa;
            border-color: #d2d4d7;
            color: #202124;
            box-shadow: 0 2px 6px rgba(60,64,67,0.1);
            transform: translateY(-1px);
        }

        .btn-google-oauth:active {
            background-color: #f1f3f4;
            transform: translateY(1px);
            box-shadow: none;
        }

        .btn-google-oauth img {
            width: 18px;
            height: 18px;
            display: block;
        }

        /* Premium Visual Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.75rem 0;
            color: #a0a2b1;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }

        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e3e6f0;
        }

        .auth-divider::before {
            margin-right: 1.25rem;
        }

        .auth-divider::after {
            margin-left: 1.25rem;
        }

        /* Info Card Styling */
        .card-info-blue {
            background-color: #f0f4f9;
            border: 1px solid #d2e3fc;
            border-radius: 12px;
        }

        /* Fade-in Animation */
        .fade-in {
            animation: fadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
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
