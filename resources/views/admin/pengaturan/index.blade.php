@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<h3 class="mb-4">Pengaturan Sekolah</h3>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pengaturan.update') }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $pengaturan->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $pengaturan->telepon) }}">
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk', substr($pengaturan->jam_masuk, 0, 5)) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Keluar</label>
                    <input type="time" name="jam_keluar" class="form-control" value="{{ old('jam_keluar', substr($pengaturan->jam_keluar, 0, 5)) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label d-block">Hari Kerja Aktif</label>
                @php $hariKerja = old('hari_kerja', $pengaturan->hari_kerja ?? []); @endphp
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="hari_kerja[]" value="{{ $hari }}" id="hari_{{ $hari }}"
                            @checked(in_array($hari, $hariKerja))>
                        <label class="form-check-label" for="hari_{{ $hari }}">{{ $hari }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
