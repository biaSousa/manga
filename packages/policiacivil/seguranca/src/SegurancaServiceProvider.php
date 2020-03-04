<?php

namespace PoliciaCivil\Seguranca;

use Illuminate\Support\ServiceProvider;

class SegurancaServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/routes/routes.php';
//        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Seguranca');

        /*
         * Publicando arquivos
         */

        // $this->publishes([
        //     __DIR__ . '/../../config/policia.php' => config_path('policia.php'),
        // ], 'config');

        // $this->publishes([
        //     __DIR__ . '/../../database/seeds' => base_path('database/seeds'),
        // ], 'seeds');

        // $this->publishes([
        //     __DIR__ . '/../../resources/lang/pt-br' => base_path('resources/lang/pt-br'),
        // ], 'lang');

        // $this->publishes([
        //     __DIR__ . '/../../resources/assets' => base_path('resources/assets'),
        // ], 'assets');

        // $this->publishes([
        //     __DIR__ . '/../../tests/Seguranca' => base_path('tests/Seguranca'),
        // ], 'tests');

        // $this->publishes([
        //     __DIR__ . '/../../resources/views/layouts' => resource_path('views/layouts'),
        // ], 'layouts');

        // $this->publishes([
        //     __DIR__ . '/../../resources/views/usuario' => resource_path('views/usuario'),
        // ], 'usuario');

        // $this->publishes([
        //     __DIR__ . '/../Http/Controllers/UsuarioLocalController' => base_path('tests/Seguranca'),
        // ], 'controllers');

    }

     /**
      * Register the application services.
      *
      * @return void
      */
     public function register()
     {
    //     // $this->app->make('PoliciaCivil\Seguranca\App\Http\Controllers\UsuarioLocalController');

    //     if ($this->app->runningInConsole()) {
    //         $this->commands([
    //             InstalarSeguranca::class,
    //         ]);
    //     }
     }
}
