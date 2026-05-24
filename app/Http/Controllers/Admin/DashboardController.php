<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\PengajuanIzin;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();

        $stats = [
            'hadir' => Absensi::whereDate('tanggal', $today)->where('status', 'Hadir')->count(),
            'izin' => Absensi::whereDate('tanggal', $today)->whereIn('status', ['Izin', 'Sakit'])->count(),
            'alpa' => Absensi::whereDate('tanggal', $today)->where('status', 'Alfa')->count(),
            'total_guru' => Guru::where('aktif', true)->count(),
        ];

        $belumAbsen = Guru::where('aktif', true)
            ->whereDoesntHave('absensi', fn ($q) => $q->whereDate('tanggal', $today))
            ->orderBy('nama')
            ->limit(10)
            ->get();

        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D, d/m');
            $chartData[] = Absensi::whereDate('tanggal', $date)->where('status', 'Hadir')->count();
        }

        $izinMenunggu = PengajuanIzin::with('guru')
            ->where('status', 'Menunggu')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'belumAbsen', 'chartLabels', 'chartData', 'izinMenunggu'));
    }
}
