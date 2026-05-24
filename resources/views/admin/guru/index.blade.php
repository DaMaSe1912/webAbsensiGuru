@extends('layouts.app')

@section('title', 'Manajemen Guru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Manajemen Guru</h3>
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Guru</a>
</div>

<form class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Cari nama, NIP, mapel..." value="{{ request('q') }}">
    </div>
    <div class="col-auto"><button class="btn btn-outline-secondary">Cari</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Mapel</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($gurus as $guru)
                <tr>
                    <td>
                        @if($guru->foto)
                            <img src="{{ asset('storage/'.$guru->foto) }}" class="rounded-circle" width="40" height="40" alt="">
                        @else
                            <span class="badge bg-secondary rounded-circle p-2"><i class="bi bi-person"></i></span>
                        @endif
                    </td>
                    <td>{{ $guru->nama }}</td>
                    <td>{{ $guru->nip ?? '-' }}</td>
                    <td>{{ $guru->mapel }}</td>
                    <td>{{ $guru->kontak ?? '-' }}</td>
                    <td><span class="badge bg-{{ $guru->aktif ? 'success' : 'secondary' }}">{{ $guru->aktif ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td>
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data guru ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted">Belum ada data guru.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($gurus->hasPages())
        <div class="card-footer">{{ $gurus->links() }}</div>
    @endif
</div>
@endsection
