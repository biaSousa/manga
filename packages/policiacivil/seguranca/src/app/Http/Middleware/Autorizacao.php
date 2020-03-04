<?php

namespace PoliciaCivil\Seguranca\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use PoliciaCivil\Seguranca\App\Models\Entity\SegPermissao;
use PoliciaCivil\Seguranca\App\Models\Regras\SegAcaoRegras;

class Autorizacao
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(Route::current()->parameters);
        /*
         * Regras da verificação:
         * 1) Verifica se o usuário está logado
         * 2) Pesquisar os grupos deste usuário
         * 3) Se um dos grupos for o de administrador (somente os desenvolvedores)
         * liberar qualquer ação
         * 4) Senão, verificar se algum dos grupos dele possui permissão para acessar esta ação
         */
        if (!Auth::check()) { //se não estiver logado
            return redirect('seguranca/usuario');
        }

        $oUsuario = Auth::user(); //usuario logado

        //pesquisando o id da ação
        $url = Route::getFacadeRoot()->current()->uri();
        $acao = SegAcao::pesquisarPorNome($url)->first();

        //será usado no próximo middleware que verifica a necessidade de log de acesso a uma ação
        $request->acao_solicitada = $acao;

        if (!$acao instanceof SegAcao) { //acao não está cadastrada no banco
            if (config('app.env') === 'local') {
                return response($oUsuario->nome . ", cadastre esta ação no banco de dados: <a href=" . url('/seguranca/acao/novo?acao=') . "$url>$url</a>",
                    404);
            } else {
                return response('Ação não cadastrada no banco de dados', 404);
            }
        }

        //impõe a troca de senha ao usuário
        if ($oUsuario->primeiro_acesso && !SegAcaoRegras::isAcaoLiberada($acao->nome)) {
            return response(view('Seguranca::usuario.alterar-senha'));
        }

        //impõe o cadastro de cpf e data de nascimento ao usuário
        if (
            $oUsuario->id !== 1 && !SegAcaoRegras::isAcaoLiberada($acao->nome) && (!$oUsuario->cpf || !$oUsuario->nascimento)
        ) {

            if ($oUsuario->cadastroIncompleto()) {
                return response(view('Seguranca::usuario.atualizar-dados', compact('oUsuario')));
            }
        }

        $perfis = $oUsuario->todosOsPerfis()->get();
        $aPerfil = [];
        foreach ($perfis as $p) {
            $aPerfil[] = $p->id;
            if ($p->id == '1') { //administrador tem acesso liberado
                $request->perfis = $aPerfil;
                return $next($request);
            }
        }

        //se for uma ação obrigatória então permite sua visualização
        if ($acao->obrigatorio) {
            $request->perfis = $aPerfil;
            return $next($request);
        }

        $autorizacao = SegPermissao::permissao($acao->id, $aPerfil)->count();
        if ($autorizacao) {
            $request->perfis = $aPerfil;
            return $next($request);
        } else { //usuário sem permissão de acesso

            if ($request->ajax()) { //responde como json se for uma requisição com XMLHttpRequest

                return response()->json(['message' => 'Você não possui permissão para acessar este recurso'], 403);
            } else { //responde com view se form uma requisição normal
                return response(view('errors.permissao_negada', compact('oUsuario')), 403);
            }
        }
    }

//    public function acaoLiberada($acao)
//    {
//        //acoes que podem ser executadas independente da situação do usuário
//        $acoes = [
//            'seguranca/usuario/atualizar-senha',
//            'seguranca/usuario/atualizar-dados',
//            'seguranca/usuario/logout',
//        ];
//
//        return in_array($acao, $acoes);
//    }
}
