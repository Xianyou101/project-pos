<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan perubahan pada tabel.
     */
    public function up(): void
    {
        Schema::table('nama_tabel', function (Blueprint $table) {
            // Contoh: $table->boolean('is_featured')->default(false)->after('is_active');
        });
    }

    /**
     * Batalkan perubahan jika di-rollback.
     */
    public function down(): void
    {
        Schema::table('nama_tabel', function (Blueprint $table) {
            // Contoh: $table->dropColumn('is_featured');
        });
    }
};
