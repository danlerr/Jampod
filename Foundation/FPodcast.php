<?php
    
    class FPodcast{

    private static $table = "podcast";

    private static $value = "(:podcast_id,:category_name,:podcast_name,:podcast_description,:user_id,:subscribe_counter,:podcast_creation_date,:image_data,:image_mimetype)";

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
        
        if (isset($queryResult['podcast_id'])) {
            $queryResult = array($queryResult); // Converte il singolo risultato in un array di risultati
        }
    
        foreach ($queryResult as $result) {
            $p = new EPodcast(
                $result['podcast_name'],
                $result['podcast_description'],
                $result['user_id'],
                $result['category_name']
            );
    
            $p->setPodcastId($result['podcast_id']);
            $p->setImageData($result['image_data']);
            $p->setImageMimetype($result['image_mimetype']);
            $p->setSubcribe_counter($result['subscribe_counter']);
    
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['podcast_creationtime']);
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
        $stmt->bindValue(':category_name',$podcast->getPodcastCategory(), PDO::PARAM_STR);
        $stmt->bindValue(':subscribe_counter',$podcast->getSubscribeCounter(), PDO::PARAM_STR);
        $stmt->bindValue(':image_data',$podcast->getImageData(), PDO::PARAM_LOB);
        $stmt->bindValue(':image_mimetype',$podcast->getImageMimeType(), PDO::PARAM_STR);
        $stmt->bindValue(':podcast_creation_date',$podcast->getTimetoStr(), PDO::PARAM_STR);

    }
    public static function allCategories(){
        $table = 'category';
        $categories =(FDataBase::getInstance()->retrieveAll($table));
        $strCategories = array();
        foreach ($categories as $category){
            $category_name = $category['category_name'];
            array_push($strCategories, $category_name);
        }
        return $strCategories;
    }

    public static function retrieveFeaturePodcasts() {
        $podcasts = FDataBase::retrieveAll(self::getTable());
        
        if ($podcasts) {
            $allfeature = array();
    
            foreach ($podcasts as $Fpodcast) {
                $podcast = FPodcast::createEntity($Fpodcast);
                $podcast_id = $podcast->getId();
                $episodes = FEpisode::retrieveMoreEpisodes($podcast_id);
    
                if ($episodes) {
                    $sum = 0;
                    $count = 0;
    
                    foreach ($episodes as $episode) {
                        $episode_id = $episode->getId();
                        $AVGvote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                        $sum += $AVGvote;
                        $count++;
                    }
    
                    $AVGPodcastvote = ($count > 0) ? ($sum / $count) : 0;
    
                    if ($AVGPodcastvote > 4) {
                        $podcastData = array(
                            'podcast_id' => $podcast->getId(),
                            'podcast_name' => $podcast->getPodcastName(),
                            'podcast_description' => $podcast->getPodcastDescription(),
                            'user_id' => $podcast->getUserId(),
                            'category_name' => $podcast->getPodcastCategory(),
                            'subscribe_counter' => $podcast->getSubscribeCounter(),
                            'image_data' => $podcast->getImageData(),
                            'image_mimetype' => $podcast->getImageMimeType(),
                            'podcast_creation_date' => $podcast->getTimetoStr()
                        );
                        $allfeature[] = $podcastData; // Aggiungi il podcast all'array
                    }
                }
            }
    
            shuffle($allfeature); // Mescola l'array $allfeature
    
            // Prendi i primi 5 elementi mescolati
            $featurearray = array_slice($allfeature, 0, 5);
    
            return $featurearray;
        } else {
            return array();
        }
    }

    public static function retrieveNewPods(){
        $new = FDataBase::getInstance()->retrieveNewObj(self::getTable(), 5);
        return $new;
    }

    public static function randomPodcasts(){
        $podcasts = FDataBase::getInstance()->retrieveAll(self::getTable());
        shuffle($podcasts);
        $rand5 = array_slice($podcasts, 5);

        return $rand5;
    }

    public static function myPodcasts($user_id){
        $myPodcasts = FDataBase::getInstance()->retrieve(self::getTable(), 'user_id', $user_id);
        return $myPodcasts;
    }

    public static function retrieveByCategory($category_name){
        $podCategory = FDataBase::getInstance()->retrieve(self::getTable(), 'category_name', $category_name);
        return $podCategory;
    }

    public static function search ($query){
        $result = FDataBase::getInstance()->searchPodcastsByName($query);
        if ($result){
            return $result;
        }else{
            return array();
        }
    }

    public static function retrieveAll(){
        $podcasts = FDataBase::getInstance()->retrieveAll(self::getTable());
        if (!is_array($podcasts)){
            $podcasts = [$podcasts];
        }
        if ($podcasts){
            return $podcasts;
        }else{
            return array();
        }
    }

    
}