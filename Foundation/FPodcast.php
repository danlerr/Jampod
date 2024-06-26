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
            $obj->setPodcastId($ObjectPodcastId);
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

    public static function updateObject($obj, $field, $fieldValue){            //metodo per aggiornare un oggetto podcast dal DB
        
        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, self::getKey(), $obj->getId());
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



   
    public static function createEntity($queryResult) {
        $podcasts = array();
    
        foreach ($queryResult as $result) {
            $p = new EPodcast(
                $result['podcast_name'],
                $result['podcast_description'],
                $result['user_id'],
                $result['category_id']
            );
    
            $p->setPodcastId($result['podcast_id']);
            $p->setImageData($result['image_data']);
            $p->setImageMimetype($result['image_mimetype']);
            $p->setSubcribe_counter($result['subscribe_counter']);
    
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['podcast_creation_date']);
            if ($dateTime !== false) {
                $p->setCreationTime($dateTime);
            }
    
            $podcasts[] = $p;
        }
    
        if (count($podcasts) === 1) {
            return $podcasts[0];
        }
    
        return $podcasts;
    }
    
    public static function bind($stmt, EPodcast $podcast){     
        $stmt->bindValue(':podcast_id', null, PDO::PARAM_NULL);                           //bind function 
        $stmt->bindValue(':podcast_name',$podcast->getPodcastName(), PDO::PARAM_STR);
        $stmt->bindValue(':podcast_description',$podcast->getPodcastDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':user_id',$podcast->getUserId(), PDO::PARAM_STR);
        $stmt->bindValue(':category_id',$podcast->getPodcastCategory(), PDO::PARAM_STR);
        $stmt->bindValue(':subscribe_counter',$podcast->getSubscribeCounter(), PDO::PARAM_STR);
        $stmt->bindValue(':image_data',$podcast->getImageData(), PDO::PARAM_LOB);
        $stmt->bindValue(':image_mimetype',$podcast->getImageMimeType(), PDO::PARAM_STR);
        $stmt->bindValue(':podcast_creation_date',$podcast->getTimetoStr(), PDO::PARAM_STR);

    }
}