<?php

namespace App\Models\Facade;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Situacao;
use App\Models\Entity\Equipamento;
use App\Models\Entity\Recebimento;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EquipamentoDB extends Model
{
    public static function gridPesquisa()
    {
        $db = DB::table('recebimento as re')
            ->select(['re.id', 're.data_movimentacao']);

        if ($patrimonio) {
            $db->where('patrimonio', 'ilike', "%$patrimonio%");
        }

        if ($data_movimentacao) {
            $db->where('data_movimentacao', $data_movimentacao);
        }

        if ($modelo) {
            $db->join('manga.modelo as mo', 're.fk_modelo', '=', 'mo.id')
                ->where('mo.id', $modelo);
        }

        if ($tipo) {
            $db->join('manga.tipo as t', 're.fk_tipo', '=', 't.id')
                ->where('t.id', $tipo);
        }

        if ($situacao) {
            $db->join('manga.situacao as sit','re.fk_situacao','=','sit.id')
               ->where('sit.id', $situacao);
        }

        $aDataTables = Paginacao::dataTables($db, true);
        
        for($data_movimentacao >= $date ){
            
        }

        return $aDataTables;
    }
     

    public static function gridEntrada()
    {
        $entrada = DB::table('equipamento as e')
            ->join('tipo as t', 'e.fk_tipo', '=', 't.id')
            ->join('marca as ma', 'e.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'e.fk_modelo', '=', 'mo.id')
            ->select(['e.id', 
                      'e.num_serie', 
                      'e.patrimonio'])
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
