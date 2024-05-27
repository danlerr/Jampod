<?php
class FSubscribe{


private static $table = "subscribe";

private static $value = "(:subscribe_id, :podcast_id , :subscriber_id)";

private static $key = "subscribe_id";

public static function getTable(){
    return self::$table;
}

public static function getValue(){
    return self::$value;
}

public static function getClass(){
    return self::class;
}

public static function getKey(){
    return self::$key;
}

}