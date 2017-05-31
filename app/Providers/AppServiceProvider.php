<?php

namespace DexBarrett\Providers;

use DexBarrett\Services\Imgur\Imgur;
use Illuminate\Support\ServiceProvider;
use Imgur\Client as ImgurClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerImgurClient();
        $this->registerImgurService();
    }

    protected function registerImgurClient()
    {
        $this->app->singleton('imgurClient', function ($app) {
            $imgurClient = new ImgurClient;
            $imgurClient->setOption('client_id', config('imgur.client_id'));
            $imgurClient->setOption('client_secret', config('imgur.client_secret'));

            return $imgurClient;
        });

        $this->app->alias('imgurClient', Imgur::class);        
    }

    protected function registerImgurService()
    {
        $this->app->singleton('imgur', function($app) {
            return new Imgur($app['imgurClient']);
        });

        $this->app->alias('imgur', Imgur::class);
    }
}
