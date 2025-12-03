<div class="sidebar">

    <!-- Header Menu -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a class="d-block">Menu Utama</a>
        </div>
    </div>

    <!-- SIDEBAR MENU -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Manajemen Kamar -->
            <li class="nav-item">
                <a href="{{ url('/kamar') }}" class="nav-link">
                    <i class="nav-icon fa-solid fa-house"></i>
                    <p>Manajemen Kamar</p>
                </a>
            </li>

            <!-- Manajemen Booking -->
            <li class="nav-item">
                <a href="{{ url('/booking') }}" class="nav-link">
                    <i class="nav-icon fa-regular fa-calendar"></i>
                    <p>Manajemen Booking</p>
                </a>
            </li>

            <!-- Manajemen Tagihan -->
            <li class="nav-item">
                <a href="{{ url('/tagihan') }}" class="nav-link">
                    <i class="nav-icon fa-solid fa-money-bill"></i>
                    <p>Manajemen Tagihan</p>
                </a>
            </li>

            <!-- Manajemen Keluhan -->
            <li class="nav-item">
                <a href="{{ url('/keluhan') }}" class="nav-link">
                    <i class="nav-icon fa-solid fa-comment"></i>
                    <p>Manajemen Keluhan</p>
                </a>
            </li>

            <!-- Pengumuman -->
            <li class="nav-item">
                <a href="{{ url('/pengumuman') }}" class="nav-link">
                    <i class="nav-icon fa-solid fa-note-sticky"></i>
                    <p>Pengumuman</p>
                </a>
            </li>

        </ul>
    </nav>
</div>
