<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #eee; }
        h2, p { margin: 0 0 8px; }
    </style>
</head>
<body>
    <h2>{{ $pengaturan->nama_sekolah }}</h2>
    <p>{{ $pengaturan->alamat }}</p>
    <h3>Laporan Absensi Guru</h3>
    <p>Periode: {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Mapel</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
                <th>% Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->nip ?? '-' }}</td>
                <td>{{ $row->mapel }}</td>
                <td>{{ $row->hadir }}</td>
                <td>{{ $row->izin }}</td>
                <td>{{ $row->sakit }}</td>
                <td>{{ $row->alpa }}</td>
                <td>{{ $row->persentase }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
