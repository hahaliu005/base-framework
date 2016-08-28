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
        $this->mapWebRoutes();
        $this->setViewFinder();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $platform = getPlatform();
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) use ($platform) {
            require base_path('routes/web_' . $platform . '.php');
        });
    }

    protected function setViewFinder()
    {
        $viewPath = resource_path(getPlatform() . '/views');

        $finder = new FileViewFinder(app()['files'], [$viewPath, realpath(base_path('resources/views'))]);
        \View::setFinder($finder);
    }

}
