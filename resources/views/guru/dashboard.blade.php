@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<h3 class="mb-1">Halo, {{ $guru->nama }}</h3>
<p class="text-muted mb-4">{{ $guru->mapel }} — {{ now()->translatedFormat('l, d F Y') }}</p>

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5>Status Absensi Hari Ini</h5>
                @if($absensiHariIni)
                    <p class="mb-1">Status: <span class="badge bg-{{ $absensiHariIni->status === 'Hadir' ? 'success' : 'warning' }}">{{ $absensiHariIni->status }}</span></p>
                    <p class="mb-1">Check-in: <strong>{{ $absensiHariIni->jam_masuk ? substr($absensiHariIni->jam_masuk, 0, 5) : '-' }}</strong></p>
                    <p class="mb-3">Check-out: <strong>{{ $absensiHariIni->jam_keluar ? substr($absensiHariIni->jam_keluar, 0, 5) : '-' }}</strong></p>

                    <div class="d-flex gap-2">
                        @if(!$absensiHariIni->jam_masuk)
                            <form method="POST" action="{{ route('guru.check-in') }}">@csrf<button class="btn btn-success btn-lg"><i class="bi bi-box-arrow-in-right"></i> Check-in</button></form>
                        @elseif(!$absensiHariIni->jam_keluar && $absensiHariIni->status === 'Hadir')
                            <form method="POST" action="{{ route('guru.check-out') }}">@csrf<button class="btn btn-primary btn-lg"><i class="bi bi-box-arrow-right"></i> Check-out</button></form>
                        @else
                            <span class="text-muted">Absensi hari ini sudah selesai.</span>
                        @endif
                    </div>
                @else
                    <p class="text-muted">Anda belum melakukan absensi hari ini.</p>
                    <form method="POST" action="{{ route('guru.check-in') }}">@csrf<button class="btn btn-success btn-lg"><i class="bi bi-box-arrow-in-right"></i> Check-in Sekarang</button></form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6>Info Guru</h6>
                <p class="mb-1 small">NIP: {{ $guru->nip ?? '-' }}</p>
                <p class="mb-0 small">Kontak: {{ $guru->kontak ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Riwayat 7 Hari Terakhir</div>
    <table class="table mb-0">
        <thead class="table-light"><tr><th>Tanggal</th><th>Status</th><th>Masuk</th><th>Keluar</th></tr></thead>
        <tbody>
            @forelse($riwayat as $r)
            <tr>
                <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                <td><span class="badge bg-{{ $r->status === 'Hadir' ? 'success' : ($r->status === 'Alfa' ? 'danger' : 'warning') }}">{{ $r->status }}</span></td>
                <td>{{ $r->jam_masuk ? substr($r->jam_masuk, 0, 5) : '-' }}</td>
                <td>{{ $r->jam_keluar ? substr($r->jam_keluar, 0, 5) : '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
