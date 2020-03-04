<?php

namespace PoliciaCivil\Seguranca\App\Models\Regras;

use PoliciaCivil\Seguranca\App\Models\Entity\SegPreCadastro;
use PoliciaCivil\Seguranca\App\Models\Entity\Usuario;
use PoliciaCivil\Seguranca\App\Models\Exception\PreCadastroNaoEncontradoException;
use PoliciaCivil\Seguranca\App\Models\Formatar;

class PreCadastroRegras
{
    public static function verificarUsuarioExistente($cpf, $email)
    {
        /**
         * - Verificar se o cpf digitado já possui cadastro
         * - Verificar se o email digitado já possui cadastro
         *
         * Se algum dos itens acima for verdadeiro então retornar o código
         */
        $cpf = preg_replace('/\D/', null, $cpf);

        $oUsuario = Usuario::where('email', $email)
            ->orWhere('cpf', $cpf)
            ->count();

        //tenta localizar um pré-cadastro com os dados de um cadastro ativo
        $oPreCadastro = SegPreCadastro::where('email', $email)
            ->orWhere('cpf', $cpf)
            ->orderBy('id')
            ->first();

        return $oUsuario || $oPreCadastro ? true : false;
    }

    /**
     * Mesmo que salvar() mas baixa as informacoes automaticamente do cadastro de usuário
     *
     */
    public static function salvarUsuarioComCadastroAtivo($cpf, $email)
    {
        $cpf = preg_replace('/\D/', null, $cpf);
        $oUsuario = Usuario::where('email', $email)
            ->orWhere('cpf', $cpf)
            ->orderBy('id')
            ->first();

        //tenta localizar um pré-cadastro. Evita que o usuário tenha várias solicitações de acesso
        $oPreCadastro = SegPreCadastro::where('email', $email)
            ->orWhere('cpf', $cpf)
            ->orderBy('id')
            ->first();

        if (!$oPreCadastro) {
            $oPreCadastro = new SegPreCadastro();
        }

        $oPreCadastro->nome = optional($oUsuario)->nome ? $oUsuario->nome : $oPreCadastro->nome;
        $oPreCadastro->email = $email;
        $oPreCadastro->cpf = preg_replace('/\D/', null, $cpf);
        $oPreCadastro->nascimento = optional($oUsuario)->nascimento ? $oUsuario->nascimento : $oPreCadastro->nascimento;
        $oPreCadastro->unidade = optional($oUsuario)->unidade ? $oUsuario->unidade : $oPreCadastro->unidade;
        $oPreCadastro->senha = optional($oUsuario)->senha ? $oUsuario->senha : $oPreCadastro->senha;
        $oPreCadastro->fk_usuario = optional($oUsuario)->id;
        $oPreCadastro->save();
    }

    /**
     * Este método é chamado no passo 2 quando o cadastro completo é solicitado ao usuário, ou seja,
     * aqueles que não possuem usuário no banco único
     */
    public static function salvar(\stdClass $p)
    {
        //tenta localizar o pré-cadastro existente
        //se houver atualiza senão cria um
        $oPreCadastro = SegPreCadastro::where('email', $p->email)
            ->orWhere('cpf', $p->cpf)
            ->orderBy('id')
            ->first();

        if (!$oPreCadastro) {
            $oPreCadastro = new SegPreCadastro();
        }

        $oPreCadastro->nome = $p->nome;
        $oPreCadastro->email = $p->email;
        $oPreCadastro->cpf = preg_replace('/\D/', null, $p->cpf);
        $oPreCadastro->nascimento = Formatar::data($p->nascimento, 'banco');
        $oPreCadastro->unidade = $p->unidade;
        $oPreCadastro->senha = sha1($p->senha);
        $oPreCadastro->save();
    }

    public static function infoUsuario($id)
    {
        $oSegPreCadastro = SegPreCadastro::find($id);

        if (!$oSegPreCadastro) {
            throw new PreCadastroNaoEncontradoException();
        }

        return $oSegPreCadastro;
    }

    public static function excluir($id)
    {
        SegPreCadastro::destroy($id);
    }
}
