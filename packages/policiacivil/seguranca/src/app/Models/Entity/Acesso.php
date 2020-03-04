<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use PoliciaCivil\Seguranca\App\Models\SegurancaModelAbstract;

class Acesso extends SegurancaModelAbstract
{
    public $timestamps = false;
    public $table = 'acesso';

    /**
     * Acesso constructor.
     */
    public function __construct()
    {
        $schema = config('database.connections.seguranca.schema');
        $this->table = "$schema.$this->table";
    }


}
