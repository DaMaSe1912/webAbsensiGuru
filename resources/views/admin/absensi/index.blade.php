@extends('layouts.app')

@section('title', 'Manajemen Absensi')

@section('content')
<h3 class="mb-4">Manajemen Absensi</h3>

<div class="card mb-3">
    <div class="card-body">
        <form class="row g-2 align-items-end" method="GET">
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Guru</label>
                <select name="guru_id" class="form-select">
                    <option value="">Semua</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" @selected(request('guru_id') == $g->id)>{{ $g->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    @foreach(['Hadir','Izin','Sakit','Alfa'] as $s)
                        <option value="{{ $s }}" @selected(request('status') == $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto"><button class="btn btn-primary">Filter</button></div>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">Input Manual Absensi</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.absensi.store') }}" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-3">
                <select name="guru_id" class="form-select" required>
                    <option value="">Pilih Guru</option>
                    @foreach($gurus as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2"><input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required></div>
            <div class="col-md-2">
                <select name="status" class="form-select" required>
                    @foreach(['Hadir','Izin','Sakit','Alfa'] as $s)<option>{{ $s }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-2"><input type="time" name="jam_masuk" class="form-control" placeholder="Masuk"></div>
            <div class="col-md-2"><input type="time" name="jam_keluar" class="form-control" placeholder="Keluar"></div>
            <div class="col-auto"><button class="btn btn-success">Simpan</button></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Guru</th>
                    <th>Mapel</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                <tr>
                    <td>{{ $a->guru->nama }}</td>
                    <td>{{ $a->guru->mapel }}</td>
                    <td><span class="badge bg-{{ $a->status === 'Hadir' ? 'success' : ($a->status === 'Alfa' ? 'danger' : 'warning') }}">{{ $a->status }}</span></td>
                    <td>{{ $a->jam_masuk ? substr($a->jam_masuk, 0, 5) : '-' }}</td>
                    <td>{{ $a->jam_keluar ? substr($a->jam_keluar, 0, 5) : '-' }}</td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                    <td><a href="{{ route('admin.absensi.edit', $a) }}" class="btn btn-sm btn-warning">Edit</a></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">Tidak ada data absensi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($absensi->hasPages())<div class="card-footer">{{ $absensi->links() }}</div>@endif
</div>
@endsection
