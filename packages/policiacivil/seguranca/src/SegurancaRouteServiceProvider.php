<?php

namespace PoliciaCivil\Seguranca;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class SegurancaRouteServiceProvider extends ServiceProvider
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
        $this->mapSegurancaRoutes();
    }

    /**
     * Define seguranca web routes para a aplicação
     * Todas as páginas usando esta regra estão protegidas pelo sistema de permissões
     * do segurança
     */
    protected function mapSegurancaRoutes()
    {
        Route::middleware('seguranca')
            ->namespace($this->namespace)
            ->group(base_path('routes/seguranca.php'));

    }
}
