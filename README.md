# Web Absensi Guru — Laravel 11

Aplikasi web untuk mencatat dan mengelola kehadiran guru di sekolah.

## Struktur Database

- `users` — autentikasi (role: admin/guru)
- `guru` — profil guru (NIP, mapel, kontak, foto)
- `absensi` — kehadiran harian (status, jam masuk/keluar)
- `pengajuan_izin` — izin/sakit dari guru
- `pengaturan` — profil sekolah, jam kerja

## Struktur Folder Utama

```
app/Http/Controllers/
  Admin/     → Dashboard, Guru, Absensi, Laporan, Pengaturan
  Guru/      → Dashboard, Absensi (check-in/out, izin)
  Auth/      → Login
app/Models/  → User, Guru, Absensi, Pengaturan, PengajuanIzin
resources/views/
  admin/     → Halaman admin
  guru/      → Halaman guru
  auth/      → Login
```

## Screenshot
# Web Absensi Guru — Laravel 11

Aplikasi web untuk mencatat dan mengelola kehadiran guru di sekolah.

## Struktur Database

- `users` — autentikasi (role: admin/guru)
- `guru` — profil guru (NIP, mapel, kontak, foto)
- `absensi` — kehadiran harian (status, jam masuk/keluar)
- `pengajuan_izin` — izin/sakit dari guru
- `pengaturan` — profil sekolah, jam kerja

## Struktur Folder Utama

```
app/Http/Controllers/
  Admin/     → Dashboard, Guru, Absensi, Laporan, Pengaturan
  Guru/      → Dashboard, Absensi (check-in/out, izin)
  Auth/      → Login
app/Models/  → User, Guru, Absensi, Pengaturan, PengajuanIzin
resources/views/
  admin/     → Halaman admin
  guru/      → Halaman guru
  auth/      → Login
```

## Screenshot
