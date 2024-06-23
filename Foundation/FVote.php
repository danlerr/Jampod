<?php
class FVote{


private static $table = "vote";

private static $value = "(:vote_id, :value, :user_id, :episode_id)";

private static $key = "vote_id";

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
    $votes = array();

    foreach ($queryResult as $result) {
        $vote = new EVote($result['value'], $result['user_id'], $result['episode_id']);
        $vote->setVoteId($result['vote_id']);
        $votes[] = $vote;
    }

    // Restituisce un singolo oggetto se c'è un solo elemento
    if (count($votes) === 1) {
        return $votes[0];
    }

    // Restituisce un array di oggetti se ci sono più elementi
    return $votes;
}

public static function bind($stmt, Evote $vote){
    $stmt->bindValue(":value", $vote->getValue(), PDO::PARAM_INT);
    $stmt->bindValue(":user_id", $vote->getUserId(), PDO::PARAM_INT);
    $stmt->bindValue(":episode_id", $vote->getEpisodeId(), PDO::PARAM_INT);
    $stmt->bindValue(":vote_id", $vote->getVoteId(), PDO::PARAM_INT);
  
}
//metodo per "salvare" un oggetto voto dal DB. Ritorna l'id identificativo del voto
public static function createObject(EVote $obj){ 
    $ObjectVote_id = FDataBase::getInstance()->create(self::getClass(), $obj);
    if( $ObjectVote_id !== null){
        $obj->setVoteId($ObjectVote_id);
        return true;
    }else{
        return false;
    }
}
//metodo per "recuperare" un oggetto voto dal DB (conversione in entity) utilizzando l'id
public static function retrieveObject($vote_id){ 
    $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $vote_id); 
    if(count($result) > 0){
        $vote = self::createEntity($result);
        return $vote;
    }else{
        return null;
    }
}
//metodo che cancella un oggetto dato l'id 

public static function deleteObject($field, $id){
    $result = FDatabase::getInstance()->delete(self::getClass(), $field, $id);
    if($result) return true;
      else return false;

  }
  public static function updateObject( $field, $fieldValue, $cond, $condValue){
    $updateVote = FDataBase::getInstance()->update(self::getTable() , $field, $fieldValue, $cond, $condValue);
    if($updateVote !== null){
        return true;
    }else{
        return false;
    }
}



}
