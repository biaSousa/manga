<?php

namespace PoliciaCivil\Seguranca\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facade\SegPreCadastroDB;
use Illuminate\Http\Request;
use PoliciaCivil\Seguranca\App\Models\DB;
use PoliciaCivil\Seguranca\App\Models\Exception\PreCadastroNaoEncontradoException;
use PoliciaCivil\Seguranca\App\Models\Facade\UsuarioLocalDB;
use PoliciaCivil\Seguranca\App\Models\Paginacao;
use PoliciaCivil\Seguranca\App\Models\Regras\PreCadastroRegras;
use PoliciaCivil\Seguranca\App\Models\Regras\UsuarioRegras;

class SolicitacaoAcessoController extends Controller
{
    public function index()
    {
        return view('Seguranca::precadastro.index');
    }

    public function grid()
    {
        $oSegPreCadastroDB = new SegPreCadastroDB();

        $p = new \stdClass;
        $p->nome = request('nome');
        $p->email = request('email');
        $p->cpf = request('cpf');

        return response()->json(Paginacao::dataTables($oSegPreCadastroDB->grid($p), true));
    }

    public function editar($id)
    {
        //o id que chega aqui é o id de pre_cadastro
        $oPreCadastro = null;
        try {
            $oPreCadastro = PreCadastroRegras::infoUsuario($id);

        } catch (PreCadastroNaoEncontradoException $e) {

            die('Não existe o cadastro solicitado');

        }

        $aPerfisCadastrados = UsuarioLocalDB::perfis();

        //reproveitando a tela de castro de usuário local
        return view('usuario.criar', compact('aPerfisCadastrados', 'oPreCadastro'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        DB::beginTransaction();
        try {

            $carga = [
                'nome' => request('nome'),
                'email' => request('email'),
                'senha' => request('senha'),
                'cpf' => request('cpf', null),
                'nascimento' => request('dt_nascimento', null),
                'unidade' => request('unidade', null),
                'primeiro_acesso' => request('renovar_senha', null),
                'perfil' => request('perfil', [])
            ];

            UsuarioRegras::criarUsuarioViaPreCadastro($carga);

            DB::commit();
            return response()->json('Usuário criado com sucesso');

        } catch (\Exception $e) {

            DB::rollback();
            if (config('app.debug')) {
                return response()->json($e->getMessage())->setStatusCode(422);
            } else {
                return response()->json('Falha ao criar usuário')->setStatusCode(422);
            }
        }
    }

    public function excluir()
    {
        $id = request('id', null);

        try {
            PreCadastroRegras::excluir($id);
            return response()->json(['message' => 'Cadastro excluído com sucesso.']);
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return response()->json(['message' => $e->getMessage()], 500);
            } else {
                return response()->json(['message' => 'Falha ao excluir cadastro.'], 500);
            }
        }

    }

}
