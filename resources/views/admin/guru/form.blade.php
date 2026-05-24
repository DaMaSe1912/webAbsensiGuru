@extends('layouts.app')

@section('title', $guru->exists ? 'Edit Guru' : 'Tambah Guru')

@section('content')
<h3 class="mb-4">{{ $guru->exists ? 'Edit' : 'Tambah' }} Data Guru</h3>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $guru->exists ? route('admin.guru.update', $guru) : route('admin.guru.store') }}" enctype="multipart/form-data">
            @csrf
            @if($guru->exists) @method('PUT') @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $guru->nama) }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $guru->nip) }}">
                    @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" name="mapel" class="form-control @error('mapel') is-invalid @enderror" value="{{ old('mapel', $guru->mapel) }}" required>
                    @error('mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email (login)</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $guru->email) }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="{{ old('kontak', $guru->kontak) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password Akun {{ $guru->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $guru->exists ? '' : 'required' }}>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <div class="col-md-6 mb-3 form-check mt-4">
                    <input type="checkbox" name="aktif" value="1" class="form-check-input" id="aktif" {{ old('aktif', $guru->aktif ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="aktif">Guru Aktif</label>
                </div>
            </div>

            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
