<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected array $repos = [
        \App\Contracts\UserContract::class => \App\Repositories\UserRepository::class,
        \App\Contracts\CategoryContract::class => \App\Repositories\CategoryRepository::class,
        \App\Contracts\PostContract::class => \App\Repositories\PostRepository::class,
        \App\Contracts\CommentContract::class => \App\Repositories\CommentRepository::class,
        \App\Contracts\TagContract::class => \App\Repositories\TagRepository::class,
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
