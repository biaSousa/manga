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
use App\Models\Entity\Situacao;
use App\Models\Entity\Equipamento;
use App\Models\Entity\Recebimento;
use App\Models\Entity\SetorUnidade;
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
        $situacao = Situacao::all(['id', 'nome']);
        
        return view('equipamento.index', compact('tipo', 'marca', 'modelo', 'unidade', 'situacao'));
    }

    //novo.blade.php
    public function novoEquipamento(Request $p)
    {        
        $tipo     = Tipo::all(['id', 'nome']);
        $marca    = Marca::all(['id', 'nome']);
        $modelo   = Modelo::all(['id', 'nome']);
        $unidade  = Unidade::all(['id', 'nome']);
        $garantia = Garantia::all(['id', 'nome']);

        //filtro, busca por patrimonio
        $patrimonio = EquipamentoFiltrosDB::filtroPatrimonioDadosNovoEquipamento($p);
        
        return view('equipamento.novo', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia', 'patrimonio'));
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
        $situacao = Situacao::all(['id', 'nome']);
        
        return view('equipamento.entrada', compact ( 'tipo', 'marca', 'setor', 'modelo', 'unidade', 'tecnico', 'servidor', 'situacao'));
    }

    public function gridPesquisa()
    {
        $patrimonio  = request('patrimonio', null);
        $num_serie   = request('num_serie', null);
        $tipo        = request('tipo', null);
        $situacao    = request('situacao', null);
        $marca       = request('marca', null);
        $modelo      = request('modelo', null);
        $data_mov    = request('data_mov', null);
        $num_mov     = request('num_mov', null);
        $tecnico     = request('tecnico', null);
        $servidor    = request('servidor', null);
        $setor       = request('setor', null);
        $unidade     = request('unidade', null);
        
        return response()->json(EquipamentoDB::gridPesquisa($patrimonio, $num_serie, $situacao, $tipo, $marca, $modelo, $data_mov,
        $num_mov, $tecnico, $servidor, $setor, $unidade));
    } 
  
    //salva novo equipamento com updateOrCreate NOVO
    public function createNovoEquipamento(Request $request)
    {
        DB::beginTransaction();
        try{
                
            $oEquipamento = Equipamento::updateOrCreate([
                'status'     => 1,
                'fk_tipo'    => $request->get('tipo'),
                'fk_marca'   => $request->get('marca'),
                'fk_modelo'  => $request->get('modelo'),
                'fk_unidade' => $request->get('unidade'),
                'fk_garantia'=> $request->get('garantia'),
                'num_serie'  => $request->get('num_serie'),
                'descricao'  => $request->get('descricao'),
                'patrimonio' => $request->get('patrimonio'),
                'nota_fiscal'=> $request->get('nota_fiscal'),
                'data_compra'=> $request->get('data_compra')
            ]);


            // $oEquipamentoTipo = Tipo::firstOrCreate([
            //     'id'=>$id,
            //     'tipo'=>$fk_tipo
            // ]);

            // if($oEquipamentoTipo->wasRecentlyCreated){
            //     echo 'Foi salvo';
            // } else {
            //     echo 'Não foi salvo';
            // }

            //tipo   -> tipo
            //marca  -> tipo / marca 
            //modelo -> marca / modelo
            $p = (object) $request->all();

            $oEquipamento->save();
            DB::commit();

            return response()->json(array('msg' => 'Equipamento cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }

    //salva  nova entrada NOVO
    public function createEquipamentoEntrada(Request $request)
    {
        DB::beginTransaction();
        try{
            $oEntrada = Recebimento::updateOrCreate([
            'fk_setor'     => $request->get('setor'),
            'fk_unidade'   => $request->get('unidade'),
            'fk_tecnico'   => $request->get('tecnico'),
            'fk_servidor'  => $request->get('servidor'),
            'fk_situacao'  => $request->get('fk_situacao'),
            'telefone'     => $request->get('telefone', null),
            'descricao'    => $request->get('descricao', null),
            'num_movimentacao'  => $request->get('num_movimentacao'),
            'data_movimentacao' => $request->get('data_movimentacao')
            ]);

            //encontrar id da linha antes de salvar
            $oEquipamento = Equipamento::updateOrCreate([
                'fk_setor'    => $request->get('setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);

            $oSetorUnidade = SetorUnidade::updateOrCreate([
                'fk_setor'    => $request->get('setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);

            $oSetor = Setor::updateOrCreate([
                'nome'        => $request->get('setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);


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

    // public function equipamentoSaida()
    // {        
    //     return view('equipamento.saida');
    // }

}
