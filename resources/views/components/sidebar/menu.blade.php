<ul class="sidebar-menu">

    <li class="menu-item">
        <a href="{{ route('dashboard') }}" class="active">
            <i class="fa-solid fa-gauge-high menu-icon"></i>
            Dashboard
        </a>
    </li>

    <li class="menu-item">
        <a href="#">
            <i class="fas fa-calendar-days menu-icon"></i>
            Slot Management
        </a>
    </li>

    <li class="menu-item">
        <a href="#" id="inboundToggle" class="has-submenu">
            <div class="menu-left">
                <i class="fa-solid fa-truck-ramp-box menu-icon"></i>
                <span>Inbound</span>
            </div>
            <i class="fa-solid fa-chevron-down submenu-arrow"></i>
        </a>
        <div class="sidebar-submenu" id="inboundSubmenu">
            <a href="">Projection</a>
            <a href="">Planning</a>
            <a href="">Monitoring</a>
            <a href="">History</a>
        </div>
    </li>

    <li class="menu-item">
        <a href="#">
            <i class="fas fa-truck-fast menu-icon"></i>
            Outbound
        </a>
    </li>

    <li class="menu-item">
        <a href="#">
            <i class="fas fa-users menu-icon"></i>
            Users
        </a>
    </li>

    <li class="menu-item">
        <a href="#">
            <i class="fas fa-warehouse menu-icon"></i>
            Stations
        </a>
    </li>

</ul>
@push('scripts')
    <script>
        const inbound = document.getElementById("inboundToggle");
        const submenu = document.getElementById("inboundSubmenu");
        const arrow = inbound.querySelector(".submenu-arrow");

        inbound.addEventListener("click", function(e) {
            e.preventDefault();

            submenu.classList.toggle("show");
            arrow.classList.toggle("rotate");
        });
    </script>
@endpush
