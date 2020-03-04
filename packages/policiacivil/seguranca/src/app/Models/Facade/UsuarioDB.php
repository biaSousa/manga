<?php

namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\Paginacao;

class UsuarioDB
{

    /**
     * @param null $nome
     * @param null $email
     * @param null $sistema
     * @param null $status
     * @return array
     */
    public static function grid($nome = null, $email = null, $sistema = null, $status = null)
    {
        $db = DB::connection('seguranca')
            ->table('seguranca.usuario as u')
            ->select(['u.id', 'u.nome', 'u.email']);

        if ($nome) {
            $db->where('nome', 'ilike', "%$nome%");
        }
        if ($email) {
            $db->where('email', $email);
        }
        if ($sistema) {
            $db->join('seguranca.usuario_sistema as s', 's.usuario_id', '=', 'u.id')
                ->where('s.sistema_id', $sistema)
                ->groupBy('u.email', 'u.id');
        }

        // if ($status) {
        //     $db->where('status', $status);
        // }

        $aDataTables = Paginacao::dataTables($db, true);

        return $aDataTables;
    }
}
