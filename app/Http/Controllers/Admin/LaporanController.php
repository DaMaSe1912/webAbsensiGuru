<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        [$dari, $sampai] = $this->parsePeriode($request);

        $rekap = $this->buildRekap($dari, $sampai);

        return view('admin.laporan.index', compact('rekap', 'dari', 'sampai'));
    }

    public function exportPdf(Request $request): Response
    {
        [$dari, $sampai] = $this->parsePeriode($request);
        $rekap = $this->buildRekap($dari, $sampai);
        $pengaturan = Pengaturan::getSettings();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('rekap', 'dari', 'sampai', 'pengaturan'));

        return $pdf->download('laporan-absensi-'.$dari.'-'.$sampai.'.pdf');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        [$dari, $sampai] = $this->parsePeriode($request);
        $rekap = $this->buildRekap($dari, $sampai);

        $filename = 'laporan-absensi-'.$dari.'-'.$sampai.'.csv';

        return response()->streamDownload(function () use ($rekap, $dari, $sampai) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Laporan Absensi Guru', $dari, 's/d', $sampai]);
            fputcsv($handle, []);
            fputcsv($handle, ['Nama', 'NIP', 'Mapel', 'Hadir', 'Izin', 'Sakit', 'Alfa', 'Persentase Hadir (%)']);

            foreach ($rekap as $row) {
                fputcsv($handle, [
                    $row->nama,
                    $row->nip,
                    $row->mapel,
                    $row->hadir,
                    $row->izin,
                    $row->sakit,
                    $row->alpa,
                    $row->persentase,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function parsePeriode(Request $request): array
    {
        $dari = $request->get('dari', Carbon::now()->startOfMonth()->toDateString());
        $sampai = $request->get('sampai', Carbon::today()->toDateString());

        return [$dari, $sampai];
    }

    private function buildRekap(string $dari, string $sampai)
    {
        $totalHari = max(1, Carbon::parse($dari)->diffInDays(Carbon::parse($sampai)) + 1);

        return Guru::query()
            ->where('aktif', true)
            ->leftJoin('absensi', function ($join) use ($dari, $sampai) {
                $join->on('guru.id', '=', 'absensi.guru_id')
                    ->whereBetween('absensi.tanggal', [$dari, $sampai]);
            })
            ->select(
                'guru.id',
                'guru.nama',
                'guru.nip',
                'guru.mapel',
                DB::raw("SUM(CASE WHEN absensi.status = 'Hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN absensi.status = 'Izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN absensi.status = 'Sakit' THEN 1 ELSE 0 END) as sakit"),
                DB::raw("SUM(CASE WHEN absensi.status = 'Alfa' THEN 1 ELSE 0 END) as alpa")
            )
            ->groupBy('guru.id', 'guru.nama', 'guru.nip', 'guru.mapel')
            ->orderBy('guru.nama')
            ->get()
            ->map(function ($row) use ($totalHari) {
                $row->persentase = round(($row->hadir / $totalHari) * 100, 1);

                return $row;
            });
    }
}
