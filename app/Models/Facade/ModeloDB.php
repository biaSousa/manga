<?php

namespace App\Models\Facade;

use App\Models\Entity\Modelo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ModeloDB extends Model
{
    public static function getModelo()
    {
        return Modelo::orderBy('nome')->get(['id', 'nome']);
    }

    public static function getEventoByName($id)
    {
        $evento = DB::table('evento as e')
            ->join('tipo_evento as te', 'e.fk_tipo_evento', '=', 'te.id')
            ->join('tipo_curso as tc', 'e.fk_tipo_curso', '=', 'tc.id')
            ->join('realizadores as r', 'fc.fk_realizadores', '=', 'r.id')
            ->where('e.fk_tipo_evento', $id)
            ->select(['te.id', 'r.nome'])
            ->orderBy('e.nome')
            ->get();

        return $evento;
    }

    public static function getEventoByResp($id)
    {
        $evento = DB::table('fontes_conta as fc')
            ->join('tipo_evento as te', 'e.fk_tipo_evento', '=', 'te.id')
            ->join('tipo_curso as tc', 'e.fk_tipo_curso', '=', 'tc.id')
            ->join('realizadores as r', 'fc.fk_realizadores', '=', 'r.id')
            ->where('e.fk_tipo_evento', $id)
            ->select(['r.nome'])
            ->orderBy('r.nome')
            ->get();

        return $evento;
    }
}
