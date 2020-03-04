<?php

namespace PoliciaCivil\Seguranca\App\Models;

use Illuminate\Support\Facades\DB as DBLaravel;


class DB extends DBLaravel
{
    static $TRANSACTION = false;

    public static function commit()
    {
        self::criarLog();
    }

    public static function beginTransaction()
    {
        self::$TRANSACTION = true;
        parent::beginTransaction();
    }

    public static function criarLog()
    {
        $oHistorico = Historico::getInstance();
        $oHistorico->commitAndClean();
    }

    public static function rollback()
    {
        $oHistorico = Historico::getInstance();
        $oHistorico->rollback();
        self::$TRANSACTION = false;
    }
}