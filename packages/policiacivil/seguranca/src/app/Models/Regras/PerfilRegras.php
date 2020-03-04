<?php

namespace PoliciaCivil\Seguranca\App\Models\Regras;

use PoliciaCivil\Seguranca\App\Models\Entity\SegGrupo;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPerfil;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPermissao;
use PoliciaCivil\Seguranca\App\Models\Facade\AcaoDB;
use PoliciaCivil\Seguranca\App\Models\Facade\PermissaoDB;

class PerfilRegras
{
    public static function atualizarPerfil($request)
    {
        $oPerfil = SegPerfil::find($request->perfil);
        $oPerfil->nome = $request->nome;
        // printVarDie($oPerfil);
        $oPerfil->save();

        $aAcoesEnviadas = $request->aAcoesEnviadas;
        //convertendo string[] em int[] para remover repetições mais abaixo
        $request->aAcoesEnviadas = array_map('intval', $aAcoesEnviadas);

        $aAcoesBanco = $oPerfil->permissoes();

        /*
         * Verificar todas as permissões necessárias para o funcionamento do que o usuário selecionou
         * Remover do banco tudo o que não estiver na lista acima
         *
         */
        $oPermissao = new PermissaoDB();
        //todas dependências das permissões da tela
        $dependencias = $oPermissao->dependencia($aAcoesEnviadas);

        //unindo ações enviadas com suas dependências
        $aAcoesEnviadas = array_merge($aAcoesEnviadas, $oPermissao->dependencia($aAcoesEnviadas));

        //removendo todas as ações duplicadas
        $aAcoesEnviadas = array_unique($aAcoesEnviadas);

        if (is_array($aAcoesEnviadas) && !empty($aAcoesEnviadas)) { //se o usuário deu alguma permissão ao perfil
            $aPermissaoNova = array_diff($aAcoesEnviadas, $aAcoesBanco); //permissões novas que não estavam no banco

            foreach ($aPermissaoNova as $p) {
                $oPermissao = new SegPermissao();
                $oPermissao->perfil_id = $oPerfil->id;
                $oPermissao->acao_id = $p;
                $oPermissao->save();
            }
        }

        //excluindo permissões que não estavam na tela
        $aPermissoesExcluidas = array_diff($aAcoesBanco, $aAcoesEnviadas);

        SegPermissao::where('perfil_id', $oPerfil->id)
            ->whereIn('acao_id', $aPermissoesExcluidas)
            ->delete();
    }

    /**
     * Retorna todas as permissões (ações) do usuário agrupados e ordenados por grupo dentro de um array.
     * ex:
     * [
     *     'nome_do_grupo' => [1,2,3,10,7,40],
     *     'nome_do_grupo2' => [13,23,34,8],
     * ]
     *
     * @param int $usuario_id
     * @return array
     */
    public static function permissoesUsuario($usuario_id): array
    {
        $oAcao = AcaoDB::permissoesUsuario($usuario_id);

        $aAcao = [];
        foreach ($oAcao as $a) {
            $aAcao[$a->grupo][] = $a;
        }

        return $aAcao;
    }

    /**
     * Exclui um perfil e todas as suas dependências
     * @param $idPerfil
     * @return bool
     */
    public static function excluirPerfil($idPerfil)
    {
        SegPermissao::where('perfil_id', $idPerfil)->each(function ($e) {
            $e->delete();
        });

        SegGrupo::where('perfil_id', $idPerfil)->each(function ($e) {
            $e->delete();
        });

        SegPerfil::destroy($idPerfil);
    }
}
