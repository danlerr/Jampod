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
public static function createEntity($queryResult){
    if(count($queryResult) == 1){
        $vote = new EVote($queryResult[0]['value'], $queryResult[0]['user_id'],$queryResult[0]['episode_id']);
        $vote->setVoteId($queryResult[0]['vote_id']);
        return $vote;
    }elseif(count($queryResult) > 0){
        $votes = array();
        for($i = 0; $i < count($queryResult); $i++){
            $vote = new EVote($queryResult[$i]['value'],$queryResult[$i]['user_id'],$queryResult[$i]['episode_id']);
            $vote->setVoteId($queryResult[$i]['vote_id']);        
            $episodes[] = $vote; //aggiunge l'oggetto voto nell'array di voti
        }
        return $episodes;
    }else{
        return array();
    }
}
public static function bind($stmt, Evote $vote){
    $stmt->bindValue(":value", $vote->getValue(), PDO::PARAM_INT);
    $stmt->bindValue(":user_id", $vote->getUserId(), PDO::PARAM_INT);
    $stmt->bindValue(":episode_id", $vote->getEpisodeId(), PDO::PARAM_INT);
    $stmt->bindValue(":vote_id", $vote->getVoteId(), PDO::PARAM_INT);
  
}
//metodo per "salvare" un oggetto episodio dal DB. Ritorna l'id identificativo dell'episodio
public static function createObject($obj){ 
    $ObjectVote_id = FDataBase::getInstance()->create(self::getClass(), $obj);
    if( $ObjectVote_id !== null){
        $obj->setVoteId($ObjectVote_id);
        return true;
    }else{
        return false;
    }
}
//metodo per "recuperare" un oggetto episodio dal DB (conversione in entity) utilizzando l'id
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
//serve transaction??
public static function deleteObject($field, $id){
    $result = FDatabase::getInstance()->delete(self::getClass(), $field, $id);
    if($result) return true;
      else return false;

  }



}
