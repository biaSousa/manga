<?php
namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Support\Facades\DB;

class MenuDB {
    private $schema = '';

    /**
     * MenuDB constructor.
     */
    public function __construct()
    {
        $schema = config('database.connections.pgsql.schema');
        $this->schema = $schema ? $schema.'.' : null;
    }
    
    public function gerarMenu()
    {
        return DB::table("{$this->schema}seg_menu as m")
                ->join("{$this->schema}seg_acao as a", 'a.id', '=', 'm.acao_id')
                ->leftJoin("{$this->schema}seg_menu as m2", 'm2.id', '=', 'm.pai')
                ->select('m.id', 'm.nome', 'm2.nome as pai', 'a.nome_amigavel', 'a.nome as acao');
    }

    /**
     * Retorna a lista de ações cadastradas como menu e seu respectivo nome
     * como menu. Como esta tela foi pensada apenas para ser usada por administradores
     * não houve a preocupação de filtrar as ações que o usuário poderá visualizar
     * @return mixed
     */
    public function acaoRaiz()
    {
        return DB::table("{$this->schema}seg_menu as m")
            ->join("{$this->schema}seg_acao as a", 'a.id', '=', 'm.acao_id')
            ->select('m.nome', 'a.id')
            ->orderBy('m.nome')
            ->whereNull('m.pai')->get();
    }
}