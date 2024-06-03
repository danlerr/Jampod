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
public static function createEntity($queryResult){
    if(count($queryResult) == 1){
        $subscribe = new ESubscribe($queryResult[0]['podcast_id'], $queryResult[0]['subscriber_id']);
        $subscribe->setSubscribeid($queryResult[0]['subscribe_id']);
        return $subscribe;
    }elseif(count($queryResult) > 0){
        $subscribes = array();
        for($i = 0; $i < count($queryResult); $i++){
            $subscribe = new ESubscribe($queryResult[0]['podcast_id'], $queryResult[0]['subscriber_id']);
            $subscribe->setSubscribeid($queryResult[0]['subscribe_id']); 
            $subcribes[] = $subscribe; //aggiunge l'oggetto voto nell'array di voti
        }
        return $subscribes;
    }else{
        return array();
    }
}
public static function bind($stmt, ESubscribe $subscribe){
    $stmt->bindValue(":value", $subscribe->getPodcastid(), PDO::PARAM_INT);
    $stmt->bindValue(":user_id", $subscribe->getSubscribeid(), PDO::PARAM_INT);
    $stmt->bindValue(":episode_id", $subscribe->getSubscriberid(), PDO::PARAM_INT);
   
  
}
//metodo per "salvare" un oggetto episodio dal DB. Ritorna l'id identificativo dell'episodio
public static function createObject($obj){ 
    $ObjectSubscribe_id = FDataBase::getInstance()->create(self::getClass(), $obj); //restituisce l'id assegnato dal db all'oggetto subscribe
    if( $ObjectSubscribe_id !== null){
        $obj->setSubscribeid($ObjectSubscribe_id);
        return true;
    }else{
        return false;
    }
}
//metodo per "recuperare" un oggetto episodio dal DB (conversione in entity) utilizzando l'id
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
//aggiungere transactions
public static function deleteObject($field, $id){
    $result = FDatabase::getInstance()->delete(self::getClass(), $field, $id);
    if($result) return true;
    else return false;

  }



}


