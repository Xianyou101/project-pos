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
        Schema::table('orders', function (Blueprint $table) {
            // Contoh penambahan kolom:
            // $table->string('invoice_number')->nullable()->after('id');

            // Contoh perubahan kolom:
            // $table->integer('total_price')->default(0)->change();

            // Contoh relasi tambahan:
            // $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Contoh rollback:
            // $table->dropColumn('invoice_number');
            // $table->dropForeign(['user_id']);
            // $table->dropColumn('user_id');
        });
    }
};
