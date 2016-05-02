<?php

namespace DexBarrett\Providers;

use DexBarrett\ShortCode;
use Illuminate\Support\ServiceProvider;

class ShortCodeServiceProvider extends ServiceProvider
{
    protected $shortcodes = ['alert', 'tooltip'];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerShortCodes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    protected function registerShortCodes()
    {
        foreach ($this->shortcodes as $shortcode) {
            $this->app['shortcode']->register($shortcode, "DexBarrett\ShortCode@{$shortcode}");
        }
    }
}