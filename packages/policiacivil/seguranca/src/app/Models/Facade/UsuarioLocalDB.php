<?php

namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioLocalDB extends Model
{
    /**
     * Retorna nome e email de todos os usuários do sistema atual
     * para ser usado com a classe de paginação (sql não executado)
     * @param null $nome
     * @param null $email
     * @return mixed
     */
    public static function grid($nome = null, $email = null)
    {
        $schema_seguranca = config('database.connections.seguranca.schema');
        $codigo_sistema = config('policia.codigo');

        $sql = DB::table("$schema_seguranca.usuario as u")
                ->join("$schema_seguranca.usuario_sistema as us", 'u.id', '=', 'us.usuario_id')
                ->where('us.sistema_id', $codigo_sistema)
                ->where('u.excluido', false)
                ->select('u.id', 'u.nome', 'u.email');

        if($nome) {
            $sql->where('u.nome', 'ilike', "%$nome%");
        }

        if($email) {
            $sql->where('u.email', $email);
        }

        return $sql;
    }

    /**
     * Retorna todos os perfis cadastrados exceto o 1 - Administrador do sistema
     * @param bool $ocultarAdministrador
     * @return
     */
    public static function perfis($ocultarAdministrador = true)
    {
        $schema = config('database.connections.conexao_padrao.schema');

        $sql = DB::table("$schema.seg_perfil as p");

        if($ocultarAdministrador)
            $sql->where("id", '!=', 1);

        return $sql->get();
    }
//    public static function perfis($ocultarAdministrador = true)
//    {
//        $schema = config('database.connections.conexao_padrao.schema');
//
//        $sql = DB::table("$schema.seg_grupo as g")
//                ->join("$schema.seg_perfil as p", 'p.id', '=', 'g.perfil_id');
//
//        if($ocultarAdministrador)
//            $sql->where("perfil_id", '!=', 1);
//
//        return $sql->get();
//    }

    public static function perfilUsuario($id_usuario)
    {
        $schema = config('database.connections.conexao_padrao.schema');

        return DB::table("$schema.seg_grupo as g")
            ->where('usuario_id', $id_usuario)
            ->join("$schema.seg_perfil as p", 'p.id', '=', 'g.perfil_id')
            ->select('p.id', 'p.nome')
            ->get();
    }
}
