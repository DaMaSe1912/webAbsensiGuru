<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('Sekolah');
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->time('jam_masuk')->default('07:00:00');
            $table->time('jam_keluar')->default('15:00:00');
            $table->json('hari_kerja')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
