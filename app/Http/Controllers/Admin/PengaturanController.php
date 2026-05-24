<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\PengajuanIzin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        $pengaturan = Pengaturan::getSettings();

        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'jam_masuk' => ['required', 'date_format:H:i'],
            'jam_keluar' => ['required', 'date_format:H:i'],
            'hari_kerja' => ['nullable', 'array'],
            'hari_kerja.*' => ['string', 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'],
        ]);

        $pengaturan = Pengaturan::getSettings();
        $pengaturan->update($data);

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function izinIndex(): View
    {
        $pengajuan = PengajuanIzin::with('guru')->latest()->paginate(10);

        return view('admin.izin.index', compact('pengajuan'));
    }

    public function izinUpdate(Request $request, PengajuanIzin $pengajuanIzin): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:Disetujui,Ditolak'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $pengajuanIzin->update($data);

        if ($data['status'] === 'Disetujui') {
            $date = $pengajuanIzin->tanggal_mulai->copy();
            while ($date->lte($pengajuanIzin->tanggal_selesai)) {
                \App\Models\Absensi::updateOrCreate(
                    [
                        'guru_id' => $pengajuanIzin->guru_id,
                        'tanggal' => $date->toDateString(),
                    ],
                    [
                        'status' => $pengajuanIzin->jenis,
                        'keterangan' => $pengajuanIzin->alasan,
                    ]
                );
                $date->addDay();
            }
        }

        return back()->with('success', 'Pengajuan izin berhasil diproses.');
    }
}
