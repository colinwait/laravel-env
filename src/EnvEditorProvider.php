<?php

namespace Colinwait\EnvEditor;

use Colinwait\EnvEditor\Http\Middleware\AuthMiddleware;
use Colinwait\EnvEditor\Services\EnvService;
use Illuminate\Support\ServiceProvider;

class EnvEditorProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('cw-env-editor', EnvService::class);
    }

    public function boot()
    {
        $this->app['router']->middleware('env.auth', AuthMiddleware::class);
        require __DIR__ . '/Http/routes.php';

        $this->loadViewsFrom(__DIR__ . '/views', 'env-editor');
        $this->publishes(
            [__DIR__ . '/views' => base_path('resources/views/vendor/env-editor')],
            'views'
        );

        $this->publishes(
            [__DIR__ . '/config' => config_path()],
            'config'
        );
    }
}