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
        .sidebar { min-height: 100vh; background: #1e3a5f; }
        .sidebar a { color: rgba(255,255,255,.85); text-decoration: none; display: block; padding: .6rem 1rem; border-radius: .375rem; margin-bottom: .25rem; }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,.15); color: #fff; }
        .stat-card { border: none; border-left: 4px solid; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        @auth
        <nav class="col-md-3 col-lg-2 sidebar p-3 text-white">
            <h5 class="mb-4"><i class="bi bi-mortarboard"></i> Absensi Guru</h5>
            <small class="text-white-50 d-block mb-3">{{ auth()->user()->name }}</small>

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

            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
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
