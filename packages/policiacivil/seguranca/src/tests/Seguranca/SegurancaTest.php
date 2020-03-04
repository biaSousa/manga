<?php

namespace Tests\Seguranca;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SegurancaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRotasSeguranca()
    {
        $response = $this->get('seguranca/usuario');
        $response->assertStatus(200);
    }

    public function testRotaUsuarioNaoLogado()
    {
        $response = $this->get('seguranca/usuario/home');
        $response->assertStatus(302);
    }
}
