<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\LocalModelAbstract;

class SegAcao extends LocalModelAbstract
{
    protected $table = 'seg_acao';

    /**
     * Verifica todas as ações que servem como dependência para ação atual
     * @return mixed
     */
    public function acoesDependencia()
    {
        return DB::table("{$this->schema}seg_dependencia as d")
            ->join("$this->table as a", 'a.id', '=', 'd.acao_dependencia_id')
            ->where('acao_atual_id', $this->id)
            ->select(['a.id', 'a.nome'])
            ->get();
    }

    /**
     * Retorna uma acao cadastrada pesquisando apenas pelo seu nome
     * @param $query
     * @param $nome
     * @return mixed
     */
    public function scopePesquisarPorNome($query, $nome)
    {
        return $query->where('nome', $nome);
    }

    /**
     * @param [type] $query
     * @return void
     * @deprecated version
     *
     * @deprecated use PerfilDB::destaques()
     */
    public function scopeDestaques($query)
    {
        return $query->where('destaque', true)
            ->where('obrigatorio', false)
            ->orderBy('grupo')
            ->orderBy('nome_amigavel')
            ->select(['id', 'nome_amigavel', 'grupo', 'descricao']);
    }

    //verifica se 'log_acesso = true' em seg_acao e atualiza em seg_historico
    public function acessoLog()
    {
        return DB::table("{$this->schema}seg_historico as sh")
            ->join("{$this->shcema}seg_acao as sa", 'sa.id', '=', 'sh.acao_id')
            ->select(['sa.id', 'sa.nome', 'sa.log_acesso'])
            ->update(['sh.id', 'sh.usuario_id', 'sh_acao.id', 'sh.dt_historico', 'sh.ip'])
            ->where('sa.log_acesso', true)
            ->get();
    }

//    public function podeSerAcessadoPor(Usuario $usuario)
//    {
//        if ($usuario->id === 1) {//usuário sempre pode acessar qualquer coisa
//            return true;
//        } elseif ($usuario->isAdmin()) {//o usuário tem perfil de administrador do sistema
//            return true;
//        } elseif ($this->obrigatorio) {//é uma ação obrigatória a qualquer usuário logado
//            return true;
//        } elseif ($this->acaoLiberada($this->nome)) {//é uma ação que nunca deve ser bloqueada
//            return true;
//        } else {//verifica se um dos perfis do usuário pode acessar
//            $aPerfil = $usuario->listaPerfilSimplificado();
//            return DB::table('seg_perfil')
//                ->whereIn('perfil_id', $aPerfil)
//                ->where('acao_id', $this->id)
//                ->exist();
//        }
//    }

    /**
     * Ações que não podem ser bloqueadas nunca, a nenhum usuário logado, pois podem causar loops infinitos.
     * Extremamente difícil de detectar que este é o erro
     * @param $acao
     * @return bool
     */
    public function acaoLiberada($acao): bool
    {
        //acoes que podem ser executadas independente da situação do usuário
        $acoes = [
            'seguranca/usuario/atualizar-senha',
            'seguranca/usuario/atualizar-dados',
            'seguranca/usuario/logout',
        ];

        return in_array($acao, $acoes);
    }
}
