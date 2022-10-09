<?php

namespace App\Providers;

use App\Http\Containers\NewsContainer\Contracts\NewsQueryInterface;
use App\Http\Containers\NewsContainer\Contracts\NewsRepositoryInterface;
use App\Http\Containers\NewsContainer\Queries\NewsQueryBuilder;
use App\Http\Containers\NewsContainer\Repositories\NewsRepository;
use App\Http\Containers\UsersContainer\Contracts\UsersQueryInterface;
use App\Http\Containers\UsersContainer\Contracts\UsersRepositoryInterface;
use App\Http\Containers\UsersContainer\Queries\UsersQueryBuilder;
use App\Http\Containers\UsersContainer\Repositories\UsersRepository;
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
            UsersQueryInterface::class,
            UsersQueryBuilder::class,
        );

        $this->app->bind(
            UsersRepositoryInterface::class,
            UsersRepository::class,
        );

        $this->app->bind(
            NewsQueryInterface::class,
            NewsQueryBuilder::class,
        );

        $this->app->bind(
            NewsRepositoryInterface::class,
            NewsRepository::class,
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
