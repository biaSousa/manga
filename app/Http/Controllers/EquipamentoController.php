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
use App\Models\Paginacao;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class EquipamentoController extends Controller
{
    public function index()
    {   
        $tipo     = EquipamentoDB::getTipo();
        $situacao = EquipamentoDB::getSituacao();
        
        return view('equipamento.index', compact('tipo', 'situacao'));
    }

    //novo.blade.php
    public function novoEquipamento(Request $p)
    {        
        $tipo     = EquipamentoDB::getTipo();
        $marca    = EquipamentoDB::getMarca();
        // $marca = EquipamentoFiltrosDB::filtroMarcaNovoEquipamento($p);
        $modelo   = EquipamentoDB::getModelo();
        $unidade  = EquipamentoDB::getUnidade();
        $garantia = EquipamentoDB::getGarantia();

        // $patrimonio = EquipamentoFiltrosDB::filtroPatrimonioDadosNovoEquipamento($id);
        
        return view('equipamento.novo', compact('tipo', 'marca', 'modelo', 'unidade', 'garantia', 'patrimonio'));
    }

    public function equipamentoEntrada()
    {        
        //busca a partir da tabela Equipamento no grid
        $marca    = EquipamentoDB::getMarca();
        $modelo   = EquipamentoDB::getModelo();
        //farm em entrada de equipamento
        $setor    = EquipamentoDB::getSetor();
        $unidade  = EquipamentoDB::getUnidade();
        $tecnico  = EquipamentoDB::getTecnico();
        $servidor = EquipamentoDB::getServidor();
        $situacao = EquipamentoDB::getSituacao();
        

        return view('equipamento.entrada', compact ( 'marca', 'modelo', 'setor', 'unidade', 'tecnico', 'servidor', 'situacao'));
    }

    public function gridPesquisa()
    {
        $patrimonio  = request('patrimonio', null);
        $num_serie   = request('num_serie', null); 
        $situacao    = request('situacao', null);
        $tipo        = request('tipo', null);
        $marca       = request('marca', null);
        $modelo      = request('modelo', null);
        $tecnico     = request('tecnico', null);
        $servidor    = request('servidor', null);
        $setor       = request('setor', null);
        $unidade     = request('unidade', null);
        $data_movimentacao = date('data_movimentacao', null);
        $num_movimentacao  = request('num_movimentacao', null);

        // return ['equipamento' => EquipamentoDB::gridPesquisa($patrimonio, $num_serie, $situacao, $tipo, $marca, $modelo,
        //  $tecnico, $servidor, $setor, $unidade, $data_movimentacao, $num_movimentacao)];
        
        return Paginacao::dataTables(EquipamentoDB::gridPesquisa($patrimonio, $num_serie, $situacao, $tipo, $marca, $modelo,
         $tecnico, $servidor, $setor, $unidade, $data_movimentacao, $num_movimentacao), true, true);
    }

    public function gridPesquisaa()
    {
        $p = (object) request()->all();
        return Paginacao::dataTables(EquipamentoDB::gridPesquisa($p), true);
    }

    public function gridEntrada()
    {
        $tipo       = request('tipo', null);
        $marca      = request('marca', null);
        $modelo     = request('modelo', null);
        $num_serie  = request('num_serie', null);
        $patrimonio = request('patrimonio', null);
        
        return response()->json(EquipamentoDB::gridAdicionaEntrada($tipo, $marca, $modelo, $num_serie, $patrimonio));
    } 

  
    //salva novo equipamento
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

            $oTipo = Tipo::updateOrCreate([
                'nome'      => $request->get('tipo')
            ]);

            $oMarca = Marca::updateOrCreate([
                'nome'      => $request->get('marca'), 
                'fk_tipo'   => $request->get('tipo')
            ]);

            $oModelo = Modelo::updateOrCreate([
                'nome'      => $request->get('modelo'), 
                'fk_marca'  => $request->get('marca')
            ]);

            $p = (object) $request->all();

            // print_r($request->all());

            DB::commit();

            return response()->json(array('msg' => 'Equipamento cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }

    //salva entrada 
    public function createEquipamentoEntrada(Request $request)
    {
        DB::beginTransaction();
        try{

            $oEntrada = Recebimento::updateOrCreate([
                
                //ao adicionar, buscao em Equipamento o id
                'fk_unidade'   => $request->get('unidade'),
                'fk_tecnico'   => $request->get('tecnico'),
                'fk_servidor'  => $request->get('servidor'),
                'fk_situacao'  => $request->get('situacao'),
                'telefone'     => $request->get('telefone', null),
                'descricao'    => $request->get('descricao', null),
                'num_movimentacao'  => $request->get('num_movimentacao'),
                'data_movimentacao' => $request->get('data_movimentacao'),
                //trazer do num_movimentacao
                'fk_tipo'      => $request->get('tipo'),
                'fk_setor'     => $request->get('setor'),
                'fk_marca'     => $request->get('marca'),
                'fk_modelo'    => $request->get('modelo'),
                'num_serie'    => $request->get('num_serie'), 
                'patrimonio'   => $request->get('patrimonio')
                ]);

            //encontrar id da linha antes de salvar
            $oEquipamento = Equipamento::updateOrCreate([
                'fk_setor'    => $request->get('novo_setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);

            $oSetorUnidade = SetorUnidade::updateOrCreate([
                'fk_setor'    => $request->get('novo_setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);

            $oSetor = Setor::updateOrCreate([
                'nome'        => $request->get('novo_setor'), //novo_setor
                'fk_unidade'  => $request->get('unidade'),
            ]);


        $p = (object) $request->all();

        DB::commit();

            return response()->json(array('msg' => 'Entrada cadastrada com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }    

}
