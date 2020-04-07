<?php

namespace App\Http\Controllers;

use App\Models\Paginacao;
use Illuminate\Http\Request;
use App\Models\Entity\Servidor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Facade\EquipamentoDB;
use App\Models\Facade\ServidorDB;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class ServidorController extends Controller
{
    //from bono
    public function index()
    {
        $situacoes = PlantaoSituacao::orderBy('nome')->get();
        $unidades_diretores = UnidadeDB::unidadesComDiretores();
        $usuario = auth()->user();
        $unidadeUsuarioLogado = $usuario->fk_unidade;
        $aPerfil = UsuarioLocalDB::perfilUsuario($usuario->id)->pluck('id')->toArray();
        $situacaoPadrao = '';

        //verifica se tem perfil de dg
        if(in_array(7, $aPerfil)) {
            $unidadeUsuarioLogado = '';
            $situacaoPadrao = 3;//3 - Autorizado Diretor
        }

        //verifica se tem perfil de pagamento
        if(in_array(8, $aPerfil)) {
            $unidadeUsuarioLogado = '';
            $situacaoPadrao = 2;//2 - Autorizado DG
        }

        return view('plantao.index', compact('situacoes', 'unidades_diretores',
            'unidadeUsuarioLogado', 'situacaoPadrao'));
    }
    //from bono
    public function grid()
    {
        $p = (object)request()->all();
        return Paginacao::dataTables(PlantaoRegras::grid($p), true);
    }

    //tela de pesquisa futura (*) (*) 
    public function servidor()
    { 
        return view('servidor.index');
    }

    //grid de pesquisa (*) (*)
    public function gridServidor()
    {
        $p = (object)request()->all();
        return Paginacao::dataTables(ServidorDB::gridServidor($p), true);
    }

    //tela de cadastro de novo servidor
    public function novoServidor()
    {   //EquipamentoDB contém o sql de cada combo
        $cargo    = EquipamentoDB::getCargo();
        $setor    = EquipamentoDB::getSetor();
        $unidade  = EquipamentoDB::getUnidade();

        return view('servidor.novo', 'compact'('cargo', 'setor', 'unidade'));
    }

    //salva servidor
    public function createServidor(Request $request)
    {
        DB::beginTransaction();
        try{
            //Método que verifica no ato de salvar
            //se for dados nunca combinados antes, é salvo
            //se for dados que ja foram armazenados, não é salvo
            $oServidor = Servidor::updateOrCreate([
                'cpf'        => $request->get('cpf'),
                'nome'       => $request->get('nome'),
                'email'      => $request->get('email'),
                'matricula'  => $request->get('matricula'),
                'fk_cargo'   => $request->get('cargo'),
                'fk_setor'   => $request->get('setor'),
                'fk_unidade' => $request->get('unidade'),
                'data_nasc'  => $request->get('data_nasc'),
                'data_entrada' => $request->get('data_entra')
            ]);

            $p = (object) $request->all();

            DB::commit();

            // if ($p == $p){
            //     return response()->json(array('msg' => 'Servidor já pussui cadastrado.'));
            // }

            return response()->json(array('msg' => 'Servidor cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()), 422);
        }
    }

    //edita servidor (*)
    public function editaServidor(Servidor $servidor)
    {
        $cargo    = EquipamentoDB::getCargo();
        $setor    = EquipamentoDB::getSetor();
        $unidade  = EquipamentoDB::getUnidade();
        $aPerfil  = UsuarioLocalDB::perfilUsuario($servidor->id);

        return view('servidor.novo', 'compact'('cargo', 'setor', 'unidade'));

        $tipoConta   = TipoConta::all();
		$despesa     = Despesa::find($id);
		$unidades    = UnidadeDB::getUnidadesByConta($despesa->fk_tipo_conta);
		$tipoDespesa = TipoDespesa::all();

		return view('despesa.edit', compact('unidades', 'tipoConta', 'tipoFontes', 'despesa', 'tipoDespesa'));
    }

    //modelo (*)
    public function edit(Abono $abono)
    {
        $servidores    = AbonoRegras::comboDiretor($abono->dt_abono);
        $motivo        = AbonoRegras::comboMotivo();
        $mesReferencia = AbonoRegras::mesReferencia();
        $valor         = AbonoRegras::abonoValor();
        $abonoServidor = AbonoDB::servidores($abono->id);
        $diretorAtual  = UsuarioLocalDB::getDiretorByUnidadeId($abono->fk_unidade);

        $min = date('Y-m-d', strtotime("first day of $abono->dt_abono"));
        $max = date('Y-m-d', strtotime("last day of $abono->dt_abono"));

        return view('abono.create', compact(
            'servidores',
            'motivo',
            'mesReferencia',
            'max',
            'min',
            'valor',
            'abono',
            'abonoServidor',
            'alerta',
            'diretorAtual'
        ));
    }

    //nova ordem de servico (*)
    public function aberturaDeordemServico()
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

    // pesquisa ordem de servico (*)
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

    //salva novo ordem de servico (*)
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
