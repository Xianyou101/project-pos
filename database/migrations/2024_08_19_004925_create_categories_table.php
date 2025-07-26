<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama kategori
            $table->string('slug')->unique(); // URL friendly
            $table->longText('description')->nullable(); // Deskripsi kategori
            $table->boolean('is_active')->default(true); // Status aktif
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
