<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Semen Tiga Roda 50kg',
                'category_id' => 1,
                'slug' => 'semen-tiga-roda-50kg',
                'stock' => 98,
                'price' => 72000,
                'is_active' => true,
                'image' => 'products/semen.jpg',
                'barcode' => 'SEMEN001',
                'description' => 'Semen berkualitas tinggi untuk konstruksi',
            ],
            [
                'name' => 'Batu Bata Merah',
                'category_id' => 2,
                'slug' => 'batu-bata-merah',
                'stock' => 1000,
                'price' => 700,
                'is_active' => true,
                'image' => 'products/bata.jpg',
                'barcode' => 'BATA001',
                'description' => 'Batu bata merah untuk dinding',
            ],
            [
                'name' => 'Besi Beton Ulir 10mm',
                'category_id' => 3,
                'slug' => 'besi-beton-ulir-10mm',
                'stock' => 200,
                'price' => 75000,
                'is_active' => true,
                'image' => 'products/besi.jpg',
                'barcode' => 'BESI001',
                'description' => 'Besi beton ulir diameter 10mm panjang 12m',
            ],
            [
                'name' => 'Pasir Bangunan 1 Karung',
                'category_id' => 4,
                'slug' => 'pasir-bangunan-1-karung',
                'stock' => 300,
                'price' => 25000,
                'is_active' => true,
                'image' => 'products/pasir.jpg',
                'barcode' => 'PASIR001',
                'description' => 'Pasir cor halus dalam karung',
            ],
            [
                'name' => 'Keramik Roman 40x40',
                'category_id' => 5,
                'slug' => 'keramik-roman-40x40',
                'stock' => 150,
                'price' => 55000,
                'is_active' => true,
                'image' => 'products/keramik.jpg',
                'barcode' => 'KERAMIK001',
                'description' => 'Keramik lantai motif polos 40x40cm',
            ],
            [
                'name' => 'Cat Tembok Dulux 5kg',
                'category_id' => 6,
                'slug' => 'cat-tembok-dulux-5kg',
                'stock' => 50,
                'price' => 98000,
                'is_active' => true,
                'image' => 'products/cat.jpg',
                'barcode' => 'CAT001',
                'description' => 'Cat tembok interior warna putih',
            ],
            [
                'name' => 'Paku 2 Inch',
                'category_id' => 7,
                'slug' => 'paku-2-inch',
                'stock' => 500,
                'price' => 15000,
                'is_active' => true,
                'image' => 'products/paku.jpg',
                'barcode' => 'PAKU001',
                'description' => 'Paku baja 2 inch untuk rangka',
            ],
            [
                'name' => 'Triplek 9mm',
                'category_id' => 8,
                'slug' => 'triplek-9mm',
                'stock' => 80,
                'price' => 75000,
                'is_active' => true,
                'image' => 'products/triplek.jpg',
                'barcode' => 'TRIPLEK001',
                'description' => 'Lembaran triplek untuk plafon dan furnitur',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        $this->command->info('✅ Produk berhasil disimpan atau diperbarui.');
    }
}
