@extends('layouts.app')

@section('title', 'Ajukan Izin')

@section('content')
<h3 class="mb-4">Ajukan Izin / Sakit</h3>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('guru.izin.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select" required>
                        <option value="Izin" @selected(old('jenis') === 'Izin')>Izin</option>
                        <option value="Sakit" @selected(old('jenis') === 'Sakit')>Sakit</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Alasan</label>
                    <textarea name="alasan" class="form-control @error('alasan') is-invalid @enderror" rows="3" required>{{ old('alasan') }}</textarea>
                    @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
        </form>
    </div>
</div>
@endsection
