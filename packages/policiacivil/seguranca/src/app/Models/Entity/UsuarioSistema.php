<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use PoliciaCivil\Seguranca\App\Models\SegurancaModelAbstract;

class UsuarioSistema extends SegurancaModelAbstract
{
    protected $table = 'seguranca.usuario_sistema';
    public $timestamps = false;
}
