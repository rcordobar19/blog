<?php

namespace MetaGameTechnologies\Blog;

use Illuminate\Support\ServiceProvider;
use MetaGameTechnologies\Blog\Commands\Install;
use MetaGameTechnologies\Blog\Http\Controllers\AdminPanelController;
use MetaGameTechnologies\Blog\Http\Controllers\BlogController;
use MetaGameTechnologies\Blog\Http\Controllers\PostsController;

class BlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->make(AdminPanelController::class);
        $this->app->make(PostsController::class);
        $this->app->make(BlogController::class);
    }

    public function boot()
    {
        $this->commands([Install::class,]);
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
