<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity\TipoCurso;
use App\Models\Entity\TipoPessoa;
use App\Models\Entity\TipoEvento;
use App\Models\Entity\TipoTrabalho;
use App\Models\Entity\Participante;
use App\Models\Facade\TipoPessoaDB;
use App\Models\Facade\TipoEventoDB;
use App\Models\Facade\TipoTrabalhoDB;
use App\Models\Entity\Realizadores;
use App\Models\Entity\TipoInstituicao;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class BiancaController extends Controller
{
    public function participante()
    {
        $tipoPessoa = TipoPessoa::orderBy('nome')->get();
        $tipoPessoa = TipoPessoa::all();

        return view('bianca.teste');
    }

    public function evento()
    {
        $tipoEvento = TipoEvento::all();

        return view('evento.index');
    }

    // public function grid(Request $request)
    // {
    //     $params = (object) $request->all();
    //     return ['data' => PessoaDB::grid($params)];
    // } 

    public function create()
    {
        $tipoPessoa = TipoPessoa::all();
        $tipoEvento = TipoEvento::all();

        return view('bianca.teste');
    }

    //CAD DE UM NOVO PARTICIPANTE PELO PARTICIPANTE
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $b = (object) $request->all();

            $pessoa = TipoPessoa::create([
                'nome' => $b->tipoPessoa
            ]);

            $evento = TipoEvento::create([
                'nome' => $b->tipoEvento
            ]);

            $curso = TipoCurso::create([
                'nome' => $b->tipoCurso
            ]);

            $trabalho = TipoTrabalho::create([
                'nome' => $b->tipoTrabalho
            ]);

            Participante::create([
                'fk_tipo_pessoa' => $pessoa['id'],
                'fk_tipo_evento' => $evento['id'],
                'fk_tipo_curso'  => $curso['id'],
                'fk_tipo_trabalho'  => $trabalho['id']
            ]);

            DB::commit();

            return response()->json(['retorno' => 'sucesso', 'msg' => 'Agora você é um participante']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['retorno' => 'erro', 'msg' => 'Algo inesperado ocorreu. <br>' . $e->getMessage(), 500]);
        }
    }

    //CAD DE UM NOVO CURSO POR UM REALIZADOR RESPONSAVEL DO EVENTO
    public function salvaCurso(Request $request)
    {
        DB::beginTransaction();

        try {
            $e = (object) $request->all();

            $realizadores = Realizadores::create([
                'nome' => $e->realizadores
            ]);

            $tipoCurso = TipoCurso::create([
                'nome' => $e->tipoCurso
            ]);

            TipoCursoDB::create([
                'fk_realizadores' => $realizadores['id'],
                'fk_tipo_curso'   => $tipoCurso['id'],
            ]);

            DB::commit();

            return reponse()->json(['retorno' => 'sucesso', 'msg' => 'Evento salvo com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return reponse()->json(['retorno' => 'erro', 'msg' => 'Algo inesperado ocorreu. <br>' . $e->getMessage(), 500]);
        }
    }

    //CAD DE UM NOVO EVENTO POR UM REALIZADOR RESPONSAVEL
    public function salvaEvento(Request $request)
    {
        DB::beginTransaction();

        try {
            $e = (object) $request->all();

            $evento = TipoEvento::create([
                'nome' => $e->tipoEvento
            ]);

            $realizadores = Realizadores::create([
                'nome' => $e->realizadores
            ]);

            $participantes = Participante::created([
                'nome' => $e->participantes
            ]);

            $instituicao = TipoInstituicao::create([
                'nome' => $e->instituicao
            ]);

            TipoEventoDB::create([
                'fk_tipo_evento'  => $evento['id'],
                'fk_realizadores' => $realizadores['id'],
                'fk_participante' => $participantes['id'],
                'fk_instituicao'  => $instituicao['id']
            ]);

            DB::commit();

            return reponse()->json(['retorno' => 'sucesso', 'msg' => 'Evento salvo com sucesso.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return reponse()->json(['retorno' => 'erro', 'msg' => 'Algo inesperado ocorreu. <br>' . $e->getMessage(), 500]);
        }
    }

    public function getEventoByName($id)
    {
        $evento = TipoEventoDB::getEventoByName($id);
        return response()->json($evento);
    }

    public function getPessoaById($id)
    {
        $pessoas = TipoPessoaDB::getPessoaById($id);
        return response()->json($pessoas);
    }

    public function getTrabalho($id)
    {
        $trabalho = TipoTrabalhoDB::getTrabalho($id);
        return response()->json($trabalho);
    }

    public function getCurso()
    {
        $curso = TipoCurso::all();
        $newCurso = [];

        foreach ($curso as $b) {
            $newCurso[$b->id] = $b->nome;
        }
        return response()->json($newCurso);
    }

    public function getEvento()
    {
        $evento = TipoEvento::all();
        $newEvento = [];

        foreach ($evento as $b) {
            $newEvento[$b->id] = $b->nome;
        }
        return response()->json($newEvento);
    }

    public function getPessoa()
    {
        $pessoa = TipoPessoa::all();
        $newPessoa = [];

        foreach ($pessoa as $b) {
            $newPessoa[$b->id] = $b->nome;
        }
        return response()->json($newPessoa);
    }

    // public function removeItem($id)
    // {
    //     try {
    //         $rcurso = TipoCurso::find($id);
    //         if ($rcurso) {
    //             $rcurso->delete();
    //         }
    //         return response()->json(['retorno' => 'sucesso', 'msg' => 'Registro removido com sucesso.']);
    //     } catch (\Exception $e) {
    //         return response()->json(['retorno' => 'erro', 'msg' => 'Falha ao tentar remover o registro. ' . $e->getMessage(), 500]);
    //     }
    // }
}
