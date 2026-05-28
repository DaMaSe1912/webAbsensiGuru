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

### 1. Login page

awalan untuk web

<p align="center">
  <img src="Screenshot/loginPage.png" width="600">
</p>

### 2. Role Admin

Role yang bertugas untuk mengawasi dan memanajemen data

#### 1. Dashboard (Admin)

<p align="center">
  <img src="Screenshot/dashboardAdmin.png" width="600">
</p>

#### 2. Data Guru (Admin)

<p align="center">
  <img src="Screenshot/dataGuru.png" width="600">
</p>

#### 3. Absensi (Admin)

<p align="center">
  <img src="Screenshot/absensiAdmin.png" width="600">
</p>

#### 4. Laporan (Admin)

<p align="center">
  <img src="Screenshot/laporanAdmin.png" width="600">
</p>

#### 5. Pengajuan Izin (Admin)

<p align="center">
  <img src="Screenshot/pengajuanizinAdmin.png" width="600">
</p>

#### 6. Pengaturan (Admin)

<p align="center">
  <img src="Screenshot/pengaturanAdmin.png" width="600">
</p>

### 3. Role User / Guru

Role yang menggunakan web, bisa menambah data namun tidak memiliki akses yang lebih seperti menghapus atau mengubah data

#### 1. Dashboard (User)

<p align="center">
  <img src="Screenshot/dashboardUser.png" width="600">
</p>

#### 2. Riwayat (User)

<p align="center">
  <img src="Screenshot/riwayatUser.png" width="600">
</p>

#### 3. Pengajuan Izin (User)

<p align="center">
  <img src="Screenshot/pengajuanizinUser.png" width="600">
</p>

## Screenshot (Mobile)

Menampilkan screenshot dalam mobile

### 1. Login page

awalan untuk web dalam mobile

<p align="center">
  <img src="Screenshot/loginPageMobile.jpeg" width="600">
</p>

### 2. Role Admin

tampilan role admin dalam mobile

#### 1. Dashboard (Admin)

<p align="center">
  <img src="Screenshot/dashboardAdminMobile.jpeg" width="600">
</p>

#### 2. Data Guru (Admin)

<p align="center">
  <img src="Screenshot/dataguruMobile.jpeg" width="600">
</p>

#### 3. Absensi (Admin)

<p align="center">
  <img src="Screenshot/absensiAdminMobile.jpeg" width="600">
</p>

#### 4. Laporan (Admin)

<p align="center">
  <img src="Screenshot/laporanAdminMobile.jpeg" width="600">
</p>

#### 5. Pengajuan Izin (Admin)

<p align="center">
  <img src="Screenshot/pengajuanizinAdminMobile.jpeg" width="600">
</p>

#### 6. Pengaturan (Admin)

<p align="center">
  <img src="Screenshot/pengaturanAdminMobile.jpeg" width="600">
</p>

### 3. Role User / Guru

tampilan role user dalam mobile

#### 1. Dashboard (User)

<p align="center">
  <img src="Screenshot/dashboardUserMobile.jpeg" width="600">
</p>

#### 2. Riwayat (User)

<p align="center">
  <img src="Screenshot/riwayatUserMobile.jpeg" width="600">
</p>

#### 3. Pengajuan Izin (User)

<p align="center">
  <img src="Screenshot/pengajuanizinUserMobile.jpeg" width="600">
</p>

## Screenshot tabel data

### 1. Tabel data Absensi

<p align="center">
  <img src="Screenshot/tabelAbsensi.png" width="600">
</p>

### 2. Tabel data Guru

<p align="center">
  <img src="Screenshot/tabelGuru.png" width="600">
</p>

### 3. Tabel data PengajuanIzin

<p align="center">
  <img src="Screenshot/tabelPengajuanIzin.png" width="600">
</p>

### 4. Tabel data Pengaturan

<p align="center">
  <img src="Screenshot/tabelPengaturan.png" width="600">
</p>

### 5. Tabel data Akun

<p align="center">
  <img src="Screenshot/tabelUser.png" width="600">
</p>
