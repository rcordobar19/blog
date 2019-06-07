<?php

namespace MetaGameTechnologies\Blog;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->make('MetaGameTechnologies\Blog\Http\Controllers\AdminPanelController');
        $this->app->make('MetaGameTechnologies\Blog\Http\Controllers\PostsController');
        $this->app->make('MetaGameTechnologies\Blog\Http\Controllers\BlogController');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'blog');
        $this->publishes([
            __DIR__.'/config/blog.php' => config_path('blog.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/metagame/blog'),
        ], 'views');

        $this->publishes([
            __DIR__.'/public' => public_path('vendor/blog'),
        ], 'public');
    }
}
