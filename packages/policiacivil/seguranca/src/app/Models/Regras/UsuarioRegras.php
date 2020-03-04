<?php

namespace PoliciaCivil\Seguranca\App\Models\Regras;

use Carbon\Carbon;
use PoliciaCivil\Seguranca\App\Models\Entity\Acesso;
use PoliciaCivil\Seguranca\App\Models\Entity\SegGrupo;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPreCadastro;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;
use PoliciaCivil\Seguranca\App\Models\Entity\UsuarioSistema;
use PoliciaCivil\Seguranca\App\Models\Facade\PerfilDB;
use PoliciaCivil\Seguranca\App\Models\Formatar;
use PoliciaCivil\Seguranca\App\Models\Util;

class UsuarioRegras
{
    /**
     * Cria um usuário no segurança.
     * Aqui não será feita nenhuma validação. Elas devem ser feitas no controlador
     *
     * @param array $aParametro
     * @return Usuario
     * @throws \Exception
     */
    public static function criarUsuario(array $aParametro)
    {
        //verificando se todos os parâmetros foram enviados
        $obrigatorio = [
            'nome',
            'email',
            'senha',
        ];

        if (!Util::todasAsChavesPresentes($obrigatorio, $aParametro)) {
            throw new \Exception('Campo obrigatório não informado');
        }

        $oUsuario = Usuario::where('email', $aParametro['email'])->orderBy('id')->first();

        if ($oUsuario) {
            $aParametro['usuario_id'] = $oUsuario->id;
            $oUsuario = self::atualizarUsuario($aParametro);
        } else {
            $oUsuario = new Usuario();
            $oUsuario->nome = mb_convert_case($aParametro['nome'], MB_CASE_UPPER, 'UTF-8');
            $oUsuario->email = mb_convert_case($aParametro['email'], MB_CASE_LOWER, 'UTF-8');
            $oUsuario->senha = $aParametro['senha'];
            $oUsuario->dt_cadastro = date('Y-m-d H:i:s');
            $oUsuario->primeiro_acesso = $aParametro['primeiro_acesso'];
            $oUsuario->cpf = preg_replace('/\D/', null, $aParametro['cpf']);
            $oUsuario->nascimento = Formatar::data($aParametro['nascimento'], 'banco');
            $oUsuario->excluido = false;
            $oUsuario->unidade = $aParametro['unidade'];
            $oUsuario->save();
        }

        //verificando se o usuário já possui acesso a este sistema,
        //pois o usuário é novo neste sistema e não necessáriamente um usuário novo nos outros
        $oUsuarioSistema = UsuarioSistema::where('usuario_id', $oUsuario->id)
            ->where('sistema_id', config('policia.codigo'))
            ->count();

        if (!$oUsuarioSistema) {

            //incluindo o sistema atual na lista de sistemas que o usuário novo pode acessar
            $oUsuarioSistema = new UsuarioSistema();
            $oUsuarioSistema->usuario_id = $oUsuario->id;
            $oUsuarioSistema->sistema_id = config('policia.codigo');

            $oUsuarioSistema->save();
        }
        return $oUsuario;
    }

    // use atualizarPerfil()
    // public static function criarPerfil(Usuario $oUsuario, array $aPerfil)
    // {
    //     //se o admin escolheu algum perfil para o novo usuário
    //     if (in_array(1, $aPerfil)) {
    //         $oGrupo = new SegGrupo();
    //         $oGrupo->usuario_id = $oUsuario->id;
    //         $oGrupo->perfil_id = 1;
    //         $oGrupo->save();
    //     } else {
    //         foreach ($aPerfil as $p) {
    //             $oGrupo = new SegGrupo();
    //             $oGrupo->usuario_id = $oUsuario->id;
    //             $oGrupo->perfil_id = $p;
    //             $oGrupo->save();
    //         }
    //     }
    // }

