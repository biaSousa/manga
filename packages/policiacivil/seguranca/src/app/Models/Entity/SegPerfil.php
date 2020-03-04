<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\LocalModelAbstract;

class SegPerfil extends LocalModelAbstract
{
    protected $table = 'seg_perfil';

    /**
     * Array com todas as permissões do perfil atual
     * @return array
     */
    public function permissoes()
    {
        $sql = DB::connection('conexao_padrao')
            ->table("{$this->schema}seg_permissao")
            ->where('perfil_id', '=', $this->id)
            ->select('id', 'acao_id')
            ->get();

        $a = array();
        foreach ($sql as $s) {
            $a[$s->id] = $s->acao_id;
        }
        return $a;
    }
}
