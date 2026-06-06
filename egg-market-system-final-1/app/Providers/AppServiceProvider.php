<?php

namespace App\Providers;

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
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE products MODIFY image LONGTEXT NULL');
        } catch (\Exception $e) {
            // Silence when table doesn't compile yet or column is already LONGTEXT
        }
    }
}
