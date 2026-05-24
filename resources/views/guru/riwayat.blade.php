@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<h3 class="mb-4">Riwayat Absensi</h3>

<div class="card">
    <table class="table table-hover mb-0">
        <thead class="table-light">
            <tr><th>Tanggal</th><th>Status</th><th>Jam Masuk</th><th>Jam Keluar</th><th>Keterangan</th></tr>
        </thead>
        <tbody>
            @forelse($riwayat as $r)
            <tr>
                <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                <td>{{ $r->status }}</td>
                <td>{{ $r->jam_masuk ? substr($r->jam_masuk, 0, 5) : '-' }}</td>
                <td>{{ $r->jam_keluar ? substr($r->jam_keluar, 0, 5) : '-' }}</td>
                <td>{{ $r->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($riwayat->hasPages())<div class="card-footer">{{ $riwayat->links() }}</div>@endif
</div>
@endsection
