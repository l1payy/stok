<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Obat;

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
        View::composer('*', function ($view) {
            $lowStockCount = Obat::whereColumn('stok_sekarang', '<=', 'stok_minimum')->count();
            $view->with('lowStockCount', $lowStockCount);
        });
    }
}
