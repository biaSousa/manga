<?php

namespace PoliciaCivil\Seguranca\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PoliciaCivil\Seguranca\App\Http\Requests\SolicitacaoUsuarioRequest;
use PoliciaCivil\Seguranca\App\Models\Regras\PreCadastroRegras;
use PoliciaCivil\Seguranca\app\Models\SolicitacaoAcessoRegras;

class FormularioAcessoController extends Controller
{
    // public function solicitacaoUsuario(Request $request)
    // {
    //     $sucesso = null;
    //     if ($request->session()->has('sucesso')) {
    //         $sucesso = $request->session()->get('sucesso');
    //     }
    //     //tela abaixo é o fomulário completo
    //     // return view('Seguranca::usuario.solicitacao-usuario', compact('sucesso'));
    //     return view('Seguranca::formulario-acesso.passo1');
    // }

    public function passo1(Request $request)
    {
        $sucesso = session('sucesso');
        return view('Seguranca::formulario-acesso.passo1', compact('sucesso'));
    }

    public function validarPasso1()
    {
        $cpf = request('cpf');
        $email = request('email');

        //poupa o usuário existente de digitar tudo novamente
        //retorna mensagem de sucesso
        if (PreCadastroRegras::verificarUsuarioExistente($cpf, $email)) {

            PreCadastroRegras::salvarUsuarioComCadastroAtivo($cpf, $email);
            return redirect('cadastro')->with('sucesso', true);
        }

        return view('Seguranca::formulario-acesso.passo2', compact('cpf', 'email'));
    }

    public function passo2()
    {
        $cpf = request('cpf', null);
        $email = request('email', null);

//        //poupa o usuário existente de digitar tudo novamente
//        //retorna mensagem de sucesso
//        if (PreCadastroRegras::verificarUsuarioExistente($cpf, $email)) {
//
//            PreCadastroRegras::salvarUsuarioComCadastroAtivo($cpf, $email);
//            return redirect('cadastro')->with('sucesso', true);
//        }

        return view('Seguranca::formulario-acesso.passo2', compact('cpf', 'email'));
    }

    public function store(SolicitacaoUsuarioRequest $request)
    {
        if ($request->isMethod('post')) {
            $p = new \stdClass;
            $p->nome = request('nome');
            $p->email = request('email');
            $p->cpf = request('cpf');
            $p->nascimento = request('nascimento');
            $p->unidade = request('unidade');
            $p->senha = request('senha');

            try {
                PreCadastroRegras::salvar($p);
                //mensagem salva na sessão apenas até a próxima requisição
                $request->session()->flash('sucesso', 'Solicitação enviada com sucesso.');

                return redirect('cadastro');
            } catch (\Exception $e) {
                if (config('app.debug')) {
                    printvardie($e->getMessage());
                } else {
                    die('Falha ao criar usuário');
                }
            }
        }
    }
}
