<?php

namespace App\Models\Facade;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Equipamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EquipamentoDB extends Model
{
    public static function gridEquipamento($id)
    {
        $entrada = DB::table('equipamento as e')
            ->join('tipo as t', 'e.fk_tipo', '=', 't.id')
            ->join('marca as ma', 'e.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'e.fk_modelo', '=', 'mo.id')
            ->select(['e.id', 'e.num_serie', 'e.patrimonio'])
            ->orderBy('e.id')
            ->get();

        return $entrada;
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
