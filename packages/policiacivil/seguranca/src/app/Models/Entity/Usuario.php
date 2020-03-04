<?php

namespace PoliciaCivil\Seguranca\App\Models\Entity;

use Hamcrest\Util;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * @property string senha
 * @property string senha2
 */
class Usuario extends Authenticatable
{
    protected $table = 'seguranca.usuario';
    public $timestamps = false;
    protected $schema_local = null;
    protected $schema_seguranca = null;
    protected $connection = 'seguranca'; //apelido no config/database.php

    /**
     * Usuario constructor.
     */
    public function __construct()
    {
        $schema_local = config('database.connections.conexao_padrao.schema');
        $schema_seguranca = config('database.connections.seguranca.schema');
        $this->schema_local = !is_null($schema_local) ? $schema_local . '.' : null;
        $this->schema_seguranca = !is_null($schema_seguranca) ? $schema_seguranca . '.' : null;
    }

    public function usuarioExiste($email)
    {
        return \DB::table($this->table)
            ->where('email', $email)->count() > 0 ? true : false;
    }

    public function setEmailAttribute($email)
    {
        return $this->attributes['email'] = mb_convert_case($email, MB_CASE_LOWER, 'UTF-8');
    }

    public function setSenhaAttribute($senha)
    {
        return $this->attributes['senha'] = sha1($senha);
    }

    public function perfis()
    {
        return $this->belongsToMany(SegPerfil::class, "{$this->schema_local}seg_grupo", 'usuario_id', 'perfil_id');
    }

    /**
     * Retorna todos os perfis ordenados por id
     * @param $query
     * @return mixed
     */
    public function scopeTodosOsPerfis($query)
    {
        return $this->perfis()->orderBy('id');
    }

    /**
     * Retorna apenas os ids do grupo e dos perfis do usuário atual no seguinte formato:
     * array(
     *   'id_grupo' => 'id_do_perfil'
     * )
     * @return array
     */
    public function listaPerfilSimplificado()
    {
        $sql = \DB::table("{$this->schema_local}seg_grupo")
            ->where('usuario_id', '=', $this->id)
            ->select('id', 'perfil_id')
            ->get();

        $a = array();
        foreach ($sql as $s) {
            $a[$s->id] = $s->perfil_id;
        }
        return $a;
    }

    /**
     * Retorna a lista de sistemas que o usuário pode usar
     * @return array
     */
    public function listaSistemaSimplificado()
    {
        $sql = \DB::connection('seguranca')
            ->table("{$this->schema_seguranca}usuario_sistema")
            ->where('usuario_id', '=', $this->id)
            ->select('id', 'sistema_id')
            ->get();

        $a = array();
        foreach ($sql as $s) {
            $a[$s->id] = $s->sistema_id;
        }
        return $a;
    }

    /**
     * Retorna nome e id de todos os sistemas que este usuário pode acessar
     * @return mixed
     */
    public function sistemas()
    {
        return \DB::connection('seguranca')
            ->table("{$this->schema_seguranca}usuario_sistema as us")
            ->join("{$this->schema_seguranca}sistema as s", 's.id', '=', 'us.sistema_id')
            ->where('usuario_id', '=', $this->id)
            ->select(['s.nome', 's.id'])->get();
    }

    public function listaPerfis()
    {
        return \DB::table("{$this->schema_local}seg_grupo as g")
            ->join("{$this->schema_local}seg_perfil as p", 'p.id', '=', 'g.perfil_id')
            ->where('g.usuario_id', '=', $this->id)
            ->select(['p.id', 'p.nome'])->get();
    }

    /**
     * Verifica se o usuário atual possui permissão para acessar este sistema
     * @return boolean
     */
    public function permissaoSistema()
    {
        return \DB::connection('seguranca')
            ->table("{$this->schema_seguranca}usuario_sistema")
            ->where('usuario_id', $this->id)
            ->where('sistema_id', config('policia.codigo'))
            ->count() ? true : false;
    }

    /**
     * Verifica se a senha digitada é válida usando o novo campo senha que não usa mais sha1
     *
     * @param $senhaTxt
     * @return bool
     */
    public function verificarSenha($senhaTxt)
    {

        if (!$this->senha2) {

            //se senha sha1 estiver correta então alimenta o campo de nova senha automaticamente
            if ($this->verificarSenhaSha1($senhaTxt)) {
                $novoHash = Hash::make($senhaTxt);
                $this->senha2 = $novoHash;
                $this->save();
            }
        }

        return crypt($senhaTxt, $this->senha2) === $this->senha2;
    }

    /**
     * Verifica se a senha digitada é válida no padrão sha1
     * o campo senha é deprecated use senha2 no lugar
     *
     * @param $senhaTxt
     * @return bool
     */
    private function verificarSenhaSha1($senhaTxt)
    {
        return sha1($senhaTxt) === $this->senha;
    }

    public function isAdmin()
    {
        return DB::table('seg_grupo')
            ->where('usuario_id', $this->id)
            ->where('perfil_id', 1)//administrador
            ->count();
    }

    /**
     * Usuário ou data de nascimento em branco ou inválidos caracterizam cadastro incompleto
     * @return bool
     */
    public function cadastroIncompleto()
    {
        return (!preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}/', $this->cpf)
            || !preg_match('/\d{2}\/\d{2}\/\d{4}/', $this->nascimento));
    }
}