    public static function atualizarUsuario(array $aParametro)
    {
        //verificando se todos os parâmetros foram enviados
        $obrigatorio = [
            'usuario_id',
        ];

        if (!Util::todasAsChavesPresentes($obrigatorio, $aParametro)) {
            throw new \Exception('Campo obrigatório não informado');
        }

        //atualizando dados do usuário
        $oUsuario = Usuario::find($aParametro['usuario_id']);

        if (isset($aParametro['nome'])) {
            $oUsuario->nome = mb_convert_case($aParametro['nome'], MB_CASE_UPPER, 'UTF-8');
        }

        if (isset($aParametro['email'])) {
            $oUsuario->email = mb_convert_case($aParametro['email'], MB_CASE_LOWER, 'UTF-8');
        }

        if (isset($aParametro['unidade'])) {
            $oUsuario->unidade = $aParametro['unidade'];
        }

        if (isset($aParametro['senha'])) {
            $oUsuario->senha = $aParametro['senha'];
        }

        $oUsuario->cpf = preg_replace('/\D/', null, $aParametro['cpf']);

        if (isset($aParametro['nascimento'])) {
            $oUsuario->nascimento = Formatar::data($aParametro['nascimento'], 'banco');
        }

        if (isset($aParametro['primeiro_acesso'])) {
            $oUsuario->primeiro_acesso = $aParametro['primeiro_acesso'];
        }
        if (isset($aParametro['excluido'])) {
            $oUsuario->excluido = $aParametro['excluido'];
        }
        $oUsuario->save();

        return $oUsuario;
    }

    /**
     * Atualiza a lista de perfis de um determinado usuário
     * @param Usuario $oUsuario
     * @param array $aPerfisEnviados
     */
    public static function atualizarPerfil(Usuario $oUsuario, array $aPerfisEnviados)
    {

        $aPerfisBanco = $oUsuario->listaPerfilSimplificado();

        if (!empty($aPerfisEnviados)) { //se o usuário enviou algum perfil
            $aPerfilNovo = array_diff($aPerfisEnviados,
                $aPerfisBanco); //perfis novos que não estavam no banco para este usuário
            foreach ($aPerfilNovo as $p) {
                $oGrupo = new SegGrupo();
                $oGrupo->usuario_id = $oUsuario->id;
                $oGrupo->perfil_id = $p;
                $oGrupo->save();
            }

            $aPerfisExcluidos = array_diff($aPerfisBanco, $aPerfisEnviados);

            SegGrupo::where('usuario_id', $oUsuario->id)
                ->whereIn('perfil_id', $aPerfisExcluidos)
                ->delete();
        } else { //o usuário removeu todos os perfis da tela ou não atribuiu nenhum

            if (!empty($aPerfisBanco)) { //o usuário perdeu todos os perfis que tinha

                SegGrupo::where('usuario_id', $oUsuario->id)->delete();

            }
        }
    }

    /**
     * Atualiza a lista de sistemas que um usuário tem acesso
     * @param Usuario $oUsuario
     * @param array $aSistemasEnviados
     */
    public static function atualizarSistemas(Usuario $oUsuario, array $aSistemasEnviados = [])
    {
        if (!empty($aSistemasEnviados)) { //se o usuário enviou algum sistema
            $aSistemaBanco = $oUsuario->listaSistemaSimplificado();
            $aSistemaNovo = array_diff($aSistemasEnviados, $aSistemaBanco);

            foreach ($aSistemaNovo as $p) {
                $oSistema = new UsuarioSistema();
                $oSistema->usuario_id = $oUsuario->id;
                $oSistema->sistema_id = $p;
                $oSistema->save();
            }
            $aSistemasExcluidos = array_diff($aSistemaBanco, $aSistemasEnviados);

            UsuarioSistema::where('usuario_id', $oUsuario->id)
                ->whereIn('sistema_id', $aSistemasExcluidos)
                ->delete();
        }
    }

