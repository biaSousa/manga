<?php

namespace PoliciaCivil\Seguranca\App\Http\Controllers;

use App\Http\Controllers\Controller;
use PoliciaCivil\Seguranca\App\Http\Requests\AcaoRequest;
use PoliciaCivil\Seguranca\App\Models\DB;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use PoliciaCivil\Seguranca\App\Models\Entity\SegDependencia;
use PoliciaCivil\Seguranca\App\Models\Entity\SegHistorico;
use PoliciaCivil\Seguranca\App\Models\Entity\SegMenu;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPermissao;
use PoliciaCivil\Seguranca\App\Models\Facade\AcaoDB;
use PoliciaCivil\Seguranca\App\Models\Paginacao;

class AcaoController extends Controller
{
    public function index()
    {
        return view('Seguranca::acao.index');
    }

    public function grid()
    {
        $oAcao = new AcaoDB();
        return response()->json(Paginacao::dataTables($oAcao->grid(), true));
    }

    public function novo()
    {
        $aAcao = SegAcao::orderBy('nome')->get();
        $acao = request('acao', null); //middleware autenticacao gera esta variável para facilitar a vida do desenvolvedor
        return view('Seguranca::acao.novo', compact('aAcao', 'acao'));
    }

    public function store(AcaoRequest $request)
    {
        $oAcao = new SegAcao();
        $oAcao->nome = request('nome');
        $oAcao->descricao = request('descricao', null);
        $oAcao->destaque = request('destaque', null) == 'on' ? 1 : 0;
        $oAcao->nome_amigavel = request('nome_amigavel', null);

        try {
            $oAcao->save();
            return response()->json(array('msg' => 'Ação cadastrada com sucesso.'));
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 500]);
        }
    }

    public function editar($id)
    {
        /**
         * @var SegAcao
         */

        $oAcao = SegAcao::find($id);
        $aAcao = SegAcao::orderBy('nome')->get();
        $aDependencia = $oAcao->acoesDependencia();

        return view('Seguranca::acao.editar', compact('aAcao', 'oAcao', 'aDependencia'));
    }

    public function update(AcaoRequest $r)
    {
        DB::beginTransaction();
        try {
            $oAcao = SegAcao::find(request('id'));
            $oAcao->nome = request('nome');
            $oAcao->descricao = request('descricao', null);
            $oAcao->destaque = request('destaque', null) == 'on' ? 1 : 0;
            $oAcao->nome_amigavel = request('nome_amigavel', null);
            $oAcao->save();

            $aDependenciaFormulario = request('dependencia', null);

            $oAcaoDB = new AcaoDB();
            $aDependenciaBanco = $oAcaoDB->dependencias($oAcao->id);

            if (is_array($aDependenciaFormulario) && !empty($aDependenciaFormulario)) { //se o usuário enviou alguma dependencia
                $aDependenciaNova = array_diff($aDependenciaFormulario, $aDependenciaBanco); //dependencias novas que não estavam no banco para esta acao

                foreach ($aDependenciaNova as $d) {
                    $oDependencia = new SegDependencia();
                    $oDependencia->acao_atual_id = $oAcao->id;
                    $oDependencia->acao_dependencia_id = $d;
                    $oDependencia->save();
                }

                $aDependenciaVelha = array_keys(array_diff($aDependenciaBanco, $aDependenciaFormulario)); //Dependências salvas que o usuário excluiu da tela
                SegDependencia::destroy($aDependenciaVelha);
            }
            DB::commit();
            return response()->json(array('msg' => 'Ação alterada com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => 'Erro ao atualizar ação'], 500);
        }
    }

    public function excluir()
    {
        $id = request('id', null);

        if (!$id) {
            return response()->json(['msg' => 'Informe uma ação válida.'], 422);
        }

        DB::beginTransaction();

        try {
            /*
             * As tabelas que contem referências a ação são:
             * 1 - menu
             * 2 - permissoes
             * 3 - dependencia
             * 4 - historico
             * 5 - acao
             */

            SegMenu::where('acao_id', '=', $id)->delete();
            SegPermissao::where('acao_id', '=', $id)->delete();
            SegDependencia::where('acao_atual_id', $id)
                ->orWhere('acao_dependencia_id', $id)
                ->delete();

            SegHistorico::where('acao_id', $id)->delete();
            SegAcao::destroy($id);
            DB::commit();

            return response()->json(array('message' => 'Ação excluída com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            if (config('app.debug')) {
                return rsponsive()->json(['message' => $e->getMessage()], 500);
            } else {
                return response()->json(['message' => 'Erro ao excluir ação.'], 500);
            }
        }
    }
}
