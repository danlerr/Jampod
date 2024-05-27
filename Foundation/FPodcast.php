<?php
    
    class FPodcast{

    private static $table = "podcast";

    private static $value = "(:podcast_id,:category_id,:podcast_name,:podcast_description,:user_id,:subscribe_counter,:podcast_creation_date,:image_data,:image_mimetype)";

    private static $key = "podcast_id";

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