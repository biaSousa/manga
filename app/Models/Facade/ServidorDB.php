<?php

namespace App\Models\Facade;
use App\Models\Paginacao;
use App\Models\Entity\Cargo;
use App\Models\Entity\Setor;
use App\Models\Entity\Servidor;
use App\Models\Entity\Unidade;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class ServidorDB extends Model
{
//from bono
public static function grid(\stdClass $q): Builder
{
        $schema = config('database.connections.conexao_siga.schema');

        $db = DB::table('plantao as p')
            ->whereNull('deleted_at')
//            ->join('plantao_dia as pd', 'pd.fk_id_plantao', '=', 'p.id')
            ->join('plantao_situacao as ps', 'ps.id', '=', 'p.fk_plantao_situacao')
            ->join("{$schema}.sig_servidor as ss", 'p.fk_servidor', '=', 'ss.id_servidor')
            ->orderBy('p.id', 'desc')
            ->select([
                'p.id',
                'ss.nome as servidor',
                'ss.matricula',
                'p.ano_plantao as ano',
                'p.mes_plantao as mes',
                'ps.nome as situacao',
                'ps.id as situacao_id'
            ]);

        if ($q->servidor) {
            $db->whereRaw("ss.nome ilike '%$q->servidor%'");
        }

        if ($q->matricula) {
            $db->where('ss.matricula', $q->matricula);
        }

        if ($q->mes) {
            $db->where('p.mes_plantao', $q->mes);
        }

        if ($q->ano) {
            $db->where('p.ano_plantao', $q->ano);
        }

        if ($q->situacao) {
            $db->where('ps.id', $q->situacao);
        }

        if(isset($q->unidade)) {
            $db->where('p.fk_unidade', $q->unidade);
        }

        return $db;
    }

    public static function gridServidor(\stdClass $p): Builder
    {
        $db = DB::table('servidor as se')
            ->join('unidade as u', 'u.id', '=', 'se.fk_unidade')
            ->join('setor as s', 's.id', '=', 'se.fk_setor')
            ->join('cargo as c', 'c.id', '=', 'se.fk_cargo')
            ->orderBy('se.id', 'asc')
            ->select([
                'se.id',
                'se.cpf',
                'se.matricula',
                'se.nome as servidor',
                'c.nome as cargo',
                's.nome as setor',
                'u.nome as unidade',
            ]);

        if (isset($p->servidor)) {
            $db->whereRaw("se.servidor ilike '%$p->servidor%'");
        }

        if (isset($p->matricula)) {
            $db->where('se.matricula', $p->matricula);
        }

        if (isset($p->cpf)) {
            $db->where('se.cpf', $p->cpf);
        }

        if (isset($p->unidade)) {
            $db->where('se.fk_unidade', $p->unidade);
        }

        if(isset($p->setor)) {
            $db->where('se.fk_setor', $p->setor);
        }

        if(isset($p->cargo)) {
            $db->where('se.fk_cargo', $p->cargo);
        } 

        // $abia = Paginacao::dataTables($db);
        // echo "<pre>";
        // var_dump($abia);
        // echo "</pre>";

        return $db;
    }
}
