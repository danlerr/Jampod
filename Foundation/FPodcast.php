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

    public static function createObject($obj){            //metodo per "salvare" un oggetto podcast dal DB

        $ObjectPodcastId = FDataBase::getInstance()->create(self::class, $obj);
        if($ObjectPodcastId !== null){
            return true;
        }else{
            return false;
        }
    }

    public static function retrieveObject($podcast_id){      //metodo per recuperare un oggetto podcast dal DB
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $podcast_id);
        if(count($result) > 0){
            $obj = self::createEntity($result);
            return $obj;
        }else{
            return null;
        }
    }

    public static function updateObject($field, $fieldValue, $cond, $condValu){            //metodo per aggiornare un oggetto podcast dal DB
        
        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, $cond, $condValu);
        if($result){
            return true;
        }else{
         return false;
        }
    }

    public static function deleteObject($id){                //metodo per eliminare un oggetto podcast dal DB

        $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
        if($result){
            return true;
        }else{
         return false;
        }
    }



    public static function createEntity($result){            //metodo che crea un nuovo oggetto della classe EPodcast
                                                          
        $obj = new EPodcast(
            $result[0]['podcast_name'],
            $result[0]['podcast_description'],
            $result[0]['user_id'],
            $result[0]['category_id']);
                            
        $obj->setPodcastId($result[0]['podcast_id']);
        $obj->setCreationTime(date_create_from_format('Y-m-d H:i:s', $result[0]['podcast_creation_date']));
        return $obj;
    }

}