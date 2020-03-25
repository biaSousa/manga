<?php
namespace App\Models\Facade;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Setor;
use App\Models\Entity\Unidade;
use App\Models\Entity\Tecnico;
use App\Models\Entity\Servidor;
use App\Models\Entity\Equipamento;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class EquipamentoFiltrosDB extends Model
{
    //novo.blade.php
    public static function filtroMarcaNovoEquipamento($p)
    {
        $sql = DB::table('marca as ma')
            ->join('tipo as ti', 'ma.fk_tipo', '=', 'ti.id')
            ->where('ma.fk_tipo','=' ,$p)
            ->select(['ma.id', 'ma.nome'])
            ->orderBy('ma.nome');
        
        return $sql; 
    }

    //novo.blade.php
    public static function filtroModeloNovoEquipamento($id)
    {
        $sql = DB::table('modelo as mo')
            ->join('marca as ma', 'mo.fk_marca', '=', 'ma.id')
            ->where('mo.fk_marca','=' ,$id)
            ->select(['mo.id', 'mo.nome'])
            ->orderBy('mo.nome')
            ->get();
        
        return $sql; 
    }

    //novo.blade.php
    //patrimonio lido do codigo de barras carrega dados
    public static function filtroPatrimonioDadosNovoEquipamento($id)
    {
        $sql = DB::table('equipamento as eq')
            ->join('setor as se', 'eq.fk_setor', '=', 'se.id')
            ->join('unidade as un', 'eq.fk_unidade', '=', 'un.id')
            ->join('tipo as ti', 'eq.fk_tipo', '=', 'ti.id')
            ->join('marca as ma', 'eq.fk_marca', '=', 'ma.id')
            ->join('modelo as mo', 'eq.fk_modelo', '=', 'mo.id')
            ->join('garantia as ga', 'eq.fk_garantia', '=', 'ga.id')
            ->where('eq.patrimonio','=' ,$id)
            ->select(['eq.id',
                      'eq.num_serie',
                      'eq.data_compra',
                      'eq.nota_fiscal',
                      'eq.descricao',
                      'se.nome as setor',
                      'un.nome as unidade',
                      'ti.nome as tipo',
                      'mo.nome as modelo',
                      'ma.nome as marca',
                      'ga.nome as garantia'])
            ->get();

        return $sql; 
    }

    //entrada.blade.php
    public static function filtroUnidadeServidorEntradaEquipamento($id)
    {
        $sql = DB::table('servidor as ser')
            ->join('unidade as u', 'ser.fk_unidade', '=', 'u.id')
            ->where('ser.fk_unidade','=' ,$id)
            ->select(['ser.id', 'ser.fk_unidade'])
            ->get();
        
        return $sql; 
    }

    //entrada.blade.php
    public static function filtroSetorServidorEntradaEquipamento($id)
    {
        $sql = DB::table('servidor as ser')
            ->join('setor as set', 'ser.fk_setor', '=', 'set.id')
            ->where('ser.fk_setor','=' ,$id)
            ->select(['ser.id', 'ser.fk_setor'])
            ->get();
        
        return $sql; 
    }
}
