<?php
class FEpisode{

private static $table = "episode";

private static $value = "(:episode_id, :episode_title, :episode_description, :episode_creation_date, :episode_streams, : podcast_id, :audio_data, :image_data, :audio_mimetype, :image_mimetype)";

private static $key = "episode_id";

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