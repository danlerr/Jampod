<?php

class FComment{
    
    private static $table="comment";
    private static $value="(:comment_id,:comment_text,:comment_creation_date,:user_id,:episode_id)";
    private static $key="comment_id";

    
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