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
use App\Models\Entity\OrdemServico;
use App\Models\Facade\EquipamentoDB;
use App\Models\Facade\EquipamentoFiltrosDB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Paginacao;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class ServidorController extends Controller
{
    public function servidor()
    {   
        $setor    = EquipamentoDB::getSetor();
        $unidade  = EquipamentoDB::getUnidade();
        $servidor = EquipamentoDB::getServidor();
        $diretor  = EquipamentoDB::getDiretor();
        
        return view('servidor.servidor_cadastro', compact('tipo', 'situacao'));
    }
    //ordem_servico.blade.php
    public function AberturaDeordemServico()
    {   
        $tipo     = EquipamentoDB::getTipo();
        $setor    = EquipamentoDB::getSetor();
        $unidade  = EquipamentoDB::getUnidade();
        $situacao = EquipamentoDB::getSituacao();
        $servidor = EquipamentoDB::getServidor();
        $tecnico  = EquipamentoDB::getTecnico();
        $problema = EquipamentoDB::getProblema();

        return view('servidor.ordem_servico', compact('tipo', 'setor', 'unidade', 'situacao', 'servidor', 'tecnico', 'problema'));
    }

    public function gridPesquisaOs()
    {
        $patrimonio  = request('patrimonio', null);
        $num_serie   = request('num_serie', null); 
        $situacao    = request('situacao', null);
        $tipo        = request('tipo', null);
        $tecnico     = request('tecnico', null);
        $unidade     = request('unidade', null);
        $data_movimentacao = date('data_movimentacao', null);
        $num_os  = request('num_os', null);

        // return ['equipamento' => EquipamentoDB::gridPesquisa($patrimonio, $num_serie, $situacao, $tipo, $marca, $modelo,
        //  $tecnico, $servidor, $setor, $unidade, $data_movimentacao, $num_movimentacao)];
        
        return Paginacao::dataTables(EquipamentoDB::gridPesquisa($patrimonio, $num_serie, $situacao, $tipo, $tecnico,
        $unidade, $data_movimentacao, $num_os), true, true);
    }

    //salva novo equipamento
    public function createOrdemServico(Request $request)
    {
        DB::beginTransaction();
        try{
                
            $oOrdem = OrdemServico::updateOrCreate([
                'num_os'      => $request->get('num_os'),
                'email'       => $request->get('email'),
                'telefone'    => $request->get('telefone'),
                'num_serie'   => $request->get('num_serie'),
                'patrimonio'  => $request->get('patrimonio'),
                'data_chamado'=> $request->get('data_chamado'),
                'fk_setor'    => $request->get('setor'),
                'fk_servidor' => $request->get('servidor'),
                'fk_tecnico'  => $request->get('tecnico'),
                'fk_unidade'  => $request->get('unidade'),
                'fk_situacao' => $request->get('situacao'),
                'fk_problema' => $request->get('problema'),
                'descricao'   => $request->get('descricao')

            ]);

            $p = (object) $request->all();
            
            DB::commit();

            return response()->json(array('msg' => 'Chamado cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }   

}
