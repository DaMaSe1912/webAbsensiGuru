<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function checkIn(): RedirectResponse
    {
        $guru = auth()->user()->guru;
        $today = Carbon::today();
        $settings = Pengaturan::getSettings();

        if (! $this->isHariKerja($today, $settings)) {
            return back()->with('error', 'Hari ini bukan hari kerja.');
        }

        $jamMasuk = Carbon::now()->format('H:i:s');
        $terlambat = $jamMasuk > $settings->jam_masuk;

        Absensi::updateOrCreate(
            ['guru_id' => $guru->id, 'tanggal' => $today->toDateString()],
            [
                'status' => 'Hadir',
                'jam_masuk' => $jamMasuk,
                'keterangan' => $terlambat ? 'Check-in terlambat' : null,
            ]
        );

        return back()->with('success', 'Check-in berhasil pada '.$jamMasuk);
    }

    public function checkOut(): RedirectResponse
    {
        $guru = auth()->user()->guru;
        $today = Carbon::today();

        $absensi = Absensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (! $absensi || ! $absensi->jam_masuk) {
            return back()->with('error', 'Anda belum melakukan check-in hari ini.');
        }

        $absensi->update(['jam_keluar' => Carbon::now()->format('H:i:s')]);

        return back()->with('success', 'Check-out berhasil.');
    }

    public function riwayat(): View
    {
        $guru = auth()->user()->guru;

        $riwayat = Absensi::where('guru_id', $guru->id)
            ->orderByDesc('tanggal')
            ->paginate(20);

        return view('guru.riwayat', compact('riwayat'));
    }

    public function izinForm(): View
    {
        return view('guru.izin-form');
    }

    public function izinStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'jenis' => ['required', 'in:Izin,Sakit'],
            'alasan' => ['required', 'string'],
        ]);

        auth()->user()->guru->pengajuanIzin()->create($data);

        return redirect()->route('guru.dashboard')->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    private function isHariKerja(Carbon $date, Pengaturan $settings): bool
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
        $hariKerja = $settings->hari_kerja ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        return in_array($hari, $hariKerja, true);
    }
}
