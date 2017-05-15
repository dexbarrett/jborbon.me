<?php

namespace DexBarrett\Providers;

use DexBarrett\ShortCode;
use Illuminate\Support\ServiceProvider;
use Maiorano\Shortcodes\Manager\ShortcodeManager;

class ShortCodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ShortcodeManager::class, function ($app) {
            return $this->registerShortCodes();
        });
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
        $manager = new ShortcodeManager;

        $fileSystem = $this->app['files'];
        $shortcodeFiles = $fileSystem->files(app_path('Shortcodes'));

        foreach ($shortcodeFiles as $file) {
            $className = 'DexBarrett\\Shortcodes\\' . basename($file, '.php');
            $manager->register(new $className);
        }

        return $manager;
    }
}