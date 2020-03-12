<?php

namespace App\Models\Facade;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Situacao;
use App\Models\Entity\Equipamento;
use App\Models\Entity\Recebimento;
use App\Models\Paginacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EquipamentoDB extends Model
{
    //index.blade.php
    public static function gridPesquisa($num_serie = null, $num_mov = null, $data_mov = null, $patrimonio = null, $tipo = null, $situacao = null)
    {
        $db = DB::table('recebimento as re')
            ->join('tipo as ti', 're.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 're.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 're.fk_modelo', '=', 'mo.id')
            ->join('tecnico as te', 're.fk_tecnico', '=', 'te.id')
            ->join('unidade as un', 're.fk_unidade', '=', 'un.id')
            ->join('servidor as ser', 're.fk_servidor', '=', 'ser.id')
            ->join('situacao as sit', 're.fk_situacao', '=', 'sit.id')
            ->select(['re.id',
                      're.num_serie',
                      're.num_movimentacao as num_mov',
                      're.data_movimentacao as data_mov',
                      're.patrimonio', //patrimonio vem de equipamento
                      'ti.nome as tipo',
                      'ma.nome as marca',
                      'mo.nome as modelo',
                      'te.nome as tecnico',
                      'un.nome as unidade',
                      'ser.nome as servidor',
                      'sit.nome as situacao'
            ]);

        if ($num_serie) {
            $db->where('num_serie', $num_serie);
        }

        if ($num_mov) {
            $db->where('num_mov', $num_mov);
        }

        if ($data_mov) {
            $db->where('data_mov', $data_mov);
        }

        // if ($patrimonio) {
        //     $db->where('patrimonio', 'ilike',"%$patrimonio%");
        // }

        if ($tipo) {
            $db->where('ti.nome', $tipo);
        }

        if ($situacao) {
            $db->where('situacao', $situacao);
        }

        $aDataTables = Paginacao::dataTables($db, true);

        return $aDataTables;
    }
     
    //entrada.blade.php
    public static function gridEntrada()
    {
        $sql = DB::table('equipamento as e')
            ->join('tipo as ti', 'e.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 'e.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'e.fk_modelo', '=', 'mo.id')
            ->select(['e.id', 
                      'e.num_serie', 
                      'e.patrimonio'])
            ->orderBy('e.id')
            ->get();

        return $sql;
    }
    
    // public static function getEventoByResp($id)
    // {
    //     $evento = DB::table('fontes_conta as fc')
    //         ->join('tipo_evento as te', 'e.fk_tipo_evento', '=', 'te.id')
    //         ->join('tipo_curso as tc', 'e.fk_tipo_curso', '=', 'tc.id')
    //         ->join('realizadores as r', 'fc.fk_realizadores', '=', 'r.id')
    //         ->where('e.fk_tipo_evento', $id)
    //         ->select(['r.nome'])
    //         ->orderBy('r.nome')
    //         ->get();

    //     return $evento;
    // }
}
