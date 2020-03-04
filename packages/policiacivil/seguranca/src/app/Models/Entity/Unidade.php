<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\SegurancaModelAbstract;

class Unidade extends SegurancaModelAbstract
{
    protected $connection = 'conexao_banco_unico';
    protected $table = 'policia.unidade';

    public function unidade()
    {
        // $sql = DB::connection('policia')
        //     ->table("{$this->schema_policia}unidade")
        //     ->where('nome', '=', $this->id)
        //     ->select('id', 'nome')
        //     ->get();

        $sql = DB::table("{$this->schema_policia}unidade as u")
            ->where('id', $this->id)
            ->select(['u.id', 'u.nome'])
            ->get();

        $a = array();
        foreach ($sql as $s) {
            $a[$s->id] = $s->id;
        }
        return $a;
    }
}
