<header class="top-navbar">

    <div class="navbar-left">
        <x-navbar.breadcrumb :breadcrumb="$breadcrumb ?? 'Dashboard'" />
    </div>

    <div class="navbar-right">

        <x-navbar.search />

        <x-navbar.notification />

        <x-navbar.profile />

    </div>

</header>
