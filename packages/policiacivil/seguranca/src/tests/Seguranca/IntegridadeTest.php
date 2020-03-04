<?php
namespace Test\Seguranca;

use Tests\TestCase;

/**
 * O teste desta classe serve apenas para uma instalação nova, pois os arquivos testados podem
 * ser personalizados em cada sistema sem nenhum problema, porém esta modificação muda o hash de integridade
 * @package Test\Seguranca
 */
class IntegridadeTest extends TestCase
{

    public function testKernel()
    {
        $this->assertEquals('2b934a1a0d37df1a414b0ecd7e1ecf13f4b3c061', sha1_file(app_path('Http/Kernel.php')));
    }

    public function testProvider()
    {
        $this->assertEquals('b2744a43d934a25f3daf77d77266997f3808d67e', sha1_file(app_path('Providers/RouteServiceProvider.php')));
    }

    public function testConfig()
    {
        $this->assertEquals('d4a4c0d26d62834ac0b4de234cb68add34248390', sha1_file(config_path('app.php')));
        $this->assertEquals('9314fb40609c0c2ae30945a01466c12d92222a8c', sha1_file(config_path('auth.php')));
        $this->assertEquals('1e657edfd430727f0968abfdcc5811f6b81342f4', sha1_file(config_path('database.php')));

        $sistema = config('policia.codigo');
        if($sistema === 32)//o projeto skeleton tem este código configurado como 32, no modelo padrão é zero
            $this->assertEquals('db120cdeae999b826f6c3bdd2ff0b7f8b16c55a1', sha1_file(config_path('policia.php')));
        else
            $this->assertEquals('c785d0b5e7e4f64e18657e8a3eefc09d8df0413b', sha1_file(config_path('policia.php')));
    }

    public function testRoutes()
    {
        $this->assertEquals('c9a166fdb03dbf1e42fce49484a09a34fad3f490', sha1_file(base_path('routes/web.php')));
    }
}