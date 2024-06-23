<?php

class FEpisode{

private static $table = "episode";

private static $value = "(:episode_id, :episode_title, :episode_description, :episode_creationtime, :episode_streams, : podcast_id, :audio_data, :image_data, :audio_mimetype, :image_mimetype)";

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

//"converte" il contenuto dell'array risultante da una query in oggetto entity della rispettiva classe
public static function createEntity($queryResult){
    if(count($queryResult) > 0){
        $episodes = array();
        for($i = 0; $i < count($queryResult); $i++){
            $e = new EEpisode($queryResult[$i]['episode_title'],$queryResult[$i]['episode_description'],$queryResult[$i]['podcast_id']);
            $e->setEpisodeId($queryResult[$i]['episode_id']);
            $e->setImageData($queryResult[$i]['image_data']);
            $e->setImageMimetype($queryResult[$i]['image_mimetype']);
            $e->setAudioData($queryResult[$i]['audio_data']);
            $e->setAudioMimetype($queryResult[$i]['audio_mimetype']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['episode_creationtime']);
            $e->setCreationTime($dateTime);
            $episodes[] = $e; //aggiunge l'oggetto episodio nell'array di episodi
        }
        return $episodes;
    }else{
        return array();
    }
}
//metodo bind per associare i valori di Episode nei segnaposto di una query pdo preparata
//lega gli attributi dell'episodio da inserire con i parametri della INSERT
public static function bind($stmt, EEpisode $episode){
    $stmt->bindValue(":episode_title", $episode->getEpisode_title(), PDO::PARAM_STR);
    $stmt->bindValue(":episode_description", $episode->getEpisode_description(), PDO::PARAM_STR);
    $stmt->bindValue(":episode_streams", $episode->getEpisode_streams(), PDO::PARAM_INT);
    $stmt->bindValue(":episode_creation_date", $episode->getTimetoStr(), PDO::PARAM_STR);
    $stmt->bindValue(":podcast_id", $episode->getPodcastId(), PDO::PARAM_INT); //????
    $stmt->bindValue(":audio_data", $episode->getAudioData(), PDO::PARAM_LOB);
    $stmt->bindValue(":image_data", $episode->getImageData(), PDO::PARAM_LOB);
    $stmt->bindValue(":audio_mimetype", $episode->getAudioMimeType(), PDO::PARAM_STR);
    $stmt->bindValue(":image_mimetype", $episode->getImageMimeType(), PDO::PARAM_STR);

}
//metodo per "salvare" un oggetto episodio dal DB. Ritorna l'id identificativo dell'episodio
public static function createObject($obj){ 
    $ObjectEpisode_id = FDataBase::getInstance()->create(self::getClass(), $obj);
    if( $ObjectEpisode_id !== null){
        $obj->setEpisodeId($ObjectEpisode_id);
        return true;
    }else{
        return false;
    }
}
//metodo per "recuperare" un oggetto episodio dal DB (conversione in entity) utilizzando l'id
public static function retrieveObject($episode_id){ 
    $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $episode_id); 
    if(count($result) > 0){
        $episode = self::createEntity($result);
        return $episode;
    }else{
        return null;
    }
}
//metodo per aggiornare l'oggetto 
public static function updateObject($obj, $field, $fieldValue){
    $updateEpisode = FDataBase::getInstance()->update(self::getTable(), $field, $fieldValue, self::getKey(), $obj->getId());
    if($updateEpisode !== null){
        return true;
    }else{
        return false;
    }
}

//metodo che cancella un oggetto dato l'id 
public static function deleteObject($field, $id){
    $result = FDatabase::getInstance()->delete(self::getClass(), $field, $id);
    if($result) return true;
      else return false;

  }




}