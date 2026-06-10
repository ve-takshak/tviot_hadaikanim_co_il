<?php

namespace Takshak\Alertt;
use Illuminate\Support\ServiceProvider;
use Takshak\Alertt\Alertt\AlerttService;
use Takshak\Alertt\Facades\Alertt;
use Takshak\Alertt\View\Components\Alert;

class AlerttServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'alertt');

        $this->loadViewComponentsAs('alertt', [
            Alert::class,
        ]);
        # component is loaded with '<x-alertt-alert />'

        $this->publishes([
            __DIR__.'/../config/alertt.php' => config_path('alertt.php'),
        ], 'alertt-config');

        $this->publishes([
            __DIR__.'/../resources/views/components/alertt.blade.php' => resource_path('views/components/alertt.blade.php'),
        ], 'alertt-view');
    }   

    public function provides()
    {
       
    }

    public function register()
    {
        $this->app->singleton('alertt', function ($app) {
            return new AlerttService($app['session.store']);
        });
    }

}