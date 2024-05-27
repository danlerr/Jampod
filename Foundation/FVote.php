<?php
class FVote{


private static $table = "vote";

private static $value = "(:vote_id, :value, :user_id, :episode_id)";

private static $key = "vote_id";

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