<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Absensi Guru')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { background: #1e3a5f !important; }
        @media (min-width: 768px) {
            .sidebar { min-height: 100vh; }
        }
        .sidebar a { color: rgba(255,255,255,.85); text-decoration: none; display: block; padding: .6rem 1rem; border-radius: .375rem; margin-bottom: .25rem; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,.15); color: #fff; }
        .stat-card { border: none; border-left: 4px solid; }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 280px;
            }
        }
    </style>
</head>
<body>
@auth
<!-- Top Navbar for Mobile -->
<header class="navbar navbar-dark sticky-top d-md-none p-3 shadow-sm" style="background-color: #1e3a5f;">
    <div class="container-fluid d-flex align-items-center justify-content-between p-0">
        <span class="navbar-brand mb-0 h1 fs-5 text-white"><i class="bi bi-mortarboard"></i> Absensi Guru</span>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</header>
@endauth

<div class="container-fluid">
    <div class="row">
        @auth
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 sidebar p-3 text-white offcanvas-md offcanvas-start">
            <div class="offcanvas-header d-md-none border-bottom border-light-subtle mb-3 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.15) !important;">
                <h5 class="offcanvas-title text-white" id="sidebarMenuLabel"><i class="bi bi-mortarboard"></i> Absensi Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
            
            <div class="offcanvas-body d-flex flex-column p-0">
                <h5 class="mb-4 d-none d-md-block"><i class="bi bi-mortarboard"></i> Absensi Guru</h5>
                <div class="mb-4 pb-3" style="border-bottom: 1px solid rgba(255,255,255,0.15) !important;">
                    <small class="text-white-50 d-block mb-1">Selamat datang,</small>
                    <h6 class="text-white mb-0">{{ auth()->user()->name }}</h6>
                </div>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a href="{{ route('admin.guru.index') }}" class="{{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"><i class="bi bi-people"></i> Data Guru</a>
                    <a href="{{ route('admin.absensi.index') }}" class="{{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i> Absensi</a>
                    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a>
                    <a href="{{ route('admin.izin.index') }}" class="{{ request()->routeIs('admin.izin.*') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Pengajuan Izin</a>
                    <a href="{{ route('admin.pengaturan.index') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}"><i class="bi bi-gear"></i> Pengaturan</a>
                @else
                    <a href="{{ route('guru.dashboard') }}" class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a href="{{ route('guru.riwayat') }}" class="{{ request()->routeIs('guru.riwayat') ? 'active' : '' }}"><i class="bi bi-clock-history"></i> Riwayat</a>
                    <a href="{{ route('guru.izin.form') }}" class="{{ request()->routeIs('guru.izin.*') ? 'active' : '' }}"><i class="bi bi-envelope-paper"></i> Ajukan Izin</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="mt-md-auto mt-4 pt-3" style="border-top: 1px solid rgba(255,255,255,0.15) !important;">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
                </form>
            </div>
        </nav>
        <main class="col-md-9 col-lg-10 p-4">
        @else
        <main class="col-12">
        @endauth

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
