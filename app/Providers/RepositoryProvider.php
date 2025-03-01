<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected array $repos = [
        \App\Contracts\UserContract::class => \App\Repositories\UserRepository::class
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach($this->repos as $abstract => $concrete)
        {
            $this->app->singleton($abstract , $concrete);
        }
    }
}
