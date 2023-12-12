<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//new 
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
//tablas a mostrar
use App\Models\Alquilere;
use App\Models\Constructora;
use App\Models\Curso;
use App\Models\Deposito;
use App\Models\Gasto;

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
        //new 
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
