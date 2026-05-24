@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<h3 class="mb-4">Edit Absensi — {{ $absensi->guru->nama }}</h3>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.absensi.update', $absensi) }}">
            @csrf @method('PUT')
            <p><strong>Tanggal:</strong> {{ $absensi->tanggal->format('d F Y') }}</p>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    @foreach(['Hadir','Izin','Sakit','Alfa'] as $s)
                        <option value="{{ $s }}" @selected(old('status', $absensi->status) === $s)>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk', $absensi->jam_masuk ? substr($absensi->jam_masuk, 0, 5) : '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Keluar</label>
                    <input type="time" name="jam_keluar" class="form-control" value="{{ old('jam_keluar', $absensi->jam_keluar ? substr($absensi->jam_keluar, 0, 5) : '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $absensi->keterangan) }}</textarea>
            </div>

            <a href="{{ route('admin.absensi.index', ['tanggal' => $absensi->tanggal->toDateString()]) }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
