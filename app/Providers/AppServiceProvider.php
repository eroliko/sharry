<?php

namespace App\Providers;

use App\Http\Containers\ActorContainer\Contracts\ActorQueryInterface;
use App\Http\Containers\ActorContainer\Contracts\ActorRepositoryInterface;
use App\Http\Containers\ActorContainer\Queries\ActorQueryBuilder;
use App\Http\Containers\ActorContainer\Repositories\ActorRepository;
use App\Http\Containers\MovieContainer\Contracts\MovieQueryInterface;
use App\Http\Containers\MovieContainer\Contracts\MovieRepositoryInterface;
use App\Http\Containers\MovieContainer\Queries\MovieQueryBuilder;
use App\Http\Containers\MovieContainer\Repositories\MovieRepository;
use App\Http\Containers\PaginationContainer\PaginationService;
use App\Http\Core\Paginator\PaginatorDriver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            MovieQueryInterface::class,
            MovieQueryBuilder::class,
        );

        $this->app->bind(
            MovieRepositoryInterface::class,
            MovieRepository::class,
        );

        $this->app->bind(
            ActorQueryInterface::class,
            ActorQueryBuilder::class,
        );

        $this->app->bind(
            ActorRepositoryInterface::class,
            ActorRepository::class,
        );

        $this->app->bind(
            PaginatorDriver::class,
            PaginationService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
