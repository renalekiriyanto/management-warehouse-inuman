<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SPX Express Dashboard</title>

    <!-- Google Fonts: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom SB Admin 2 Auth CSS Theme -->
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
            min-height: 480px;
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
            padding: 0.6rem 1.5rem;
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

        .btn-google-sb {
            background-color: #fff;
            border: 1px solid #e3e6f0;
            color: #4e73df;
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-google-sb:hover {
            background-color: #f8f9fc;
            border-color: #d1d3e2;
            color: #2e59d9;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.65rem 1rem;
            border: 1px solid #d1d3e2;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
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
    @stack('styles')
</head>
<body>

    <div class="container py-4">
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
