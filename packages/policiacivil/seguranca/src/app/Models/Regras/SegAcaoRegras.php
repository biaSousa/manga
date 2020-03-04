<?php

namespace PoliciaCivil\Seguranca\App\Models\Regras;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;
use PoliciaCivil\Seguranca\App\Models\Facade\AcaoDB;

class SegAcaoRegras
{
    /**
     * Ações que o usuário pode acessar, somando todas as permissões de todos os seus perfis
     * @var array
     */
    private static $acoes_permitidas = [];

    /**
     * Ações que NÃO DEVEM ser bloqueadas em nenhuma hipótese a qualquer usuário logado,
     * Detectar erro porque as ações abaixo foram modificadas é extremamente difícil.
     * Altere por sua conta e risco, pois a tela fica em branco,
     * loop infinito nos redirecionamentos do apache etc.
     *
     * isso acontece porque em alguns momentos o módulo de segurança vai redirecionar o usuário
     * para algum dos endereços abaixo e se ele não tiver permissão vai ser redirecionado pra outro endereço
     * que vai redirecionar novamente para os endereços abaixo,
     * até acabar a memória do servidor.
     * @var array
     */
    private static $acoesLiberadas = [
        'seguranca/usuario/atualizar-senha',//qualquer usuário deve poder alterar a própria senha
        'seguranca/usuario/atualizar-dados',//qualquer usuário deve poder atualizar seu cpf e data de nascimento
        'seguranca/usuario/logout',//qualquer usuário deve poder sair do sistema
    ];

    public static function permissaoDeAcesso($url, Usuario $usuario)
    {
        $acao = SegAcao::where('nome', $url)->firstOrFail();

        if ($usuario->id === 1) {//usuário dime pode ter permissão sempre, mesmo que não possua perfil
            return true;
        } elseif ($usuario->isAdmin()) {//usuários com perfil 1 podem acessar sempre
            return true;
        } elseif ($acao->obrigatorio) {//obrigatório para qualquer usuário logado
            return true;
        } elseif(self::isAcaoLiberada($url)) {//acoes que não devem ser bloqueadas nunca
            return true;
        } else {//verifica se um dos perfis do usuário pode acessar
            $aPerfil = $usuario->listaPerfilSimplificado();
            return DB::table('seg_permissao')
                ->whereIn('perfil_id', $aPerfil)
                ->where('acao_id', $acao->id)
                ->count();
        }
    }

    /**
     * Verifica se o usuário pode acessar uma determinada ação pelo id da ação
     * @param $acao_id
     * @param Usuario $usuario
     * @return bool
     */
    public static function permissaoDeAcessoPorId($acao_id, Usuario $usuario)
    {
        $acao = SegAcao::findOrFail($acao_id);

        if ($usuario->id === 1) {//usuário dime pode ter permissão sempre, mesmo que não possua perfil
            return true;
        } elseif ($usuario->isAdmin()) {//usuários com perfil 1 podem acessar sempre
            return true;
        } elseif ($acao->obrigatorio) {//obrigatório para qualquer usuário logado
            return true;
        } elseif(self::isAcaoLiberada($acao->nome)) {//acoes que não devem ser bloqueadas nunca
            return true;
        } else {//verifica se um dos perfis do usuário pode acessar
            return in_array($acao_id, self::getAcoesPermitidas($usuario->id));
        }

    }

    public static function isAcaoLiberada($endereco)
    {
        return in_array($endereco, self::$acoesLiberadas);
    }

    /**
     * Array com o id de todas as ações liberadas para um usuário
     * @param $usuario_id
     * @return array
     */
    public static function getAcoesPermitidas($usuario_id): array
    {
        if (empty(self::$acoes_permitidas)) {
            self::$acoes_permitidas = AcaoDB::permissoesUsuarioArray($usuario_id);
        }

        return self::$acoes_permitidas;
    }
}
