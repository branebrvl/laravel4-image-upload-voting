<?php namespace Sneek\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bind our repository interfaces to the IoC
     */
    public function register()
    {
        $this->app->bind(
            'Sneek\Repositories\AccountRepositoryInterface',
            'Sneek\Repositories\EloquentAccountRepository'
        );
    }
}
