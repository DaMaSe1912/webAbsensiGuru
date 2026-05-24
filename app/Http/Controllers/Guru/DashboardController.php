<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $guru = auth()->user()->guru;
        $today = Carbon::today();

        $absensiHariIni = Absensi::where('guru_id', $guru->id)
            ->whereDate('tanggal', $today)
            ->first();

        $riwayat = Absensi::where('guru_id', $guru->id)
            ->whereBetween('tanggal', [$today->copy()->subDays(6), $today])
            ->orderByDesc('tanggal')
            ->get();

        return view('guru.dashboard', compact('guru', 'absensiHariIni', 'riwayat'));
    }
}
