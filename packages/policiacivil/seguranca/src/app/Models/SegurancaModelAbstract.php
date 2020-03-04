<?php

namespace PoliciaCivil\Seguranca\App\Models;

class SegurancaModelAbstract extends AbstractModel
{
    protected $schema;
    protected $connection = 'seguranca';

    public function __construct()
    {
        $schema = config('database.connections.seguranca.schema');
        $conexao = config('connections.seguranca');
        $this->schema = !is_null($schema) ? $schema.'.' : null;
        Historico::getInstance()->addConnection($conexao);//este é o apeliado criado em /config/database.php
    }
}
