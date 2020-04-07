<?php

namespace App\Models\Regras;

use App\Models\Entity\Setor;
use App\Models\Entity\Cargo;
use App\Models\Entity\Unidade;
use App\Models\Entity\Servidor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class PlantaoRegras
{
    public static function grid(\stdClass $q): Builder
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

        if ($q->servidor) {
            $db->whereRaw("se.nome ilike '%$q->servidor%'");
        }

        if ($q->matricula) {
            $db->where('se.matricula', $q->matricula);
        }

        if ($q->cpf) {
            $db->where('se.cpf', $q->cpf);
        }

        if(isset($q->unidade)) {
            $db->where('se.fk_unidade', $q->unidade);
        }

        if(isset($q->setor)) {
            $db->where('se.fk_setor', $q->setor);
        }

        if(isset($q->cargo)) {
            $db->where('se.fk_cargo', $q->cargo);
        }

        return $db;
    }
}
