<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());

        $absensi = Absensi::with('guru')
            ->whereDate('tanggal', $tanggal)
            ->when($request->guru_id, fn ($q, $id) => $q->where('guru_id', $id))
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $gurus = Guru::where('aktif', true)->orderBy('nama')->get();

        return view('admin.absensi.index', compact('absensi', 'gurus', 'tanggal'));
    }

    public function edit(Absensi $absensi): View
    {
        $gurus = Guru::where('aktif', true)->orderBy('nama')->get();

        return view('admin.absensi.form', compact('absensi', 'gurus'));
    }

    public function update(Request $request, Absensi $absensi): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alfa'],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_keluar' => ['nullable', 'date_format:H:i'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $absensi->update($data);

        return redirect()->route('admin.absensi.index', ['tanggal' => $absensi->tanggal->toDateString()])
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'guru_id' => ['required', 'exists:guru,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alfa'],
            'jam_masuk' => ['nullable', 'date_format:H:i'],
            'jam_keluar' => ['nullable', 'date_format:H:i'],
            'keterangan' => ['nullable', 'string'],
        ]);

        Absensi::updateOrCreate(
            ['guru_id' => $data['guru_id'], 'tanggal' => $data['tanggal']],
            $data
        );

        return redirect()->route('admin.absensi.index', ['tanggal' => $data['tanggal']])
            ->with('success', 'Data absensi berhasil disimpan.');
    }
}
