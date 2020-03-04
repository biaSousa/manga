<?php
namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Support\Facades\DB;
use PoliciaCivil\Seguranca\App\Models\Entity\SegGrupo;

class PerfilDB
{

    public function grid()
    {
        $db = DB::table("seg_perfil")
            ->where('id', '!=', 1); //ocultando perfil de root pois suas permissões são dadas via código

        if (request('nome', null)) {
            $db->where('nome', 'ilike', request('nome') . '%');
        }
        return $db;
    }

    /**
     * Retorna um array com todos os ids de todos os perfis do usuário informado
     *
     * @param int $usuario_id
     * @return array
     */
    public static function perfilSimplificado($usuario_id): array
    {
        //obtendo todos os perfis do usuário
        $oGrupos = SegGrupo::where('usuario_id', $usuario_id)->pluck('perfil_id');
        return $oGrupos->toArray();
    }

}
