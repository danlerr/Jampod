<?php

class FComment{
    
    private static $table="comment";
    private static $value="(NULL,:comment_text,:comment_creation_date,:user_id,:episode_id,:parent_comment_id,:commentUsername)";
    private static $key="comment_id";

    
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
    


    public static function bind($stmt, $comment){
        $stmt->bindValue(":comment_text", $comment->getCommentText(), PDO::PARAM_STR);
        $stmt->bindValue(":comment_creation_date", $comment->getCommentTime()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        //$stmt->bindValue(":removed", $comment->isBanned(), PDO::PARAM_BOOL); da inserire!
        $stmt->bindValue(":episode_id", $comment->getEpisodeId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $comment->getUserId(), PDO::PARAM_INT); 
        $stmt->bindValue(":parent_comment_id", $comment->getParentCommentId(), PDO::PARAM_INT);
        $stmt->bindValue(":commentUsername", FUser::getUserUsername($comment->getUserId()), PDO::PARAM_STR); 
    }


    public static function createObject($obj) :bool{            //metodo per "salvare" un oggetto comment dal DB

        $ObjectCommentId = FDataBase::getInstance()->create(self::class, $obj);  //il metodo create restituisce l'd del commento
        if($ObjectCommentId !== null){
            $obj->setCommentId($ObjectCommentId);
            return true;
        }else{
            return false;
        }
    }

    
    public static function retrieveObject($id){                //metodo per recuperare un oggetto dal DB, ritorna un oggetto della classe EComment
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $id); 
        if(count($result) > 0){
            $comment = self::createEntity($result);
            return $comment;
        }else{
            return null;
        }
    }

    public static function updateObject($obj, $field, $fieldValue){            //metodo per aggiornare un oggetto user dal DB

        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, self::getKey(),$obj->getId());
        if($result){
            return true;
        }else{
         return false;
        }
    }
    

    public static function deleteObject($id){                //metodo per eliminare un oggetto comment dal DB
        
        $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
        if($result){
            return true;
        }else{
         return false;
        }
    }

    //
    public static function createEntity($queryResult) {
        $comments = array();
    
        foreach ($queryResult as $result) {
            $comment = new EComment($result['comment_text'], $result['user_id'], $result['episode_id']);
            $comment->setCommentId($result['comment_id']);
            $comment->setcommentUsername($result['commentUsername']);
            
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['comment_creation_date']);
            $comment->setCommentCreationTime($dateTime);
            
            if (!is_null($result['parent_comment_id'])) {
                $comment->setParentCommentId($result['parent_comment_id']);
            }
            
            // Aggiungere eventuali altri campi come setBan() 
            // $comment->setBan($result['removed']);
    
            $comments[] = $comment;
        }
    
        // Restituisce un singolo oggetto commento se c'è un solo elemento nell'array
        if (count($comments) === 1) {
            return $comments[0];
        }
    
        // Restituisce un array di commenti se ci sono più elementi nell'array
        return $comments;
    }

    
    //metodo che permette di prendere dal db tutti i commenti dato un episodio. Ritorna un array di commenti
    public static function retrieveMoreComments($episode_id) {
        $result = FDataBase::getInstance()->retrieve(self::getTable(), FEpisode::getKey(), $episode_id); 
        if(count($result) > 0){
            $comments = self::createEntity($result);
            return $comments;
        }else{
            return null;
        }
    }  
   

    }
