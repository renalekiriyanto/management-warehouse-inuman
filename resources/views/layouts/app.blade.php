<!DOCTYPE html>
<html lang="id">

<head>

    @include('layouts.head')

    @stack('styles')

</head>

<body>

    <div class="dashboard-wrapper">

        <x-sidebar.index />

        <div class="main-wrapper">


            <x-navbar.index />
            <div class="main-content">

                <main class="content-wrapper">

                    @yield('content')

                </main>

            </div>

            <x-footer />

        </div>

    </div>

    <x-toast />

    @stack('scripts')

    @vite('resources/js/app.js')

</body>

</html>
