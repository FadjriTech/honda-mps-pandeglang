<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ $active == 'dashboard' ? 'active' : '' }}">
            <a class="nav-link" href="/admin">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item {{ $active == 'table' ? 'active' : '' }}">
            <a class="nav-link" href="/table">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Daftar Participant</span>
            </a>
        </li>
        <li class="nav-item {{ $active == 'pengumuman' ? 'active' : '' }}">
            <a class="nav-link" href="/announcement">
                <i class="ti-bookmark-alt menu-icon"></i>
                <span class="menu-title">Pengumuman</span>
            </a>
        </li>
    </ul>
</nav>
