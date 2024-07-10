<?php

class FEpisode{

private static $table = "episode";

private static $value = "(:episode_id, :episode_title, :episode_description, :episode_creationtime, :episode_streams, :podcast_id, :audio_data, :image_data, :audio_mimetype, :image_mimetype)";

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
public static function createEntity($queryResult) {
    $episodes = array();

    foreach ($queryResult as $result) {
        $e = new EEpisode($result['episode_title'],
                          $result['episode_description'], 
                          $result['podcast_id']);

        $e->setEpisodeId($result['episode_id']);
        $e->setImageData($result['image_data']);
        $e->setImageMimetype($result['image_mimetype']);
        $e->setAudioData($result['audio_data']);
        $e->setAudioMimetype($result['audio_mimetype']);
        $e->setEpisodeStreams($result['episode_streams']);
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['episode_creationtime']);
        $e->setCreationTime($dateTime);
        
        $episodes[] = $e;
    }

    // Restituisce un singolo oggetto episodio se c'è un solo elemento nell'array
    if (count($episodes) === 1) {
        return $episodes[0];
    }

    // Restituisce un array di episodi se ci sono più elementi nell'array
    return $episodes;
}


//metodo bind per associare i valori di Episode nei segnaposto di una query pdo preparata
//lega gli attributi dell'episodio da inserire con i parametri della INSERT
public static function bind($stmt, EEpisode $episode){
    $stmt->bindValue(':episode_id', null, PDO::PARAM_NULL);                           //bind function 
    $stmt->bindValue(":episode_title", $episode->getEpisode_title(), PDO::PARAM_STR);
    $stmt->bindValue(":episode_description", $episode->getEpisode_description(), PDO::PARAM_STR);
    $stmt->bindValue(":episode_creationtime", $episode->getTimetoStr(), PDO::PARAM_STR);
    $stmt->bindValue(":episode_streams", $episode->getEpisode_streams(), PDO::PARAM_INT);
    $stmt->bindValue(":podcast_id", $episode->getPodcastId(), PDO::PARAM_INT); 
    $stmt->bindValue(":audio_data", $episode->getAudioData(), PDO::PARAM_LOB);
    $stmt->bindValue(":image_data", $episode->getImageData(), PDO::PARAM_LOB);
    $stmt->bindValue(":audio_mimetype", $episode->getAudioMimeType(), PDO::PARAM_STR);
    $stmt->bindValue(":image_mimetype", $episode->getImageMimeType(), PDO::PARAM_STR);

}
//metodo per "salvare" un oggetto episodio dal DB. 
public static function createObject(EEpisode $obj) {
    // Crea l'oggetto e ottieni l'ID dal database
    $ObjectEpisode_id = FDataBase::getInstance()->create(self::getClass(), $obj);   
    if ($ObjectEpisode_id !== null) {
        $obj->setEpisodeId($ObjectEpisode_id);
        return true;
    } else {
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

//metodo che cancella un oggetto dato l'id e dato un utente ( viene effettuato il controllo)
public static function deleteObject($id){
    $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
    if($result) return true;
      else return false;

  }



public static function retrieveMoreEpisodes($podcast_id) {
    $result = FDataBase::getInstance()->retrieve(self::getTable(), FPodcast::getKey(), $podcast_id); 
    
    if (count($result) > 0) {
        $episodes = self::createEntity($result);
        if (!is_array($episodes)) {
            $episodes = [$episodes];
        } 
        return $episodes;
    }else{
        return array();
    }
}
public static function retrieveAudioTrack($episode_id) {
    try {
        $episode = self::retrieveObject($episode_id);
        
        if ($episode === null) {
            throw new Exception('Episodio non trovato');
        }

        return [
            'audiodata' => $episode->getAudioData(),
            'audiomimetype' => $episode->getAudioMimeType(),
        ];

    } catch (Exception $e) {
        
        error_log('Errore nel recupero della traccia audio: ' . $e->getMessage());
        return null;
    }
}




}
  