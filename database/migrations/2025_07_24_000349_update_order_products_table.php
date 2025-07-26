<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            // Contoh: tambah kolom diskon per item dan total harga
            $table->integer('discount')->default(0)->after('unit_price'); // diskon per item
            $table->integer('total_price')->nullable()->after('discount'); // total setelah diskon
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->dropColumn(['discount', 'total_price']);
        });
    }
};
