<?php

namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;

class AcaoDB
{

    private $schema = '';

    public function __construct()
    {
        $schema = config('database.connections.pgsql.schema');
        $this->schema = $schema ? $schema . '.' : null;
    }

    public function grid()
    {
        $oAcao = DB::table("{$this->schema}seg_acao");
        if ($nome = request('nome', null)) {
            $oAcao->where('nome', 'ilike', "%$nome%");
        }
        return $oAcao->select('id', 'nome as acao', 'descricao');
    }

    /**
     * Retorna todas as dependencias de uma determinada acao
     * no seguinte formato
     * array(
     *   'id' => 'acao_dependencia_id'
     * )
     * @param int
     * @return array
     */
    public function dependencias($acao)
    {
        $sql = DB::table("{$this->schema}seg_dependencia")
            ->where('acao_atual_id', $acao)
            ->select('id', 'acao_dependencia_id')
            ->get();

        $a = array();
        foreach ($sql as $s) {
            $a[$s->id] = $s->acao_dependencia_id;
        }
        return $a;
    }

    /**
     * Retorna todas as ações do banco agrupados pelo seu respectivo grupo
     * no seguinte formato:
     * [
     *      'nome_do_grupo' => [ acao1, acao2, acao3 ],
     *      'nome_do_grupo2' => [ acao4, acao5, acao6 ]
     * ]
     *
     */
    public static function permissoesUsuario($usuario_id)
    {
        //obtendo todos os ids de perfil do usuário logado
        $aPerfis = PerfilDB::perfilSimplificado($usuario_id);

        //se houver perfil de root
        if (in_array('1', $aPerfis)) {
            //retorna todas as ações do banco (não obrigatórias, destaque e não do grupo segurança)
            return SegAcao::where('obrigatorio', false)
                ->where('destaque', true)
//                ->where('grupo', 'like', 'Segurança %') //Grupo segurança destinado apenas para quem possui perfil root
                ->select(['id', 'nome_amigavel', 'grupo', 'descricao'])
                ->orderBy('grupo')
                ->orderBy('nome_amigavel')
                ->get();
        }

        return DB::table('seg_acao as a')
            ->join('seg_permissao as p', 'p.acao_id', '=', 'a.id')
            ->join('seg_perfil as per', 'per.id', '=', 'p.perfil_id')
            ->where('obrigatorio', false)
            ->where('destaque', true)
            ->where('grupo', 'not ilike', 'Segurança %') //Grupo segurança destinado apenas para quem possui perfil root
            ->whereIn('perfil_id', $aPerfis)
            ->groupBy('a.id', 'a.nome_amigavel', 'a.grupo', 'a.descricao')
            ->select(['a.id', 'a.nome_amigavel', 'a.grupo', 'a.descricao'])
            ->orderBy('grupo')
            ->orderBy('nome_amigavel')
            ->get();
    }

    /**
     * Retorna o id de todas as permissões de todos os perfis de um usuário no formato de array
     *
     * @return array
     */
    public static function permissoesUsuarioArray($usuario_id): array
    {
        //obtendo todos os ids de perfil do usuário logado
        $aPerfis = PerfilDB::perfilSimplificado($usuario_id);


        //se houver perfil de root
        if (in_array('1', $aPerfis)) {
            //retorna todas as ações do banco (não obrigatórias, destaque e não do grupo segurança)
            return SegAcao::where('obrigatorio', false)
                ->where('destaque', true)
                ->where('grupo', '!=', 'Segurança') //Grupo segurança destinado apenas para quem possui perfil root
                ->orderBy('grupo')
                ->orderBy('nome_amigavel')
                ->pluck('id')
                ->toArray();
        }

        return DB::table('seg_acao as a')
            ->join('seg_permissao as p', 'p.acao_id', '=', 'a.id')
            ->join('seg_perfil as per', 'per.id', '=', 'p.perfil_id')
            ->where('obrigatorio', false)
//            ->where('destaque', true)
            ->where('grupo', '!=', 'Segurança') //Grupo segurança destinado apenas para quem possui perfil root
            ->whereIn('perfil_id', $aPerfis)
            ->groupBy('a.id', 'a.nome_amigavel', 'a.grupo', 'a.descricao')
            ->orderBy('grupo')
            ->orderBy('nome_amigavel')
            ->pluck('a.id')
            ->toArray();
    }
}
