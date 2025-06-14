<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Midtrans\Config; // 1. Tambahkan use statement untuk Midtrans\Config

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // 2. Konfigurasi Midtrans (ambil dari file config/midtrans.php)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false); // Beri nilai default false
        Config::$isSanitized = config('midtrans.is_sanitized', true);  // Beri nilai default true
        Config::$is3ds = config('midtrans.is_3ds', true);        // Beri nilai default true

        // Kode Anda yang sudah ada:
        Paginator::useBootstrapFive();

        Gate::define('admin', function(User $user) {
            return $user->is_admin;
        });

        Gate::define('pengguna', function(User $user) {
            return !$user->is_admin;
        });
        
    }
}