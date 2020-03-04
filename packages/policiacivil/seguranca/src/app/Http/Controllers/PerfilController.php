<?php

namespace PoliciaCivil\Seguranca\App\Http\Controllers;

use App\Http\Controllers\Controller;
use PoliciaCivil\Seguranca\App\Models\DB;
use PoliciaCivil\Seguranca\App\Models\Facade\PerfilDB;
use PoliciaCivil\Seguranca\App\Models\Facade\PermissaoDB;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPerfil;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPermissao;
use PoliciaCivil\Seguranca\App\Models\Paginacao;
use PoliciaCivil\Seguranca\App\Models\Regras\PerfilRegras;
use PoliciaCivil\Seguranca\App\Requests\PerfilRequest;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;

class PerfilController extends Controller
{
    public function index()
    {
        return view('Seguranca::perfil.index');
    }

    public function grid()
    {
        $oPerfil = new PerfilDB();
        return response()->json(Paginacao::dataTables($oPerfil->grid(), true));
    }

    public function novo()
    {
        $oAcao = SegAcao::destaques()->get();
        return view('Seguranca::perfil.novo', compact('oAcao'));
    }

    public function store(PerfilRequest $request)
    {
        $oPerfil = new SegPerfil();
        $oPerfil->nome = request('nome');

        DB::beginTransaction();
        try {
            $oPerfil->save();
            $aAcao = request('acao', []);

            $oPermissao = new PermissaoDB();
            $aAcao = array_unique(array_merge($aAcao, $oPermissao->dependencia($aAcao)));

            foreach ($aAcao as $a) {
                $oSegPermissao = new SegPermissao();
                $oSegPermissao->acao_id = $a;
                $oSegPermissao->perfil_id = $oPerfil->id;
                $oSegPermissao->save();
            }

            DB::commit();
            return response()->json(array('msg' => 'Perfil cadastrado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('msg' => $e->getMessage()));
        }
    }

    public function editar($id)
    {
        $oPerfil = SegPerfil::find($id);
        $oAcao = SegAcao::destaques()->get();
        $aPermissoes = $oPerfil->permissoes();
        return view('Seguranca::perfil.editar', compact('oPerfil', 'oAcao', 'aPermissoes'));
    }

    public function update(PerfilRequest $r)
    {
        DB::beginTransaction();
        try {
            $oPerfil = SegPerfil::find(request('perfil'));
            $oPerfil->nome = request('nome');
            $oPerfil->save();

            $aAcoesEnviadas = request('acao', []);
            $aAcoesBanco = $oPerfil->permissoes();

            /*
             * Verificar todas as permissões necessárias para o funcionamento do que o usuário selecionou
             * Remover do banco tudo o que não estiver na lista acima
             *
             */
            $oPermissao = new PermissaoDB();
            $aAcoesEnviadas = array_merge($aAcoesEnviadas, $oPermissao->dependencia($aAcoesEnviadas));

            if(is_array($aAcoesEnviadas) && !empty($aAcoesEnviadas)) {//se o usuário deu alguma permissão ao perfil
                $aPermissaoNova = array_diff($aAcoesEnviadas, $aAcoesBanco);//permissões novas que não estavam no banco

                foreach ($aPermissaoNova as $p) {
                    $oPermissao = new SegPermissao();
                    $oPermissao->perfil_id = $oPerfil->id;
                    $oPermissao->acao_id = $p;
                    $oPermissao->save();
                }

                $aPermissoesExcluidas = array_diff($aAcoesBanco, $aAcoesEnviadas);

                SegPermissao::where('perfil_id', $oPerfil->id)
                            ->whereIn('acao_id', $aPermissoesExcluidas)
                            ->delete();
            }

            DB::commit();
            return response()->json(array('msg' => 'Perfil atualizado com sucesso.'));
        } catch (\Exception $e) {
            DB::rollback();
            response()->json(['msg' => 'Erro ao salvar perfil', 500]);
        }
    }

    public function excluir()
    {
        $id = request('id', null);

        if(PerfilRegras::excluirPerfil($id)) {
            return response()->json(array('msg' => 'Perfil excluído com sucesso.'));
        } else {
            return response()->json(['msg' => 'Falha ao excluir perfil.'], 500);
        }

    }
}