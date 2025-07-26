<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Filament\Support\Facades\FilamentColor; // <- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Konfigurasi warna utama untuk Filament
        FilamentColor::register([
            'primary' => '#facc15', // contoh kuning (tailwind yellow-400)
        ]);

        // Konfigurasi Swagger/OpenAPI
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(

                SecurityScheme::http('bearer')
            );
        });
    }
}
