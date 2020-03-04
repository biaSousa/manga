<?php

namespace Tests\Seguranca;

use Tests\TestCase;

/**
 * Testa todos os arquivos necessários para o funcionamento correto do Segurança
 * @package Tests\Feature
 */
class SintaxeTest extends TestCase
{
    public function testConfig()
    {
        //config
        $this->assertEquals(0, $this->verificarSintaxe(config_path('policia.php')));
    }

    public function testMigration()
    {
        //migration
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_061131_create_seg_acao_table.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_062137_create_seg_dependencia_table.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_074605_create_seg_perfil_table.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_074828_create_seg_grupo_table.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_075125_create_seg_historico_table.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('migrations/2016_05_03_075732_create_seg_menu_table.php')));
    }

    public function testSeeds()
    {
        //seeds
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegAcaoLocalTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegAcaoTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegDependenciaTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegGrupoLocalTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegGrupoTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegMenuLocalTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegMenuTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegPerfilLocalTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/SegPerfilTableSeeder.php')));
        $this->assertEquals(0, $this->verificarSintaxe(database_path('seeds/DatabaseSeeder.php')));
    }

    public function testController()
    {
        //controllers
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Controllers/AcaoController.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Controllers/MenuController.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Controllers/PerfilController.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Controllers/UsuarioController.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Http/Controllers/UsuarioLocalController.php')));
    }

    public function testFacade()
    {
        //Facade
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Models/Facade/UsuarioLocalDB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Facade/AcaoDB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Facade/MenuDB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Facade/PerfilDB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Facade/PermissaoDB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Facade/UsuarioDB.php')));
    }

    public function testHelper()
    {
        //helper
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Helpers/helpers.php')));
    }

    public function testMiddleware()
    {
        //middleware
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Middleware/Autorizacao.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Middleware/Menu.php')));
    }

    public function testModels()
    {
        //models
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/AbstractModel.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/DB.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Formatar.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Historico.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/LocalModelAbstract.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Paginacao.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/SegurancaModelAbstract.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Util.php')));

        //regras
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/Acesso.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegAcao.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegDependencia.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegGrupo.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegHistorico.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegMenu.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegPerfil.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/SegPermissao.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/Sistema.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/Usuario.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Models/Entity/UsuarioSistema.php')));
    }

    public function testRoutes()
    {
        //arquivos que estão na raiz do seguranca
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/routes.php')));
        $this->assertEquals(0, $this->verificarSintaxe(base_path('routes/seguranca.php')));
    }

    public function testProviders()
    {
        //providers
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Providers/SegurancaServiceProvider.php')));
    }

    public function testRequest()
    {
        //requests
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Http/Requests/UsuarioLocalRequest.php')));

        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/AcaoRequest.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/AtualizarSenhaRequest.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/LoginRequest.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/MenuRequest.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/PerfilRequest.php')));
        $this->assertEquals(0, $this->verificarSintaxe(app_path('Seguranca/Requests/UsuarioRequest.php')));

    }

    public function testResources()
    {
        //lang
        $this->assertEquals(0, $this->verificarSintaxe(resource_path('lang/pt-br/validation.php')));
    }

    public function verificarSintaxe($arquivo)
    {
        $output = null;
        $return = null;
        exec("php -l $arquivo", $saida, $retorno);
        return $retorno;
    }
}