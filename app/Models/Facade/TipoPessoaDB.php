<?php

namespace App\Models\Facade;

use Illuminate\Database\Eloquent\Model;

class TipoPessoaDB extends Model
{
    public static function getPessoa()
    {
        $data = [
            'tp.id',
            'tc.nome as tipo_curso',
            'te.nome as tipo_evento',
        ];

        $sql = DB::table('tipo_pessoa as tp')
            ->join('tipo_curso as tc', 'tc.id', '=', 'tp.fk_tipo_curso')
            ->join('tipo_evento as tp', 'te.id', '=', 'tp.fk_tipo_evento')
            ->orderBy('tp.id');

        $sql->select($data);

        return $sql->get();
    }
}
