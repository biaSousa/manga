<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use PoliciaCivil\Seguranca\App\Models\LocalModelAbstract;

class SegPermissao extends LocalModelAbstract
{
    protected $table = 'seg_permissao';

    /**
     * Verifica se um determinado perfil ou grupo de perfis pode acessar
     * uma determinada acao
     * @param $query
     * @param $acao
     * @param $aPerfil
     * @return bool
     */
    public function scopePermissao($query, $acao, $aPerfil)
    {
        return $query->where('acao_id', '=', $acao)
            ->whereIn('perfil_id', $aPerfil);
    }
}
