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
    public static function gridPesquisa($patrimonio = null, $num_serie = null, $situacao = null, $tipo = null, $marca = null, $modelo = null,
    $tecnico = null, $servidor = null, $setor = null, $unidade = null, $num_movimentacao = null)
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
            // 're.data_movimentacao',          
            're.num_movimentacao'
        ];

        $db = DB::table('recebimento as re')
            ->join('tipo as ti', 're.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 're.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 're.fk_modelo', '=', 'mo.id')
            ->join('tecnico as te', 're.fk_tecnico', '=', 'te.id')
            ->join('unidade as un', 're.fk_unidade', '=', 'un.id')
            ->join('servidor as ser', 're.fk_servidor', '=', 'ser.id')
            ->join('situacao as sit', 're.fk_situacao', '=', 'sit.id')
            ->join('setor as set', 're.fk_setor', '=', 'set.id')
            ->select($colunas);

        if ($num_serie) {
            $db->where('re.num_serie', $num_serie);
        }

        if ($num_movimentacao) {
            $db->where('re.num_movimentacao', $num_movimentacao);
        }

        // if ($data_movimentacao) {
        //     $db->where('re.data_movimentacao', $data_movimentacao);
        // }

        if ($patrimonio) {
            $db->where('re.patrimonio', 'ilike',"%$patrimonio%");
        }

        if ($tipo) {
            $db->where('ti.nome', $tipo);
        }

        if ($situacao) {
            $db->where('sit.situacao', $situacao);
        }

        // $aDataTables = Paginacao::dataTables($db);

        return $db;
    }

    public static function gridPesquisaa($p)
    {
        $sql= DB::table('recebimento as re') 
                ->join('marca as ma',   're.fk_marca', '=', 'ma.id')
                ->join('modelo as mo',  're.fk_modelo', '=', 'mo.id')
                ->join('tipo as ti',    're.fk_tipo', '=', 'ti.id')
                ->join('setor as se',   're.fk_setor', '=', 'se.id')
                ->join('unidade as un', 're.fk_unidade', '=', 'un.id')
                ->join('situacao as si','re.fk_situacao', '=', 'si.id')
                ->join('tecnico as tec','re.fk_tecnico', '=', 'tec.id')
                ->join('servidor as ser','re.fk_servidor', '=', 'ser.id')

                ->select(['re.id',
                          're.data_movimentacao',
                          're.num_movimentacao',
                          're.patrimonio',
                          'mo.nome as modelo',
                          'ma.nome as marca',
                          'ti.nome as tipo',
                          'se.nome as setor',
                          'un.nome as unidade',
                          'si.nome as situacao',
                          'tec.nome as tecnico',
                          'ser.nome as servidor']);

        if ($p->$patrimonio) {
            $sql->where('re.patrimonio', $p->patrimonio);
        }

        if ($p->$num_serie) {
            $sql->where('re.num_serie', $p->num_serie);
        }

        if ($p->$num_movimentacao) {
            $sql->where('re.num_movimentacao', $p->num_movimentacao);
        }

        if ($p->$tipo) {
            $sql->where('re.fk_tipo', $p->tipo);
        }

        if ($p->$situacao) {
            $sql->where('re.fk_situacao', $p->situacao);
        }

        if ($p->$unidade) {
            $sql->where('re.fk_unidade', $p->unidade);
        }

        $db->orderBy('re.id');
        $db->orderBy('re.num_serie', 'ASC');
        
        return $db;
    }
     
    //entrada.blade.php
    public static function gridAdicionaEntrada($tipo = null, $marca = null, $modelo = null, $num_serie = null, $patrimonio = null)
    {
        $sql = DB::table('equipamento as eq')
            ->join('tipo as ti', 'eq.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 'eq.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'eq.fk_modelo', '=', 'mo.id')
            ->select(['eq.id', 
                      'eq.num_serie', 
                      'eq.patrimonio',
                      'ti.nome as tipo',
                      'ma.nome as marca',
                      'mo.nome as modelo'])
            ->orderBy('eq.id')
            ->get();

            if ($tipo) {
                $sql->where('tipo', $tipo);
            }  

            $aDataTables = Paginacao::dataTables($sql, true);

            return $aDataTables;
    }

    public static function gridOrdemServico($tipo = null, $num_os = null, $data_os = null)
    {
        $sql = DB::table('entrada_ordem_servico as os')
            ->join('unidade as un', 'os.fk_unidade', '=', 'un.id')
            ->join('tipo as ti', 'os.fk_tipo', '=', 'ti.id')
            ->join('setor as se', 'os.fk_setor', '=', 'se.id')
            ->join('tecnico as tec', 'os.fk_tecnico', '=', 'tec.id')
            ->join('servidor as ser', 'os.fk_servidor', '=', 'ser.id')
            ->join('situacao as sit', 'os.fk_situacao', '=', 'sit.id')
            ->select(['os.id',
                      'os.num_os',
                      'os.data_chamado',
                      'os.descricao',
                      'ti.nome as tipo',
                      'se.nome as setor',
                      'tec.nome as tecnico',
                      'ser.nome as servidor',
                      'sit.nome as situacao'
            ]);

        if ($tipo) {
            $sql->where('tipo', $tipo);
        }

        if ($num_os) {
            $sql->where('num_os', $num_os);
        }

        if ($data_chamado) {
            $sql->where('data_chamado', $data_chamado);
        }

        $aDataTables = Paginacao::dataTables($sql, true);

        return $aDataTables;
    }

    public static function getProblema()
    {
        $sql = DB::table('problema as pro')
            ->select(['pro.id','pro.nome'])
            ->orderBy('pro.id')
            ->get();

        return $sql;
    }

    public static function getSituacao()
    {
        $sql = DB::table('situacao as sit')
            ->select(['sit.id','sit.nome'])
            ->orderBy('sit.id')
            ->get();

        return $sql;
    }

    public static function getUnidade()
    {
        $sql = DB::table('unidade as un')
            ->select(['un.id','un.nome'])
            ->orderBy('un.id')
            ->get();

        return $sql;
    }
    
    public static function getSetor()
    {
        $sql = DB::table('setor as se')
            // ->where('fk_unidade', '=', 3)
            ->select(['se.id','se.nome'])
            ->orderBy('se.id')
            ->get();

        return $sql;
    }

    public static function getTecnico()
    {
        $sql = DB::table('tecnico as te')
            ->select(['te.id','te.nome'])
            ->orderBy('te.id')
            ->get();

        return $sql;
    }

    public static function getServidor()
    {
        $sql = DB::table('servidor as se')
            ->select(['se.id','se.nome'])
            ->orderBy('se.id')
            ->get();

        return $sql;
    }

    public static function getTipo()
    {
        $sql = DB::table('tipo as ti')
            ->select(['ti.id','ti.nome'])
            ->orderBy('ti.id')
            ->get();

        return $sql;
    }

    public static function getMarca()
    {
        $sql = DB::table('marca as ma')
            ->select(['ma.id','ma.nome'])
            ->orderBy('ma.id')
            ->get();

        return $sql;
    }

    public static function getModelo()
    {
        $sql = DB::table('modelo as mo')
            ->select(['mo.id','mo.nome'])
            ->orderBy('mo.id')
            ->get();

        return $sql;
    }

    public static function getGarantia()
    {
        $sql = DB::table('garantia as ga')
            ->select(['ga.id','ga.nome'])
            ->orderBy('ga.id')
            ->get();

        return $sql;
    }
}
