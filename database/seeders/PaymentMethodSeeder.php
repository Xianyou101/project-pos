<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk metode pembayaran.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Tunai',
                'image' => 'payment-methods/tunai.png',
                'is_cash' => true,
            ],
            [
                'name' => 'QRIS',
                'image' => 'payment-methods/qris.png',
                'is_cash' => false,
            ],
            [
                'name' => 'Transfer Bank',
                'image' => 'payment-methods/transfer.png',
                'is_cash' => false,
            ],
            [
                'name' => 'Kartu Kredit',
                'image' => 'payment-methods/kartu-kredit.png',
                'is_cash' => false,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                [
                    'image' => $method['image'],
                    'is_cash' => $method['is_cash'],
                ]
            );
        }
    }
}
