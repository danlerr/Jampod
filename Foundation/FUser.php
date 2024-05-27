<?php

    class FUser{

    private static $table = "user";

    private static $value = "(:user_id,:username,:name,:surname,:email,:password,:balance,:is_admin)";

    private static $key = "user_id";

    public static function getTable()
    {
        return self::$table;
    }

    public static function getValue()
    {
        return self::$value;
    }

    public static function getClass()
    {
        return self::class;
    }

    public static function getKey()
    {
        return self::$key;
    }
    
}