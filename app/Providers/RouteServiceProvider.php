<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\View\FileViewFinder;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapRoutes()
    {
        $service = getService();
        if (in_array($service, [APP_SERVICE_ADMIN, APP_SERVICE_PORTAL])) {
            Route::group([
                'middleware' => 'web',
                'namespace' => $this->namespace,
            ], function ($router) use ($service) {
                require base_path('routes/web_' . $service . '.php');
            });
        } else {
            Route::group([
                'middleware' => 'api',
                'namespace' => $this->namespace,
            ], function ($router) use ($service) {
                require base_path('routes/api_' . $service . '.php');
            });
        }
    }
}
