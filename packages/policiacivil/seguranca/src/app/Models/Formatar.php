<?php

namespace PoliciaCivil\Seguranca\App\Models;

class Formatar {

    /**
     * Retorna a data em um determinado formato. O padrão é "exibr" a data para o usuario
     * no formato dd/mm/YYYY. Se quiser salvar num banco basta digitar "salvar", no
     * segundo parâmetro para receber no formato YYYY-mm-dd
     * @param $data
     * @param string $formato
     * @return mixed
     */
    public static function data($data, $formato = 'exibir')
    {
        //descobre qual o caracter que separa a data
        preg_match('/[^0-9]/', $data, $caraterSeparador);
        $caraterSeparador = array_shift($caraterSeparador);

        if(!$caraterSeparador)
            return null;

        if($formato == 'exibir') {//exibir dd/mm/YYYY
            return implode('/', array_reverse(explode($caraterSeparador, $data)));
        } else {//salvar YYYY-mm-dd
            return implode('-', array_reverse(explode($caraterSeparador, $data)));
        }
    }

    
}