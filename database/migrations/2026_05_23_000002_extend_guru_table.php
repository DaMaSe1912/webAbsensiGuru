<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->string('nip')->nullable()->unique()->after('nama');
            $table->string('kontak')->nullable()->after('mapel');
            $table->string('foto')->nullable()->after('kontak');
            $table->boolean('aktif')->default(true)->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn(['nip', 'kontak', 'foto', 'aktif']);
        });
    }
};
