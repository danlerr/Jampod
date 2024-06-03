<?php

class FComment{
    
    private static $table="comment";
    private static $value="(:comment_id,:comment_text,:comment_creation_date,:user_id,:episode_id)";
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
    //
    public static function createEntity($queryResult){
        if(count($queryResult) == 1){
            $comment = new EComment($queryResult[0]['comment_text'], $queryResult[0]['user_id'], $queryResult[0]['episode_id']);
            $comment->setCommentId($queryResult[0]['idComment']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_date']);
            $comment->setCommentCreationTime($dateTime);
            //$comment->setBan($queryResult[0]['removed']);   da inserire!
            return $comment;
        }elseif(count($queryResult) > 1){
            $comments = array();
            for($i = 0; $i < count($queryResult); $i++){
                $comment = new EComment($queryResult[$i]['comment_text'], $queryResult[$i]['user_id'], $queryResult[$i]['episode_id']);
                $comment->setCommentId($queryResult[$i]['idComment']);
                $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_date']);
                $comment->setCommentCreationTime($dateTime);
                //$comment->setBan($queryResult[$i]['removed']); da inserire!
                $comments[] = $comment;
            }
            return $comments;
            }else{
            return array();
        }

    }
    public static function bind($stmt, $comment){
        $stmt->bindValue("comment_text:", $comment->getCommentText(), PDO::PARAM_STR);
        $stmt->bindValue(":creation_date", $comment->getCommentTime(), PDO::PARAM_STR);
        //$stmt->bindValue(":removed", $comment->isBanned(), PDO::PARAM_BOOL); da inserire!
        $stmt->bindValue(":episode_id", $comment->getEpisodeId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $comment->getUserId(), PDO::PARAM_STR); // controlla i tipi 
    }
//forse ci voleva FUser

//R getCommentEntity
    public static function retrieveObject($id){
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $id);  //cambiare retrive in retrieve in FDataBase
        if(count($result) > 0){
            $comment = self::createCommentEntity($result);
            return $comment;
        }else{
            return null;
        }
    }
//C
// function crea oggetto nel db
public static function createObject($obj, $fieldArray = null){    //cos'è field array?

    if($fieldArray === null){
        $saveComment = FDataBase::getInstance()->create(self::getClass(), $obj);
        if($saveComment !== null){
            return true;
        }else{
            return false;
        }
    }else{
        try{
            FDataBase::getInstance()->getDb()->beginTransaction();  
            foreach($fieldArray as $fv){
                FDataBase::getInstance()->update(FComment::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
            }
            FDataBase::getInstance()->getDb()->commit();
            return true;

        }catch(PDOException $e){
            echo "ERROR " . $e->getMessage();
            FDataBAse::getInstance()->getDb()->rollBack(); //rollBack collegata a beginTransaction
            return false;
        }finally{
            FDataBase::getInstance()->closeConnection();
        }
    }
    
    }
    //D
    public static function deleteObject($comment_id, user_id){        
        try{
            FDataBase::getInstance()->getDb()->beginTransaction();
            $queryResult = FDataBase::getInstance()->retrive(self::getTable(), self::getKey(), $comment_id);

            if(FDataBase::getInstance()->existInDb($queryResult) && FDatabase::getInstance()->checkCreator($queryResult, $idUser)){ //fare check CReator in FDataBase
                //mi servono solo gli id della query //??
            
                FDataBase::getInstance()->delete(self::getTable(), self::getKey(), $comment_id);

                FDataBase::getInstance()->getDb()->commit();
                return true;
            }else{
                FDataBase::getInstance()->getDb()->commit();
                return false;
            }
        }catch(PDOException $e){
            echo "ERROR " . $e->getMessage();
            FDataBase::getInstance()->getDb()->rollBack();
            return false;
        }finally{
            FDataBase::getInstance()->closeConnection();
        }
    }

    }