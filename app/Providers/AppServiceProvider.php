<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();

        // Validasi khusus untuk memastikan durasi lebih dari 0
        Validator::extend('greater_than_zero', function ($attribute, $value, $parameters, $validator) {
            return $value > 0;
        });

        // Pesan kustom untuk validasi
        Validator::replacer('greater_than_zero', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute harus lebih dari 0.');
        });
    }
}
