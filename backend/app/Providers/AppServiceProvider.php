<?php

namespace App\Providers;

use Architecture\Infrastructure\Repository\Eloquent\EloquentRepositoryStrategy;
use Architecture\Infrastructure\Repository\Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(Repository::class, function() {
            return new Repository(
                new EloquentRepositoryStrategy()
            );
        });
    }
}
