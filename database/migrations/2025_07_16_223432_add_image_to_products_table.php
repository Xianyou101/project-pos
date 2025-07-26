<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom baru atau ubah tabel products.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Contoh penambahan kolom baru
            // $table->boolean('is_featured')->default(false)->after('is_active');

            // Contoh pengubahan kolom (jika menggunakan doctrine/dbal)
            // $table->string('name', 150)->change();
        });
    }

    /**
     * Kembalikan perubahan ke semula.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Rollback dari perubahan di atas
            // $table->dropColumn('is_featured');
        });
    }
};
