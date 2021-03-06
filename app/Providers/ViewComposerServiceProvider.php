<?php

namespace DexBarrett\Providers;

use DexBarrett\Tag;
use DexBarrett\PostStatus;
use DexBarrett\PostCategory;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.create-post', 'admin.edit-post'], function($view){
            $view->with('postCategories', PostCategory::orderBy('name')->get()->pluck('name', 'id'));
            $view->with('postStatuses', PostStatus::orderBy('name')->get()->pluck('desc', 'id'));
            $view->with('postTags', Tag::orderBy('name')->get()->pluck('name', 'id'));
        });

        view()->composer(['front.blog.home'], function($view){
            $view->with('categoriesByPostCount', PostCategory::getCategoryList());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
