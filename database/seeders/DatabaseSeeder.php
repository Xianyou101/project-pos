<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Buat user admin jika belum ada
        $admin = User::firstOrCreate(
            ['email' => 'adimasputra101@gmail.com'],
            [
                'name' => 'adimasputra',
                'password' => Hash::make('root'), // Password default
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info("✅ Admin user berhasil dibuat: {$admin->email}");
        } else {
            $this->command->warn("ℹ️ Admin user sudah ada: {$admin->email}");
        }

        // ✅ Jalankan seeder tambahan
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            PaymentMethodSeeder::class, // ✅ Tambahkan seeder metode pembayaran
        ]);
    }
}
