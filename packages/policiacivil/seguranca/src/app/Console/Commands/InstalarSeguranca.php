<?php

namespace PoliciaCivil\Seguranca\App\Console\Commands;

use Illuminate\Console\Command;
use PoliciaCivil\Seguranca\App\Models\Arquivo;

class InstalarSeguranca extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seguranca:instalar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que configura o módulo de segurança no projeto atual. Projetos gerados pelo skeleton já possuem o segurança instalado.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //se os arquivos abaixo já exisitirem eles não serão modificados
        copy(__DIR__ . "/../../../arquivos_instalacao/.env_instalacao", base_path('.env'));
        copy(__DIR__ . "/../../../arquivos_instalacao/database", config_path('database.php'));
        exec('php artisan key:generate'); //gerando chave para o projeto
        exec('php artisan vendor:publish --tag=config'); //publicando arquivo de configuração do projeto
        exec('php artisan vendor:publish --tag=seeds');
        exec('php artisan vendor:publish --tag=lang');
        exec('php artisan vendor:publish --tag=assets');
        exec('php artisan vendor:publish --tag=tests');
        exec('php artisan vendor:publish --tag=layouts');

        //copiando controlador e telas de usuário (sobrescreve arquivos se já existirem)
        copy(__DIR__ . "/../../Http/Controllers/UsuarioLocalController.php", app_path('Http/Controllers/UsuarioLocalController.php'));
        // Arquivo::copy_dir(__DIR__ . "/../../../resources/views/layouts", resource_path('views/layouts'));
        Arquivo::copy_dir(__DIR__ . "/../../../resources/views/usuario_local", resource_path('views/usuario'));

        //modificando arquivo de rota web.php (aponta para o aviso inicial)
        copy(__DIR__ . "/../../../arquivos_instalacao/web", base_path('routes/web.php'));

        //modificando arquivos do projeto
        $arquivoKernel = new Arquivo(app_path('Http/Kernel.php'));
        $a = $arquivoKernel->pesquisar("'api' => ");
        $kernel = Arquivo::toArray(__DIR__ . "/../../../arquivos_instalacao/Kernel");
        $kernel = $arquivoKernel->grudarAntes($a, $kernel);
        Arquivo::criarArquivo(app_path('Http/Kernel.php'), $kernel);

    }
}
