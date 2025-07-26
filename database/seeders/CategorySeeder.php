<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Semen',
            'Batu Bata',
            'Besi',
            'Pasir',
            'Keramik',
            'Cat',
            'Paku',
            'Triplek',
        ];

        foreach ($categories as $name) {
            $slug = Str::slug($name);

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'slug' => $slug,
                    'image' => null, // Upload manual atau abaikan
                    'description' => 'Kategori bahan bangunan: ' . $name,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ Semua kategori berhasil disimpan atau diperbarui.');
    }
}
