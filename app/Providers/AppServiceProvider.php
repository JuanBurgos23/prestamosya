<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        $this->register();

        Gate::define('prestamista', function ($user) {
            return $user->hasRole('Prestamista');
        });

        Gate::define('cliente', function ($user) {
            return $user->hasRole('Cliente');
        });
    }
}
