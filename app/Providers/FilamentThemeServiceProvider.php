<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;


class FilamentThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void

    {
        $themeAssets = (array) config('theme.assets', []); // Dipaksa array
        $extraAssets = []; // Ini juga array

        $assets = array_merge($themeAssets, $extraAssets); // Sekarang aman

        foreach ($assets as $asset) {
            // proses asset (jika ada)
        }

        $this->publishes([
            __DIR__ . '/../../resources/dist' => public_path('vendor/theme'),
        ], 'public');

        // ✅ Tambahkan warna custom Filament
        FilamentColor::register([
            'primary' => '#0ea5e9',
            'success' => '#10b981',
            'danger' => '#ef4444',
            'warning' => '#f59e0b',
            'info' => '#3b82f6',
        ]);
    }
}
