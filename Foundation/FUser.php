<?php

    class FUser{

    private static $table = "user";

    private static $value = "(:user_id,:username,:name,:surname,:email,:password,:balance,:is_admin)";

    private static $key = "user_id";

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

    public static function createObject($obj) :bool{            //metodo per "salvare" un oggetto user dal DB

        $ObjectUserId = FDataBase::getInstance()->create(self::class, $obj);
        if($ObjectUserId !== null){
            $obj->setUserId($ObjectUserId);
            return true;
        }else{
            return false;
        }
    }

    public static function retrieveObject($user_id) :?EUser{      //metodo per recuperare un oggetto user dal DB
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $user_id);
        if(count($result) > 0){
            $obj = self::createEntity($result);
            return $obj;
        }else{
            return null;
        }
    }

    public static function updateObject($field, $fieldValue, $cond, $condValu){            //metodo per aggiornare un oggetto user dal DB

        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, $cond, $condValu);
        if($result){
            return true;
        }else{
         return false;
        }
    }

    public static function deleteObject($id){                //metodo per eliminare un oggetto user dal DB
        
        $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
        if($result){
            return true;
        }else{
         return false;
        }
    }

    public static function createEntity($result){         //metodo che crea un nuovo oggetto della classe EUser
        $obj = new EUser(
            $result[0]['name'],
            $result[0]['surname'],
            $result[0]['email'],
            $result[0]['password'],
            $result[0]['username']);
        //$obj->setHash
        $obj->setUserId($result[0]['user_id']);
        return $obj;
    }

    public static function bind($stmt, EUser $user){                              //bind function 
        $stmt->bindValue(':name',$user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(':surname',$user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(':username',$user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email',$user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password',$user->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':balance',$user->getBalance(), PDO::PARAM_STR);
        $stmt->bindValue(':isAdmin',$user->isAdmin(), PDO::PARAM_BOOL);
    }

    //--------------------------------------------------------------------------------
    // return bool 
    public static function verify($field, $id){
        $queryResult = FDataBase::retrieve(self::getTable(), $field, $id);

        return FDataBase::getInstance()->existInDb($queryResult);
    }
    
    public static function getUserByUsername($username)
    {
        $result = FDataBase::getInstance()->retrieve(FUser::getTable(), 'username', $username);

        if(count($result) > 0){
            $user = self::createEntity($result);
            return $user;
        }else{
            return null;
        }
    }



}