<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPX Express Logistics Portal</title>

    <!-- Google Fonts: Nunito -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom SB Admin 2 Styling using custom variables & transitions -->
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

        .btn-primary-sb:hover,
        .btn-primary-sb:focus {
            background-color: #2e59d9;
            border-color: #264bbf;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .btn-google-sb {
            background-color: #fff;
            border: 1px solid #e3e6f0;
            color: #4e73df;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
        }

        .btn-google-sb:hover {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
            color: #2e59d9;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.65rem 1rem;
            border: 1px solid #d1d3e2;
            font-size: 0.9rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.15);
        }

        .divider-text {
            position: relative;
            text-align: center;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .divider-text::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            background-color: #e3e6f0;
            top: 50%;
            left: 0;
            z-index: 1;
        }

        .divider-text span {
            background-color: #fff;
            padding: 0 15px;
            position: relative;
            z-index: 2;
            color: #b7b9cc;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
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
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center fade-in">
            <div class="col-lg-10 col-xl-9">
                <div class="card card-auth my-5">
                    <div class="row g-0">

                        <!-- Sebelah Kiri: Logo + Nama Aplikasi + Deskripsi -->
                        <div class="col-md-5 d-none d-md-block">
                            <div class="bg-brand-sidebar h-100">
                                <div class="mb-4">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-white text-primary rounded-circle mb-3"
                                        style="width: 60px; height: 60px; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                        <i class="bi bi-truck" style="font-size: 2rem; color: #4e73df;"></i>
                                    </div>
                                </div>
                                <h1 class="text-brand-title mb-2">SPX Express</h1>
                                <h5 class="fw-bold text-white-50 mb-3">Internal Logistics Portal</h5>
                                <p class="mb-0 text-white-50 small" style="line-height: 1.6;">
                                    Sistem Manajemen Logistik Terintegrasi untuk pengelolaan Hub, Station, dan Operator
                                    Lapangan seluruh regional.
                                </p>
                            </div>
                        </div>

                        <!-- Sebelah Kanan: Form Login -->
                        <div class="col-md-7 p-4 p-sm-5">

                            <!-- Alert Area -->
                            <div id="alertContainer"></div>

                            <!-- Mobile Logo (Tampil hanya di mobile) -->
                            <div class="text-center d-md-none mb-4">
                                <h2 class="fw-bold mb-1" style="color: #4e73df;">SPX Express</h2>
                                <p class="text-gray-500 small">Internal Logistics Portal</p>
                            </div>

                            <div class="mb-4">
                                <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                                <p class="text-muted small">Silakan masuk menggunakan akun korporat Anda</p>
                            </div>

                            <form id="loginForm" novalidate>

                                <!-- Email Input -->
                                <div class="mb-3 text-start">
                                    <label for="email" class="form-label fw-semibold text-gray-700 mb-1">Email
                                        Corporate <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="nama@spxexpress.com" autocomplete="email"
                                        aria-label="Email Corporate" required>
                                    <div class="invalid-feedback" id="emailError">
                                        Email Corporate wajib diisi.
                                    </div>
                                </div>

                                <!-- Password Input -->
                                <div class="mb-3 text-start">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="password" class="form-label fw-semibold text-gray-700 mb-0">Password
                                            <span class="text-danger">*</span></label>
                                        <a href="#" class="small text-decoration-none fw-bold"
                                            style="color: #4e73df;"
                                            onclick="showAlert('warning', 'Tautan pemulihan password telah dikirim ke email corporate Anda.')">Forgot
                                            Password?</a>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Masukkan password" autocomplete="current-password"
                                        aria-label="Password" required>
                                    <div class="invalid-feedback" id="passwordError">
                                        Password wajib diisi.
                                    </div>
                                </div>

                                <!-- Remember Me Checkbox -->
                                <div class="mb-4 form-check text-start">
                                    <input type="checkbox" class="form-check-input" id="remember">
                                    <label class="form-check-label text-muted small" for="remember">Remember Me</label>
                                </div>

                                <!-- Login Button -->
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary-sb py-2.5 fw-bold">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </button>
                                </div>

                                <!-- Divider -->
                                <div class="divider-text">
                                    <span>Atau masuk dengan</span>
                                </div>

                                <!-- Google OAuth Login -->
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-google-sb py-2.5 fw-bold"
                                        onclick="simulateGoogleLogin()">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                                            alt="Google" style="width: 16px; height: 16px;">
                                        Login with Google
                                    </button>
                                </div>
                            </form>

                            <div class="mt-4 text-center">
                                <p class="small text-muted mb-0">
                                    Belum terdaftar? <a href="{{ route('register') }}" class="text-decoration-none fw-bold"
                                        style="color: #4e73df;">Buat Akun</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Client Validation Script -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            let isValid = true;

            // Reset validation states
            emailInput.classList.remove('is-invalid');
            passwordInput.classList.remove('is-invalid');

            // Email check
            const emailValue = emailInput.value.trim();
            // if (!emailValue) {
            //     isValid = false;
            //     document.getElementById('emailError').textContent = 'Email Corporate wajib diisi.';
            //     emailInput.classList.add('is-invalid');
            // } else if (!emailValue.endsWith('@spxexpress.com')) {
            //     isValid = false;
            //     document.getElementById('emailError').textContent =
            //     'Email harus menggunakan domain @spxexpress.com';
            //     emailInput.classList.add('is-invalid');
            // }

            // Password check
            const passwordValue = passwordInput.value;
            if (!passwordValue) {
                isValid = false;
                document.getElementById('passwordError').textContent = 'Password wajib diisi.';
                passwordInput.classList.add('is-invalid');
            } else if (passwordValue.length < 8) {
                isValid = false;
                document.getElementById('passwordError').textContent = 'Password minimal terdiri dari 8 karakter.';
                passwordInput.classList.add('is-invalid');
            }

            if (isValid) {
                showAlert('success', 'Login Berhasil! Mengalihkan ke Dashboard (Simulasi)...');
            } else {
                showAlert('danger', 'Login gagal. Silakan periksa kembali data yang Anda masukkan.');
            }
        });

        function simulateGoogleLogin() {
            const googleEmail = prompt("Simulasi Google Sign-In. Masukkan email Google Anda:", "karyawan@spxexpress.com");
            if (googleEmail !== null) {
                if (!googleEmail.trim().toLowerCase().endsWith('@spxexpress.com')) {
                    // EXACT error alert string matched from instructions
                    showAlert('danger', 'Email yang digunakan bukan email perusahaan.');
                } else {
                    showAlert('success', 'Login via Google berhasil! Selamat datang, Karyawan (' + googleEmail + ').');
                }
            }
        }

        function showAlert(type, message) {
            const container = document.getElementById('alertContainer');
            const icons = {
                success: 'bi-check-circle-fill',
                danger: 'bi-exclamation-triangle-fill',
                warning: 'bi-exclamation-circle-fill',
                info: 'bi-info-circle-fill'
            };
            const icon = icons[type] || 'bi-info-circle-fill';

            container.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show d-flex align-items-center rounded-3 p-3 mb-4" role="alert" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); text-align: left;">
                    <i class="bi ${icon} me-3" style="font-size: 1.25rem;"></i>
                    <div class="small fw-semibold">
                        ${message}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.75rem;"></button>
                </div>
            `;
        }
    </script>
</body>

</html>
