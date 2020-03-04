<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entity\Tipo;
use App\Models\Entity\Marca;
use App\Models\Entity\Modelo;
use App\Models\Entity\Status;
use App\Models\Entity\Garantia;
use App\Models\Facade\TipoDB;
use App\Models\Facade\ModeloDB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class EquipamentoController extends Controller
{
    public function index()
    {        
        $tipo     = Tipo::all();
        $marca    = Marca::all();
        $modelo   = Modelo::all();
        $status   = Status::all();
        $garantia = Garantia::all();
        // $patrimonio = Patrimonio::all();
      
        return view('equipamento.index', compact('tipo', 'marca', 'modelo', 'status', 'garantia'));
    }

    public function saida()
    {        
        return view('equipamento.saida');
    }

    public function entrada()
    {        
        return view('equipamento.entrada');
    }

    public function gridEntrada(Request $request)
    {
        $params = (object) $request->all();
        return ['data' => PessoaDB::grid($params)];
    } 

    public function create()
    {
        $tipoPessoa = TipoPessoa::all();
        $tipoEvento = TipoEvento::all();

        return view('bianca.teste');
    }

    // CAD DE UM NOVO CURSO POR UM REALIZADOR RESPONSAVEL DO EVENTO
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

    // public function getTipo()
    // {
    //     $pessoa = TipoPessoa::all();
    //     $newPessoa = [];

    //     foreach ($pessoa as $b) {
    //         $newPessoa[$b->id] = $b->nome;
    //     }
    //     return response()->json($newPessoa);
    // }

}
