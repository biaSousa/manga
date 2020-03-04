<?php
namespace PoliciaCivil\Seguranca\App\Models\Facade;

use Illuminate\Support\Facades\DB;

class PermissaoDB {
    private $schema = '';

    public function __construct()
    {
        $schema = config('database.connections.pgsql.schema');
        $this->schema = $schema ? $schema.'.' : null;
    }

    public function dependencia(array $aAcoes, $excluir = null)
    {
        $aDependencia = DB::table("{$this->schema}seg_dependencia")
            ->select('acao_dependencia_id')
            ->whereIn('acao_atual_id', $aAcoes);


        if($excluir)
            $aDependencia->whereNotIn('acao_dependencia_id', $aAcoes);

        $aDependencia = $aDependencia->get()->toArray();

        $aResultado = [];
        foreach ($aDependencia as $a) {
            $aResultado[] = $a->acao_dependencia_id;
        }

        $aAcoes = array_unique(array_merge($aAcoes, $aResultado));

        if(!empty($aResultado)) {//verifica também as dependências das dependências (se houver)
            return array_merge($aResultado, $this->dependencia($aResultado, $aAcoes));
        } else {
            return array();
        }
    }
}