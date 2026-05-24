@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<h3 class="mb-4">Laporan Absensi</h3>

<form class="row g-2 mb-4 align-items-end" method="GET">
    <div class="col-md-3">
        <label class="form-label">Dari</label>
        <input type="date" name="dari" class="form-control" value="{{ $dari }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Sampai</label>
        <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">Tampilkan</button>
        <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="btn btn-danger">PDF</a>
        <a href="{{ route('admin.laporan.excel', request()->query()) }}" class="btn btn-success">Excel (CSV)</a>
    </div>
</form>

<div class="card mb-4">
    <div class="card-header">Grafik Persentase Kehadiran</div>
    <div class="card-body"><canvas id="chartLaporan" height="80"></canvas></div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Mapel</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alfa</th>
                    <th>% Hadir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekap as $row)
                <tr>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->nip ?? '-' }}</td>
                    <td>{{ $row->mapel }}</td>
                    <td>{{ $row->hadir }}</td>
                    <td>{{ $row->izin }}</td>
                    <td>{{ $row->sakit }}</td>
                    <td>{{ $row->alpa }}</td>
                    <td>{{ $row->persentase }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chartLaporan'), {
    type: 'bar',
    data: {
        labels: @json($rekap->pluck('nama')),
        datasets: [{
            label: 'Persentase Hadir (%)',
            data: @json($rekap->pluck('persentase')),
            backgroundColor: '#0d6efd'
        }]
    },
    options: { scales: { y: { beginAtZero: true, max: 100 } } }
});
</script>
@endpush
