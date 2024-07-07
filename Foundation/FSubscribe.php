<?php
class FSubscribe{


private static $table = "subscribe";

private static $value = "(:subscribe_id, :podcast_id , :subscriber_id)";

private static $key = "subscribe_id";

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
    $subscribes = array();

    foreach ($queryResult as $result) {
        $subscribe = new ESubscribe($result['podcast_id'], $result['subscriber_id']);
        $subscribe->setSubscribeId($result['subscribe_id']);
        $subscribes[] = $subscribe;
    }

    // Restituisce un singolo oggetto se c'è un solo elemento
    if (count($subscribes) === 1) {
        return $subscribes[0];
    }

    // Restituisce un array di oggetti se ci sono più elementi
    return $subscribes;
}

public static function bind($stmt, ESubscribe $subscribe){
    $stmt->bindValue(":subscribe_id", null, PDO::PARAM_NULL);
    $stmt->bindValue(":podcast_id", $subscribe->getPodcastid(), PDO::PARAM_INT);
    $stmt->bindValue(":subscriber_id", $subscribe->getSubscriberid(), PDO::PARAM_INT);
   
  
}
//metodo per "salvare" un oggetto iscrizione dal DB. 
public static function createObject(ESubscribe $obj){ 
    $ObjectSubscribe_id = FDataBase::getInstance()->create(self::getClass(), $obj); //restituisce l'id assegnato dal db all'oggetto subscribe
    if( $ObjectSubscribe_id !== null){
        $obj->setSubscribeid($ObjectSubscribe_id);
        return true;
    }else{
        return false;
    }
}

//metodo per "recuperare" un oggetto iscrizione dal DB (conversione in entity) utilizzando l'id
public static function retrieveObject($subscribe_id){ 
    $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $subscribe_id); 
    if(count($result) > 0){
        $subscribe = self::createEntity($result);
        return $subscribe;
    }else{
        return null;
    }
}
//metodo che cancella un oggetto dato l'id 

public static function deleteObject($id){
    $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
    if($result) return true;
    else return false;

  }

  public static function isSub($userId, $podcastId) {

    $sub = FDataBase::getInstance()->loadMoreAttributesObjects(self::getTable(), 'subscriber_id', $userId, FPodcast::getKey(), $podcastId);

    return !empty($sub);
}

public static function retrieveSub($userId, $podcastId){
    $sub = FDataBase::getInstance()->loadMoreAttributesObjects(self::getTable(), 'subscriber_id', $userId, FPodcast::getKey(), $podcastId);
    $Esub = FSubscribe::createEntity($sub);
    if ($Esub){
        return $Esub;
    }else{
        return null;
    }
}



}


