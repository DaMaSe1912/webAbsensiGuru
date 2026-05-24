@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h3 class="mb-4">Dashboard Admin</h3>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card border-success">
            <div class="card-body">
                <div class="text-muted small">Hadir Hari Ini</div>
                <h2 class="mb-0 text-success">{{ $stats['hadir'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-warning">
            <div class="card-body">
                <div class="text-muted small">Izin / Sakit</div>
                <h2 class="mb-0 text-warning">{{ $stats['izin'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-danger">
            <div class="card-body">
                <div class="text-muted small">Alpa Hari Ini</div>
                <h2 class="mb-0 text-danger">{{ $stats['alpa'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card border-primary">
            <div class="card-body">
                <div class="text-muted small">Total Guru Aktif</div>
                <h2 class="mb-0 text-primary">{{ $stats['total_guru'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Grafik Kehadiran 7 Hari Terakhir</div>
            <div class="card-body">
                <canvas id="chartKehadiran" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header text-danger">Belum Absen Hari Ini</div>
            <ul class="list-group list-group-flush">
                @forelse($belumAbsen as $g)
                    <li class="list-group-item">{{ $g->nama }} <small class="text-muted">({{ $g->mapel }})</small></li>
                @empty
                    <li class="list-group-item text-muted">Semua guru sudah absen.</li>
                @endforelse
            </ul>
        </div>
        <div class="card">
            <div class="card-header">Pengajuan Izin Menunggu</div>
            <ul class="list-group list-group-flush">
                @forelse($izinMenunggu as $izin)
                    <li class="list-group-item">
                        <strong>{{ $izin->guru->nama }}</strong><br>
                        <small>{{ $izin->tanggal_mulai->format('d/m/Y') }} - {{ $izin->tanggal_selesai->format('d/m/Y') }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Tidak ada pengajuan.</li>
                @endforelse
            </ul>
            @if($izinMenunggu->count())
                <div class="card-footer"><a href="{{ route('admin.izin.index') }}">Lihat semua</a></div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chartKehadiran'), {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Hadir',
            data: @json($chartData),
            borderColor: '#198754',
            backgroundColor: 'rgba(25,135,84,.1)',
            fill: true,
            tension: 0.3
        }]
    },
    options: { scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
