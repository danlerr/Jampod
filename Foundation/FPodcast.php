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
            // Verifica che tutte le chiavi necessarie siano presenti in $result
            if (isset($result['podcast_id'], $result['podcast_name'], $result['podcast_description'], 
                      $result['category_id'], $result['user_id'], $result['subcribe_counter'], 
                      $result['image_data'], $result['image_mimetype'], $result['podcast_creationtime'])) {
                
                // Creazione dell'oggetto EPodcast
                $p = new EPodcast(
                    $result['podcast_name'],
                    $result['podcast_description'],
                    $result['user_id'],
                    $result['category_id']
                );
                
                // Impostazione delle proprietà dell'oggetto EPodcast
                $p->setPodcastId($result['podcast_id']);
                $p->setImageData($result['image_data']);
                $p->setSubcribe_counter($result['subcribe_counter']);
                $p->setImageMimetype($result['image_mimetype']);
                
                // Creazione e impostazione della data di creazione
                $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['podcast_creationtime']);
                if ($dateTime !== false) {
                    $p->setCreationTime($dateTime);
                } else {
                    // Gestione dell'errore nel formato della data, se necessario
                    // Puoi scegliere di gestirlo a seconda delle tue esigenze
                }

                // Aggiunta dell'oggetto EPodcast all'array
                $podcasts[] = $p;
            } else {
                // Gestione del caso in cui manchino le chiavi necessarie
                // Puoi scegliere di gestirlo a seconda delle tue esigenze
            }
        }

        // Restituisce un singolo oggetto podcast se c'è un solo elemento nell'array
        if (count($podcasts) === 1) {
            return $podcasts[0];
        }

        // Restituisce un array di podcast se ci sono più elementi nell'array
        return $podcasts;
    }
    public static function bind($stmt, EPodcast $podcast){                              //bind function 
        $stmt->bindValue(':podcast_name',$podcast->getPodcastName(), PDO::PARAM_STR);
        $stmt->bindValue(':podcast_description',$podcast->getPodcastDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':user_id',$podcast->getUserId(), PDO::PARAM_STR);
        $stmt->bindValue(':category_id',$podcast->getPodcastCategory(), PDO::PARAM_STR);
        $stmt->bindValue(':subscribe_counter',$podcast->getSubscribeCounter(), PDO::PARAM_STR);
        $stmt->bindValue(':image_data',$podcast->getImageData(), PDO::PARAM_STR);
        $stmt->bindValue(':image_mimetype',$podcast->getImageMimeType(), PDO::PARAM_STR);
        $stmt->bindValue(':podcast_creationtime',$podcast->getCreationDate(), PDO::PARAM_STR);

    }
}