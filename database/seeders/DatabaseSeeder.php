<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Pengaturan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Pengaturan::getSettings();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $guruData = [
            ['nama' => 'Budi Santoso', 'nip' => '198501012010011001', 'mapel' => 'Matematika', 'email' => 'budi@sekolah.test'],
            ['nama' => 'Siti Aminah', 'nip' => '198602152010012002', 'mapel' => 'Bahasa Indonesia', 'email' => 'siti@sekolah.test'],
            ['nama' => 'Ahmad Wijaya', 'nip' => '198703202010013003', 'mapel' => 'IPA', 'email' => 'ahmad@sekolah.test'],
        ];

        foreach ($guruData as $data) {
            $guru = Guru::create([
                ...$data,
                'kontak' => '081234567890',
                'aktif' => true,
            ]);

            User::create([
                'name' => $guru->nama,
                'email' => $guru->email,
                'password' => Hash::make('password'),
                'role' => 'guru',
                'guru_id' => $guru->id,
            ]);

            for ($i = 6; $i >= 0; $i--) {
                $tanggal = Carbon::today()->subDays($i);
                if ($tanggal->isWeekend()) {
                    continue;
                }

                Absensi::create([
                    'guru_id' => $guru->id,
                    'tanggal' => $tanggal->toDateString(),
                    'status' => fake()->randomElement(['Hadir', 'Hadir', 'Hadir', 'Izin', 'Alfa']),
                    'jam_masuk' => '07:15:00',
                    'jam_keluar' => '15:05:00',
                ]);
            }
        }
    }
}
