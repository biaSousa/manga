<?php

namespace Tests\Seguranca;

use Tests\TestCase;

/**
 * Testa todos os arquivos necessários para o funcionamento correto do Segurança
 * @package Tests\Feature
 */
class ArquivosSegurancaTest extends TestCase
{
    public function testBootstrap()
    {
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap.css')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap.css.map')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap.min.css')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap.min.css.map')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap-theme.css')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap-theme.css.map')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap-theme.min.css')));
        $this->assertTrue(file_exists(public_path('bootstrap/css/bootstrap-theme.min.css.map')));
        $this->assertTrue(file_exists(public_path('bootstrap/fonts/glyphicons-halflings-regular.eot')));
        $this->assertTrue(file_exists(public_path('bootstrap/fonts/glyphicons-halflings-regular.svg')));
        $this->assertTrue(file_exists(public_path('bootstrap/fonts/glyphicons-halflings-regular.ttf')));
        $this->assertTrue(file_exists(public_path('bootstrap/fonts/glyphicons-halflings-regular.woff')));
        $this->assertTrue(file_exists(public_path('bootstrap/fonts/glyphicons-halflings-regular.woff2')));
        $this->assertTrue(file_exists(public_path('bootstrap/js/bootstrap.js')));
        $this->assertTrue(file_exists(public_path('bootstrap/js/bootstrap.min.js')));
        $this->assertTrue(file_exists(public_path('bootstrap/js/bootstrap-native.min.js')));
        $this->assertTrue(file_exists(public_path('bootstrap/js/npm.js')));
    }

    public function testDataTables()
    {
        $this->assertTrue(file_exists(public_path('datatables/datatables.min.css')));
        $this->assertTrue(file_exists(public_path('datatables/datatables.min.js')));
        $this->assertTrue(file_exists(public_path('datatables/pt-br.txt')));
    }

    public function testCss()
    {
        $this->assertTrue(file_exists(public_path('css/app.css')));
        $this->assertTrue(file_exists(public_path('css/normalize.css')));
        $this->assertTrue(file_exists(public_path('css/paper.css')));
    }

    public function testImagens()
    {
        $this->assertTrue(file_exists(public_path('images/brasao_policia.jpg')));
        $this->assertTrue(file_exists(public_path('images/estado.jpg')));
        $this->assertTrue(file_exists(public_path('images/male2.png')));
        $this->assertTrue(file_exists(public_path('images/policia2.png')));
    }

    public function testJs()
    {

        //controllers
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/controllers/AdminUsuarioController.js')));
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/controllers/CriarUsuarioController.js')));
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/controllers/EditarUsuarioController.js')));

        //models
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/models/Ajax.js')));
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/models/Validacao.js')));
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/models/View.js')));

        //view
        $this->assertTrue(file_exists(base_path('resources/assets/js/app/view/Mensagem.js')));

        $this->assertTrue(file_exists(public_path('js/jquery.js')));
    }

    public function testConstantes()
    {
        $this->assertTrue(file_exists(config_path('policia.php')));
    }

    public function testMigrations()
    {
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_061131_create_seg_acao_table.php')));
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_062137_create_seg_dependencia_table.php')));
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_074605_create_seg_perfil_table.php')));
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_074828_create_seg_grupo_table.php')));
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_075125_create_seg_historico_table.php')));
        $this->assertTrue(file_exists(database_path('migrations/2016_05_03_075732_create_seg_menu_table.php')));
    }

    public function testSeeds()
    {
        $this->assertTrue(file_exists(database_path('seeds/SegAcaoLocalTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegAcaoTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegDependenciaTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegGrupoLocalTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegGrupoTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegMenuLocalTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegMenuTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegPerfilLocalTableSeeder.php')));
        $this->assertTrue(file_exists(database_path('seeds/SegPerfilTableSeeder.php')));

    }

    public function testControllers()
    {
        $this->assertTrue(file_exists(app_path('Seguranca/Controllers/AcaoController.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Controllers/MenuController.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Controllers/PerfilController.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Controllers/UsuarioController.php')));
        $this->assertTrue(file_exists(app_path('Http/Controllers/UsuarioLocalController.php')));
    }

    public function testFacade()
    {
        $this->assertTrue(file_exists(app_path('Models/Facade/UsuarioLocalDB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Facade/AcaoDB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Facade/MenuDB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Facade/PerfilDB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Facade/PermissaoDB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Facade/UsuarioDB.php')));
    }

    public function testHelpers()
    {
        $this->assertTrue(file_exists(app_path('Seguranca/Helpers/helpers.php')));
    }

    public function testMiddleware()
    {
        $this->assertTrue(file_exists(app_path('Seguranca/Middleware/Autorizacao.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Middleware/Menu.php')));
    }

    public function testModels()
    {
        $this->assertTrue(file_exists(app_path('Seguranca/Models/AbstractModel.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/DB.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Formatar.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Historico.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/LocalModelAbstract.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Paginacao.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/SegurancaModelAbstract.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Util.php')));

        //Regras
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Regras/UsuarioRegras.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Regras/PerfilRegras.php')));

        //Entity
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/Acesso.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegAcao.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegDependencia.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegGrupo.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegHistorico.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegMenu.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegPerfil.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/SegPermissao.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/Sistema.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/Usuario.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Models/Entity/UsuarioSistema.php')));

        //arquivos que estão na raiz do segurança
        $this->assertTrue(file_exists(app_path('Seguranca/routes.php')));
    }

    public function testProviders()
    {
        $this->assertTrue(file_exists(app_path('Seguranca/Providers/SegurancaServiceProvider.php')));
    }

    public function testRequests()
    {
        $this->assertTrue(file_exists(app_path('Http/Requests/UsuarioLocalRequest.php')));

        $this->assertTrue(file_exists(app_path('Seguranca/Requests/AcaoRequest.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Requests/AtualizarSenhaRequest.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Requests/LoginRequest.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Requests/MenuRequest.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Requests/PerfilRequest.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/Requests/UsuarioRequest.php')));
    }

    public function testViewsLocal()
    {
        //layouts
        $this->assertTrue(file_exists(resource_path('views/layouts/datatables.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/datatables-simples.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/datatables-simples2.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/default.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/menu.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/layouts/submenu.blade.php')));
        //usuario
        $this->assertTrue(file_exists(resource_path('views/usuario/cadastrar.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/usuario/editar.blade.php')));
        $this->assertTrue(file_exists(resource_path('views/usuario/index.blade.php')));
    }

    public function testLang()
    {
        $this->assertTrue(file_exists(resource_path('lang/pt-br/validation.php')));
    }

    public function testViewsSeguranca()
    {
        //acao
        $this->assertTrue(file_exists(app_path('Seguranca/views/acao/editar.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/acao/index.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/acao/novo.blade.php')));

        //menu
        $this->assertTrue(file_exists(app_path('Seguranca/views/menu/editar.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/menu/index.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/menu/novo.blade.php')));

        //perfil
        $this->assertTrue(file_exists(app_path('Seguranca/views/perfil/editar.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/perfil/index.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/perfil/novo.blade.php')));

        //usuario
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/admin.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/alterar-senha.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/datatables-usuarios.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/editar.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/editar-ajuda.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/home.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/index.blade.php')));
        $this->assertTrue(file_exists(app_path('Seguranca/views/usuario/novo.blade.php')));
    }

    public function testRoutes()
    {
        $this->assertTrue(file_exists(base_path('routes/seguranca.php')));
    }

    public function testExclusaoArquivos()
    {
        $sistema = config('policia.codigo');

        if ($sistema !== 32)//o projeto skeleton não pode deletar esta pasta
        {
            $this->assertFalse(file_exists(app_path('Seguranca/instalacao')));
        }

        $this->assertFalse(file_exists(resource_path('views/welcome.blade.php')));
        $this->assertFalse(file_exists(resource_path('assets/components')));
        $this->assertFalse(file_exists(resource_path('assets/app.js')));
        $this->assertFalse(file_exists(resource_path('assets/bootstrap.js')));
        $this->assertFalse(file_exists(resource_path('sass')));
        $this->assertFalse(file_exists(base_path('webpack.mix.js')));
    }
}
