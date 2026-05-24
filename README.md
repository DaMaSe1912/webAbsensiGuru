# Web Absensi Guru — Laravel 11

Aplikasi web untuk mencatat dan mengelola kehadiran guru di sekolah.

## Fitur

| Modul | Admin | Guru |
|-------|:-----:|:----:|
| Login & redirect per role | ✓ | ✓ |
| Dashboard statistik & grafik | ✓ | ✓ |
| CRUD data guru | ✓ | — |
| Rekap & edit absensi | ✓ | — |
| Check-in / check-out | — | ✓ |
| Riwayat kehadiran | ✓ | ✓ |
| Pengajuan izin | setujui/tolak | ajukan |
| Laporan PDF & Excel (CSV) | ✓ | — |
| Pengaturan sekolah & jam kerja | ✓ | — |

## Persyaratan

- PHP 8.2+
- Composer
- MySQL (Laragon)
- Ekstensi PHP: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`

## Instalasi (Laragon)

1. Clone/ekstrak ke `C:\laragon\www\absensi-guru`

2. Buat database MySQL:
   ```sql
   CREATE DATABASE absensi_guru CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. Install dependency:
   ```bash
   composer install
   ```

4. Environment:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

5. Sesuaikan `.env` (default Laragon):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=absensi_guru
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
   > Laragon Anda memakai password MySQL `root`. Jika berbeda, sesuaikan di `.env`.

6. Migrasi & data demo:
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   ```

7. Jalankan:
   ```bash
   php artisan serve
   ```
   Buka http://127.0.0.1:8000

## Akun Demo

| Peran | Email | Password |
|-------|-------|----------|
| Admin | admin@sekolah.test | password |
| Guru | budi@sekolah.test | password |

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
