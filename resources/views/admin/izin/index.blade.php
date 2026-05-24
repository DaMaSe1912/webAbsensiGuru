@extends('layouts.app')

@section('title', 'Pengajuan Izin')

@section('content')
<h3 class="mb-4">Pengajuan Izin Guru</h3>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Guru</th>
                    <th>Jenis</th>
                    <th>Periode</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $p)
                <tr>
                    <td>{{ $p->guru->nama }}</td>
                    <td>{{ $p->jenis }}</td>
                    <td>{{ $p->tanggal_mulai->format('d/m/Y') }} — {{ $p->tanggal_selesai->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($p->alasan, 50) }}</td>
                    <td>
                        <span class="badge bg-{{ $p->status === 'Menunggu' ? 'warning' : ($p->status === 'Disetujui' ? 'success' : 'danger') }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td>
                        @if($p->status === 'Menunggu')
                        <form method="POST" action="{{ route('admin.izin.update', $p) }}" class="d-inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="Disetujui">
                            <button class="btn btn-sm btn-success">Setujui</button>
                        </form>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#tolak{{ $p->id }}">Tolak</button>

                        <div class="modal fade" id="tolak{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.izin.update', $p) }}" class="modal-content">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="Ditolak">
                                    <div class="modal-header"><h5 class="modal-title">Tolak Pengajuan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                    <div class="modal-body">
                                        <textarea name="catatan_admin" class="form-control" placeholder="Catatan (opsional)"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        —
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">Belum ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pengajuan->hasPages())<div class="card-footer">{{ $pengajuan->links() }}</div>@endif
</div>
@endsection