    /**
     * A exclusão local remove apenas o acesso do usuário ao sistema atual.
     * A exclusão definitiva só pode ser feita por usuário com perfil 1 (root),
     * pois este usuário pode ter acesso a outros sistemas
     * @param $usuario_id
     */
    public static function excluir($usuario_id)
    {
        $sistema_id = config('policia.codigo');
        $oUsuairoSistema = UsuarioSistema::where('usuario_id', $usuario_id)
            ->where('sistema_id', $sistema_id)
            ->first();

        SegGrupo::where('usuario_id', $usuario_id)->get()->each(function ($e) {
            $e->delete();
        });

        UsuarioSistema::destroy($oUsuairoSistema->id);
    }

    /**
     * Verifica se o login do usuário expirou
     *
     * Este método depende do Middleware autorização ativo pois,
     * a consulta de $oUsuarioSistema pode retornar vazio,
     * o que é tratato no middleware. Tenha isto em mente caso vá
     * realizar testes com este método
     * @param integer $usuarioID
     * @return boolean
     */
    public static function isLoginExpirado(int $usuarioID): bool
    {
        if ($usuarioID === 1) { //usuário root (id = 1) não expira
            return false;
        }

        //todos os perfis do usuário
        $aPerfil = PerfilDB::perfilSimplificado($usuarioID);

        //usuário administrador (perfil = 1) não expira
        if (in_array(1, $aPerfil)) {
            return false;
        }

        $sistema_id = config('policia.codigo');
        $oUsuarioSistema = UsuarioSistema::where('usuario_id', $usuarioID)
            ->where('sistema_id', $sistema_id)
            ->first();

//        dd($oUsuarioSistema);

        if(!$oUsuarioSistema)
            throw new \Exception('Este usuário não possui perfil neste sistema');

        //calculando o tempo desde o último acesso
        $oUltimoAcesso = new Carbon($oUsuarioSistema->ultimo_acesso);
        $oAgora = Carbon::now();

        //se o login ainda está no prazo desde o último acesso
        if ($oAgora->diffInDays($oUltimoAcesso) <= config('policia.expiracao_login')) {
            return false;
        }

        return true;

    }

    /**
     * Registra o acesso de um usuário na tabela acesso
     *
     * @param int $usuarioID
     * @param string $ip
     * @return int
     */
    public static function registrarAcesso($usuarioID, $ip): int
    {
        $oAcesso = new Acesso();
        $oAcesso->fk_usuario = $usuarioID;
        $oAcesso->ip = $ip;
        $oAcesso->login = date('Y-m-d H:i:s');
        $oAcesso->desabilitarLog();
        $oAcesso->save();

        return $oAcesso->id;
    }

    /**
     * Renova o login de um determinado usuário para este sistema
     *
     * @return void
     */
    public static function renovarLogin($usuarioID)
    {
        //root não precisa de renovação
        if ($usuarioID === 1) {
            return;
        }

        $sistema_id = config('policia.codigo');
        $oUsuarioSistema = UsuarioSistema::where('usuario_id', $usuarioID)
            ->where('sistema_id', $sistema_id)
            ->first();

        $oUsuarioSistema->desabilitarLog();
        $oUsuarioSistema->ultimo_acesso = date('Y-m-d');
        $oUsuarioSistema->save();
    }

    /**
     * Faz a criação definitiva do usário que estava apenas com pré-cadastro
     */
    public static function criarUsuarioViaPreCadastro(array $p)
    {
        //cadastrando usário e atribuindo perfis
        $oUsuario = self::criarUsuario($p);
        self::atualizarPerfil($oUsuario, $p['perfil']);

        //removendo usuário da tabela de pré-cadastro
        $oPreCadastro = SegPreCadastro::where('email', $oUsuario->email)
            ->orWhere('cpf', $oUsuario->cpf)
            ->delete();

        return;
    }
}
