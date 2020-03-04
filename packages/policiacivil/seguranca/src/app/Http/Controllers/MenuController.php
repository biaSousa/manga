<?php

namespace PoliciaCivil\Seguranca\App\Http\Controllers;

use App\Http\Controllers\Controller;
use PoliciaCivil\Seguranca\App\Models\Entity\SegAcao;
use PoliciaCivil\Seguranca\App\Models\Entity\SegMenu;
use PoliciaCivil\Seguranca\App\Models\Facade\MenuDB;
use PoliciaCivil\Seguranca\App\Models\Paginacao;
use PoliciaCivil\Seguranca\App\Requests\MenuRequest;

class MenuController extends Controller
{
    public function index()
    {
        return view('Seguranca::menu.index');
    }

    public function novo()
    {
        $aAcao = SegAcao::where('destaque', true)->orderBy('nome_amigavel')->get();
        $oPai = new MenuDB();
        $aPai = $oPai->acaoRaiz();
        return view('Seguranca::menu.novo', compact('aAcao', 'aPai'));
    }

    public function store(MenuRequest $request)
    {
        $oMenu = new SegMenu();
        $oMenu->nome = request('nome');
        $oMenu->pai = request('pai', null);
        $oMenu->acao_id = request('acao');
        $oMenu->ordem = request('ordem');
        $oMenu->dica = request('dica');
        $oMenu->status = request('status', null) ? 1 : 0;

        try {
            $oMenu->save();
            return response()->json(array('msg' => 'Menu cadastrado com sucesso.'));
        } catch (\Exception $e) {
            return response()->json(array('msg' => $e->getMessage()));
        }
    }

    public function editar($id)
    {
        $aAcao = SegAcao::where('destaque', true)->orderBy('nome')->get();
        $oMenu = SegMenu::find($id);
        $oPai = new MenuDB();
        $aPai = $oPai->acaoRaiz();

        return view('Seguranca::menu.editar', compact('oMenu', 'aAcao', 'aPai'));
    }

    public function grid()
    {
        $oMenu = new MenuDB();
        $aMenu = $oMenu->gerarMenu();
        return response()->json(Paginacao::dataTables($aMenu, true));
    }

    public function update(MenuRequest $request)
    {
        $oMenu = SegMenu::find(request('menu'));
        $oMenu->nome = request('nome');
        $oMenu->dica = request('dica');
        $oMenu->acao_id = request('acao');
        $oMenu->status = request('status', null) != null ? 1 : 0;
        $oMenu->ordem = request('ordem', 1);
        $oMenu->pai = request('pai', null);

        try {
            $oMenu->save();
            return response()->json(array('msg' => 'Menu alterado com sucesso.'));
        } catch (\Exception $e) {
            response()->json(['msg' => $e->getMessage(), 500]);
        }
    }

    public function excluir()
    {
        $id = request('id', null);

        if ($id && SegMenu::destroy($id)) {
            return response()->json(array('msg' => 'Menu excluído com sucesso.'));
        } else {
            response()->json(['msg' => $e->getMessage(), 500]);
        }
    }
}
