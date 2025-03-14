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

		$this->app->bind(
			\App\Interfaces\ApplicationServiceInterface::class,
			\App\Services\ApplicationService::class
		);

		$this->app->bind(
			\App\Interfaces\ApplicationRepositoryInterface::class,
			\App\Repositories\ApplicationRepository::class
		);

		$this->app->bind(
			\App\Interfaces\BaseRepositoryInterface::class,
			\App\Repositories\BaseRepository::class
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
