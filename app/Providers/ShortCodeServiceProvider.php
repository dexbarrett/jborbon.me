<?php

namespace DexBarrett\Providers;

use DexBarrett\ShortCode;
use Illuminate\Support\ServiceProvider;

class ShortCodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['shortcode']->register('alert', ShortCode::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }
}