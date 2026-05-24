<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->time('jam_masuk')->nullable()->after('status');
            $table->time('jam_keluar')->nullable()->after('jam_masuk');
            $table->text('keterangan')->nullable()->after('jam_keluar');

            $table->foreign('guru_id')->references('id')->on('guru')->cascadeOnDelete();
            $table->unique(['guru_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropForeign(['guru_id']);
            $table->dropUnique(['guru_id', 'tanggal']);
            $table->dropColumn(['jam_masuk', 'jam_keluar', 'keterangan']);
        });
    }
};
