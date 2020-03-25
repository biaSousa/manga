<?php

namespace App\Models\Facade;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Garantia;
use App\Models\Entity\Situacao;
use App\Models\Entity\Equipamento;
use App\Models\Entity\Recebimento;
use App\Models\Paginacao;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EquipamentoDB extends Model
{
    //index.blade.php
    public static function gridPesquisa($patrimonio = null, $num_serie = null, $situacao = null, $tipo = null, $marca = null, 
    $modelo = null, $tecnico = null, $servidor = null, $setor = null, $unidade = null, $num_movimentacao = null)
    {
        $colunas = [
            're.id',
            're.patrimonio',
            're.num_serie',
            'sit.nome as situacao',
            'ti.nome as tipo',
            'ma.nome as marca',
            'mo.nome as modelo',
            'te.nome as tecnico',
            'ser.nome as servidor',
            'set.nome as setor',
            'un.nome as unidade',
            're.num_movimentacao'
        ];

        $db = DB::table('recebimento as re')
            ->join('situacao as sit', 're.fk_situacao', '=', 'sit.id')
            ->join('tipo as ti', 're.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 're.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 're.fk_modelo', '=', 'mo.id')
            ->join('tecnico as te', 're.fk_tecnico', '=', 'te.id')
            ->join('servidor as ser', 're.fk_servidor', '=', 'ser.id')
            ->join('setor as set', 're.fk_setor', '=', 'set.id')
            ->join('unidade as un', 're.fk_unidade', '=', 'un.id')
            ->select($colunas);

        // if ($num_serie) {
        //     $db->where('re.num_serie', $num_serie);
        // }

        // if ($num_movimentacao) {
        //     $db->where('re.num_movimentacao', $num_movimentacao);
        // }

        // if ($data_movimentacao) {
        //     $db->where('re.data_movimentacao', $data_movimentacao);
        // }

        // if ($patrimonio) {
            // $db->where('patrimonio', 'ilike',"%$patrimonio%");
        // }

        // if ($tipo) {
        //     $db->where('ti.nome', $tipo);
        // }

        // if ($situacao) {
        //     $db->where('situacao', $situacao);
        // }

        $aDataTables = Paginacao::dataTables($db, true);

        // echo "<pre>";
        // var_dump($aDataTables);
        // echo "</pre>";

        return $aDataTables;
    }
     
    //entrada.blade.php
    public static function gridEntrada($params)
    {
        $data = [
            'e.id', 
            'e.num_serie', 
            'e.patrimonio',
            'ti.nome as tipo',
            'ma.nome as marca',
            'mo.nome as modelo'
        ];

        $sql = DB::table('equipamento as e')
            ->join('tipo as ti', 'e.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 'e.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'e.fk_modelo', '=', 'mo.id')
            ->select($data)
            ->orderBy('e.id')
            ->get();

            if ($p->$marca){
                $sql->where ('tipo', $tipo);
            }

            if ($p->$modelo){
                $sql->where ('marca', $modelo);
            }

            // if ($tipo) {
            //     $sql->where('tipo', $tipo);
            // }  
        
            // $aDataTables = Paginacao::dataTables($sql, true);
                
            return $sql;
    }
    public static function getSituacao()
    {
        $sql = DB::table('situacao as sit')
            ->select(['sit.id','sit.nome'])
            ->orderBy('sit.nome')
            ->get();

        return $sql;
    }

    public static function getUnidade()
    {
        $sql = DB::table('unidade as un')
            ->select(['un.id','un.nome'])
            ->orderBy('un.nome')
            ->get();

        return $sql;
    }
    
    public static function getSetor()
    {
        $sql = DB::table('setor as se')
            // ->where('fk_unidade', '=', 3)
            ->select(['se.id','se.nome'])
            ->orderBy('se.nome')
            ->get();

        return $sql;
    }

    public static function getTecnico()
    {
        $sql = DB::table('tecnico as te')
            ->select(['te.id','te.nome'])
            ->orderBy('te.nome')
            ->get();

        return $sql;
    }

    public static function getServidor()
    {
        $sql = DB::table('servidor as se')
            ->select(['se.id','se.nome'])
            ->orderBy('se.nome')
            ->get();

        return $sql;
    }

    public static function getTipo()
    {
        $sql = DB::table('tipo as ti')
            ->select(['ti.id','ti.nome'])
            ->orderBy('ti.nome')
            ->get();

        return $sql;
    }

    public static function getMarca()
    {
        $sql = DB::table('marca as ma')
            ->select(['ma.id','ma.nome'])
            ->orderBy('ma.nome')
            ->get();

        return $sql;
    }

    public static function getModelo()
    {
        $sql = DB::table('modelo as mo')
            ->select(['mo.id','mo.nome'])
            ->orderBy('mo.nome')
            ->get();

        return $sql;
    }

    public static function getGarantia()
    {
        $sql = DB::table('garantia as ga')
            ->select(['ga.id','ga.nome'])
            ->orderBy('ga.nome')
            ->get();

        return $sql;
    }
}
