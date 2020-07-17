<?php

namespace app\core\traits;

trait NewTrait
{
    private static $_instance = null;

    public static function new()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}