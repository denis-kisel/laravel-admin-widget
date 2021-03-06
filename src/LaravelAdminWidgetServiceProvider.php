<?php

namespace DenisKisel\LaravelAdminWidget;

use DenisKisel\LaravelAdminWidget\Commands\FixGetKeyNestedForm;
use DenisKisel\LaravelAdminWidget\Commands\MakeAdminWidget;
use Illuminate\Support\ServiceProvider;

class LaravelAdminWidgetServiceProvider extends ServiceProvider
{
    protected $commands = [
        MakeAdminWidget::class,
        FixGetKeyNestedForm::class
    ];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'deniskisel');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'deniskisel');
//        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register the service the package provides.
        $this->app->singleton('laravel-admin-widget', function ($app) {
            return new LaravelAdminWidget;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laraveladminwidget'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing example file
        $this->publishes([
            __DIR__ . '/../resources/example/' => app_path('Admin/Controllers/Widgets/'),
        ]);

        $this->publishes([
            __DIR__ . '/../database/migrations/create_widgets_table.php' => database_path('migrations/' . date('Y_m_d_His_') . 'create_widgets_table.php'),
        ]);

        $this->prepareRoute();
//         Registering package commands.
        $this->commands($this->commands);
    }

    protected function prepareRoute()
    {
        $content = file_get_contents(app_path('Admin/routes.php'));

        if (strpos($content, 'Widget routes') === false) {
            $replace = '], function (Router $router) {';
            $replaceOn = <<<EOT
], function (Router \$router) {
    /*
    * Widget routes
    */
EOT;
            $content = str_replace($replace, $replaceOn, $content);
            file_put_contents(app_path('Admin/routes.php'), $content);
        }
    }
}
