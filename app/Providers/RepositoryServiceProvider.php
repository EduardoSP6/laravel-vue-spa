<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\PropertyRepository::class, \App\Repositories\PropertyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContractRepository::class, \App\Repositories\ContractRepositoryEloquent::class);
    }

}
