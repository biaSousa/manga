<?php

namespace PoliciaCivil\Seguranca\App\Models;

class Util
{
    /**
     * Verifica se o array aParametro possui todas as chaves contidas em $obrigatorio
     * @param array $obrigatorio
     * @param array $aParametro
     * @return bool
     */
    public static function todasAsChavesPresentes(array $obrigatorio, array $aParametro)
    {
        $aChaves = array_keys($aParametro);
        foreach ($obrigatorio as $o) {
            if (!in_array($o, $aChaves)) {
                return false;
            }

        }
        return true;
    }

    public static function mesPorExtenso($mes)
    {
        switch ($mes) {
            case 1:
                return 'Janeiro';
                break;
            case 2:
                return 'Fevereiro';
                break;
            case 3:
                return 'Março';
                break;
            case 4:
                return 'Abril';
                break;
            case 5:
                return 'Maio';
                break;
            case 6:
                return 'Junho';
                break;
            case 7:
                return 'Julho';
                break;
            case 8:
                return 'Agosto';
                break;
            case 9:
                return 'Setembro';
                break;
            case 10:
                return 'Outubro';
                break;
            case 11:
                return 'Novembro';
                break;
            case 12:
                return 'Dezembro';
                break;
            default:
                return 'Valor Inválido';
        }
    }

    public static function converteDataEN_PorExtenso($data)
    {
        list($ano, $mes, $dia) = explode('-', $data);
        $mesExtenso = self::mesPorExtenso($mes);
        return "$dia de $mesExtenso de $ano";
    }

    public static function converteDataPorExtenso($data, $padraoBrasil = true)
    {
        if($padraoBrasil) {
            list($dia, $mes, $ano) = explode('/', $data);
        } else {
            list($ano, $mes, $dia) = explode('-', $data);
        }
        $mesExtenso = self::mesPorExtenso($mes);
        return "$dia de $mesExtenso de $ano";
    }

    /**
     * Mascara feita em php.
     * Ex:
     * Utils::mascara($cnpj,'##.###.###/####-##');
     * Utils::mascara($cpf,'###.###.###-##');
     *
     * @param $val
     * @param $mascara
     * @return string
     */
    public static function mascara($val, $mascara)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mascara) - 1; $i++) {
            if ($mascara[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mascara[$i])) {
                    $maskared .= $mascara[$i];
                }
            }
        }
        return $maskared;
    }
}
