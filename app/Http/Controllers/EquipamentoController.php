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
use App\Models\Entity\Recebimento;
use App\Models\Facade\EquipamentoDB;
use App\Models\Facade\EquipamentoFiltrosDB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class EquipamentoController extends Controller
{
    public function index()
    {        
        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $garantia = Garantia::all(['id', 'nome']);
        
        return view('equipamento.index', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia'));
    }

    public function novoEquipamento(Request $p)
    {        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $garantia = Garantia::all(['id', 'nome']);

        //filtro
        $patrimonio = EquipamentoFiltrosDB::filtroPatrimonioDadosNovoEquipamento($p);
        
        return view('equipamento.novo', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia', 'patrimonio'));
    }

    //salva novo equipamento 
    public function createNovoEquipamento(Request $request)
    {
        DB::beginTransaction();
        try{

            $oEquipamento = new Equipamento();
            $oEquipamento->status = 1;
            $oEquipamento->data_compra = date('Y-m-d H:i:s');
            $oEquipamento->fk_tipo     = request('tipo');
            $oEquipamento->fk_marca    = request('marca');
            $oEquipamento->fk_modelo   = request('modelo');
            $oEquipamento->fk_unidade  = request('unidade');
            $oEquipamento->num_serie   = request('num_serie');
            $oEquipamento->fk_garantia = request('garantia', null);
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

    public function equipamentoEntrada()
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

    public function gridEquipamentoEntrada()
    {
        $tipo   = request('tipo', null);
        $status = request('status', null);
        $modelo = request('modelo', null);
        $data_movimentacao = request('data_movimentacao', null);
        
        //filtro de patrimonio/num_serie tras dados do codigo de barras 
        return ['data' => EquipamentoDB::gridEntrada($patrimonio, $tipo, $modelo, $data_movimentacao)];
        // return response()->json(UsuarioDB::grid($status));
    } 

    //manual
    public function createEquipamentoEntrada(Request $request )
    {
        DB::beginTransaction();
        try{
            $oEntrada = new Recebimento();
            $oEntrada->fk_setor    = request('setor');
            $oEntrada->fk_unidade  = request('unidade');
            $oEntrada->fk_tecnico  = request('tecnico');
            $oEntrada->fk_servidor = request('servidor');
            $oEntrada->telefone    = request('telefone');
            $oEntrada->descricao   = request('descricao', null);
            $oEntrada->data_movimentacao = date('Y-m-d H:i:s');
            $oEntrada->num_movimentacao  = request('num_movimentacao', null);
            
            $p = (object) $request->all();
            // dd($request->all());

            $oEntrada->save();

            DB::commit();

            return response()->json(array('msg' => 'Entrada cadastrada com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }

    //com updateorcreate
    public function createEquipamentoEntradaaaa(Request $request)
    {
        Recebimento::updateOrCreate([
            'about'    => $request->get('about'),
            'setor'    => $setor,
            'unidade'  => $unidade,
            'tecnico'  => $tecnico,
            'servidor' => $servidor,
            'telefone' => $telefone,
            'descricao'=> $descricao,
            'num_movimentacao' => $num_movimentacao,
            'data_movimentacao'=> $data_movimentacao
        ]);
        
        dd($request->all());
        $p = (object) $request->all();

            DB::commit();

            return response()->json(array('msg' => 'Entrada cadastrada com sucesso.'));
       
    }

    public function equipamentoSaida()
    {        
        return view('equipamento.saida');
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
}
