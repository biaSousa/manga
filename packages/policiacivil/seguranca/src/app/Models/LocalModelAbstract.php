<?php

namespace PoliciaCivil\Seguranca\App\Models;

class LocalModelAbstract extends AbstractModel
{
    protected $schema;
    protected $connection = 'conexao_padrao';

    public function __construct()
    {
        $schema = config('database.connections.conexao_padrao.schema');
        $conexao = config('connections.conexao_padrao'); //este é o apelido criado em /config/database.php
        $this->schema = !is_null($schema) ? $schema . '.' : null;
        Historico::getInstance()->addConnection($conexao);
    }
}
