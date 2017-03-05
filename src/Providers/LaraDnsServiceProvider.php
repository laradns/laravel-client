<?php

namespace LaraDns\Providers;

use LaraDns\Console\Commands\DnsSync;
use Illuminate\Support\ServiceProvider;

class LaraDnsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       $this->commands([
           DnsSync::class
       ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
