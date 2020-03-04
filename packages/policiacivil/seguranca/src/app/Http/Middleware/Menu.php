<?php

namespace PoliciaCivil\Seguranca\App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use PoliciaCivil\Seguranca\App\Models\Historico;

class Menu
{
    private $schema = null;
    private $aMenu = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $schema = config('database.connections.conexao_padrao.schema');
        $this->schema = is_null($schema) ? null : $schema . '.';
        $this->aMenu = $this->subMenu($request->perfis, null);
        View::share('menu', $this->aMenu); //variável menu fica disponível para qualquer view
        return $next($request);
    }

    public function subMenu($perfis = [], $menuPai = null)
    {
        $oMenu = DB::table("{$this->schema}seg_menu as m")
            ->select('m.id', 'm.nome', 'a.nome as acao', 'm.pai')
            ->leftJoin("{$this->schema}seg_acao as a", 'a.id', 'm.acao_id')
            ->where('m.status', '=', 1)
            ->groupBy('m.id', 'm.nome', 'a.nome', 'm.pai')
            ->groupBy('m.pai')
            ->orderBy('m.pai', 'desc')
            ->orderBy('m.ordem');

        //se não for administrador do sistema então filtra o que pode ser visto no menu
        if (!in_array(1, $perfis)) {
            $oMenu->leftJoin("{$this->schema}seg_permissao as p", 'p.acao_id', '=', 'a.id');
            $oMenu->whereIn('p.perfil_id', $perfis);

            //criei o trecho abaixo, pois assim elimino a possibilidade de um usuário perder acesso ao menu,
            //sempre que ele perder acesso ao elemento raiz. Nesta situação há a possibilidade do usuário perder,
            //acesso a algum item que é filho de uma ação que ele não pode mais acessar, ou seja,
            //o usuário perdeu acesso ao pai, mas ainda deveria ter acesso ao filho, mas sem o pai ele deixa de ver
            //o filho. A construção atual do menu exibia esta situação com erro pois o nome do menu pai sumia do select
            //e o script blade não conseguia montar o menu. Esta é uma situação rara mais aconteceu comigo na atualização do antecedente
            //que tem tela de permissão liberada ao usuário e como o usuário pode fazer besteira, então decidi permitir o acesso
            //a um menu que não possui ação, que deve ser usado apenas como item raiz que tenha filhos. Assim,
            //sua ação vazia de pai não trará nenhum erro ao sistema, já que ele só expandirá menu e não abrirá link.
            //Ass: Philipe Barra
            $oMenu->orWhereNull('m.acao_id');
        }

        $oMenu = $oMenu->get();

        $aMenu = array();
        foreach ($oMenu as $menu) { //cada item de oMenu é um stdClass, ou seja, $menu é um stdClass
            if (!$menu->pai) { //é item raiz
                $aMenu[$menu->id] = $menu;
                //menu raiz agora pode vir sem ação (usado para abrigar submenus)
                // if ($menu->acao === null) { //menu raiz sem acao cadastrada gera erro no menu
                //     $oUsuario = Auth::user(); //usuario logado
                //     die("$oUsuario->nome, o menu '$menu->nome' é um menu raiz e está sem ação atrelada a ele.");
                // }
            } else { //é subitem
                $aMenu[$menu->pai]->submenu[] = $menu;
            }
        }

//        dd($aMenu);

        /*
         * Limpando menu raiz sem nenhum filho. Pode acontecer quando o usuário não tiver permissão em nenhum subitem
         * de um item do menu que possui acao_id = null
         */
        // printvardie($aMenu);
        foreach ($aMenu as $k => $m) {
            if (!isset($m->nome)) { //informando se há menu filho sem pai (cadastro incorreto feito pelo programador)
                if (config('app.debug')) {
                    printvardie('Menu cadastrado sem pai, apenas com subitens', $m);
                } else {
                    die('Não foi possível carregar menu do sistema. Por favor, entre em contato com o DIME.');
                }
            }
            if (!$m->acao && !isset($m->submenu)) {
                unset($aMenu[$k]);
            }
        }
        // printvardie($aMenu);

        return $aMenu;
    }
}
