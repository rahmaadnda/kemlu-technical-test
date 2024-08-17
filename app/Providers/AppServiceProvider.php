<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\NegaraRepositoryInterface;
use App\Repository\NegaraRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NegaraRepositoryInterface::class, NegaraRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
