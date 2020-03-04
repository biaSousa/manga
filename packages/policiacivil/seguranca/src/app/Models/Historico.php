<?php

namespace PoliciaCivil\Seguranca\App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use PoliciaCivil\Seguranca\App\Models\Entity\SegHistorico;

/**
 * Class Historico
 * Criado em 2016-03-07
 * @package PoliciaCivil\Seguranca\App\Models
 */
class Historico
{
    static $_instance;
    private $_after;
    private $_before;
    private $_aConexoes;

    /**
     * Historico constructor.
     */
    private function __construct()
    {
        $this->_after = [];
        $this->_before = [];
        $this->_aConexoes = [];
    }

    /**
     * Retorna uma instância de Histórico.
     * @return Historico
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }
        return self::$_instance;
    }

    /**
     *
     * @param $table string nome da tabela que terá uma nova linha
     * @param $new array itens que serão incluídos na nova linha
     */
    public function insert($table, array $new)
    {
        array_push(
            $this->_after,
            ['action' => 'I', 'table' => $table, 'data' => $new]
        );
    }

    /**
     * Faz o log do update. Tudo o que for modificado e seus valores antes e depois da atualização
     * @param $table string nome da tabela
     * @param $old array itens antes de serem modificados
     * @param $new array itens depois de serem modificados
     * @param $where string valor da chave primária
     */
    public function update($table, array $old, array $new, $where)
    {
        //removendo dados do tipo resource (binário) do histórico (eles causam bug no log, pois quebram a string json que será formada)
        foreach ($old as $k => $a) {
            if (is_resource($a)) {
                unset($old[$k]);
            }

        }

        //criando o estado anterior dos dados
        array_push(
            $this->_before,
            [
                'action' => 'U',
                'table' => $table,
                'data' => $old,
                'condition' => $where,
            ]
        );

        //salvando o estado posterior dos dados
        array_push(
            $this->_after,
            [
                'action' => 'U',
                'table' => $table,
                'data' => $new,
                'condition' => $where,
            ]
        );
    }

    /**
     * Registra a remoção de um determinado registro
     * @param $table string nome da tabela
     * @param $old array itens que serão incluídos na nova linha
     */
    public function delete($table, array $old)
    {
        array_push(
            $this->_before,
            ['action' => 'D', 'table' => $table, 'data' => $old]
        );
    }

    public function beginTransaction()
    {
        foreach ($this->_aConexoes as $c) {
            DB::connection($c)->beginTransaction();
        }
    }

    public function commit()
    {
        //descobrindo o id da ação
        //        $acao_id = SegAcao::where('nome', Route::getFacadeRoot()->current()->uri())->first(['id'])->id;
        //        dd(Route::getFacadeRoot()->current()->uri());
        $oAcao = new \stdClass();
        if (config('app.env') === 'testing') {
            $oAcao->id = 1;
        } else {
//            dd(SegAcao::pesquisarPorNome(optional(Route::getFacadeRoot()->current())->uri())->first());
            $oAcao = SegAcao::pesquisarPorNome(Route::getFacadeRoot()->current()->uri())->first();
        }

        $oHistorico = new SegHistorico();

        if (config('app.env')) {//No teste o usuário padrão no log é o administrador
            $oHistorico->usuario_id = 1;
        } else {
            $oHistorico->usuario_id = Auth::user()->id;
        }
        $oHistorico->acao_id = $oAcao->id;
        $oHistorico->dt_historico = date('Y-m-d H:i:s');
        $oHistorico->ip = Request::ip();

        if (!empty($this->_before)) {
            $oHistorico->antes = $this->_before;
        }
        if (!empty($this->_after)) {
            $oHistorico->depois = $this->_after;
        }

        try {
            $oHistorico->desabilitarLog();
            $oHistorico->save();
        } catch (\Exception $e) {
            throw new \Exception('Não foi possível criar log desta ação ' . $e->getMessage());
        }
    }

    /**
     * Commits feitos sem trasação limpam o cache do histórico após o commit
     */
    public function commitAndClean()
    {
        $this->commit();
        foreach ($this->_aConexoes as $c) {
            DB::connection($c)->commit();
        }
        $this->_after = [];
        $this->_before = [];
        $this->_aConexoes = [];
    }

    public function rollback()
    {
        foreach ($this->_aConexoes as $c) {
            DB::connection($c)->rollback();
        }
    }

    /**
     * Recebe dos construtores das classes abstratas o apelidos das conexões abertas
     * em caso de rollback ou commit todas elas receberão commit ou rollback
     * @param $c
     */
    public function addConnection($c)
    {
        if (!in_array($c, $this->_aConexoes)) {
            $this->_aConexoes[] = $c;
        }
    }
}
