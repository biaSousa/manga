<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use PoliciaCivil\Seguranca\App\Models\LocalModelAbstract;

class SegHistorico extends LocalModelAbstract
{
    protected $table = 'seg_historico';
    public $timestamps = false;

    protected $casts = [
        'antes' => 'array',
        'depois' => 'array',
    ];
}
