<?php

namespace App\Providers;

use App\Interfaces\Repository\InterestCalculationRepositoryInterface;
use App\Interfaces\Repository\InterestRateRepositoryInterface;
use App\Interfaces\Service\API\InterestServiceInterface;
use App\Repositories\InterestCalculationRepository;
use App\Repositories\InterestRateRepository;
use App\Services\API\InterestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            InterestServiceInterface::class,
            InterestService::class
        );

        $this->app->bind(
            InterestCalculationRepositoryInterface::class,
            InterestCalculationRepository::class
        );

        $this->app->bind(
            InterestRateRepositoryInterface::class,
            InterestRateRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
