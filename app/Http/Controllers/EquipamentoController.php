<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Setor;
use App\Models\Entity\Modelo;
use App\Models\Entity\Status;
use App\Models\Entity\Unidade;
use App\Models\Entity\Tecnico;
use App\Models\Entity\Servidor;
use App\Models\Entity\Garantia;
use App\Models\Entity\Equipamento;
use App\Models\Facade\EquipamentoDB;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class EquipamentoController extends Controller
{
    public function novoEquipamento()
    {        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $garantia = Garantia::all(['id', 'nome']);
        
        return view('equipamento.novo', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia'));
    }
    //Comparacao de telas
    public function index2()
    {        
        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $garantia = Garantia::all(['id', 'nome']);
        
        return view('equipamento.index2', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia'));
    }
    
    public function entrada()
    {        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $setor    = Setor::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $tecnico  = Tecnico::all(['id', 'nome']);
        $servidor = Servidor::all(['id', 'nome']);
        
        return view('equipamento.entrada', compact ( 'tipo', 'marca', 'setor', 'modelo', 'unidade', 'tecnico', 'servidor'));
    }

    //salva novo equipamento 
    public function createEquipamento(Request $request)
    {
        DB::beginTransaction();
        try{

            $oEquipamento = new Equipamento();
            $oEquipamento->status = 1;
            $oEquipamento->data_compra = date('Y-m-d H:i:s');
            $oEquipamento->fk_tipo     = request('tipo', null);
            $oEquipamento->fk_setor    = request('setor', null);
            $oEquipamento->fk_marca    = request('marca', null);
            $oEquipamento->fk_modelo   = request('modelo', null);
            $oEquipamento->fk_unidade  = request('unidade', null);
            $oEquipamento->fk_garantia = request('garantia', null);
            $oEquipamento->num_serie   = request('num_serie', null);
            $oEquipamento->descricao   = request('descricao', null);
            $oEquipamento->patrimonio  = request('patrimonio', null);
            $oEquipamento->nota_fiscal = request('nota_fiscal', null);
           
            $p = (object) $request->all();

            $oEquipamento->save();

            DB::commit();

            return response()->json(array('msg' => 'Equipamento cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }

    public function saida()
    {        
        return view('equipamento.saida');
    }
    
    public function gridEquipamento(Request $request, $p)
    {
        $p = (object) $request->all();

        return ['data' => EquipamentoDB::gridEquipamento($p)];
    } 
    
    public function salvaCurso(Request $request)
    {
        DB::beginTransaction();

        try {
            $e = (object) $request->all();

            $realizadores = Realizadores::create([
                'nome' => $e->realizadores
            ]);

            $tipoCurso = TipoCurso::create([
                'nome' => $e->tipoCurso
            ]);

            TipoCursoDB::create([
                'fk_realizadores' => $realizadores['id'],
                'fk_tipo_curso'   => $tipoCurso['id'],
            ]);

            DB::commit();

            return reponse()->json(['retorno' => 'sucesso', 'msg' => 'Evento salvo com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return reponse()->json(['retorno' => 'erro', 'msg' => 'Algo inesperado ocorreu. <br>' . $e->getMessage(), 500]);
        }
    }   

    // public function getTipo()
    // {
    //     $pessoa = TipoPessoa::all();
    //     $newPessoa = [];

    //     foreach ($pessoa as $b) {
    //         $newPessoa[$b->id] = $b->nome;
    //     }
    //     return response()->json($newPessoa);
    // }

}
