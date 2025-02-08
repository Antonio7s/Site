<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        // Defina o Gate 'access'
        Gate::define('access', function (User $user) {
            return $user->access_level === 'admin'; // Verifica se o access_level é 'admin'
        });

        // Registre o componente de layout app2
        Blade::component('layouts.app2', 'app2-layout');
    }
}