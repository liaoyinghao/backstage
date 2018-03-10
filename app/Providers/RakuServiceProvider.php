<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RakuServiceProvider extends ServiceProvider
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
        // $this->app->singleton(Connection::class, function ($app) {
        //     return 'raku';
        //     //return new Connection(config('riak'));
        // });
    }
}
