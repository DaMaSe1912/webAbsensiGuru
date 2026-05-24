<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'telepon',
        'jam_masuk',
        'jam_keluar',
        'hari_kerja',
    ];

    protected function casts(): array
    {
        return [
            'hari_kerja' => 'array',
        ];
    }

    public static function getSettings(): self
    {
        return static::firstOrCreate([], [
            'nama_sekolah' => 'SMA Negeri 1',
            'jam_masuk' => '07:00:00',
            'jam_keluar' => '15:00:00',
            'hari_kerja' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
        ]);
    }
}
