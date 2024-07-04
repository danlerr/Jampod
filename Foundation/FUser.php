<?php

    class FUser{

    private static $table = "user";

    private static $value = "(:user_id,:username,:email,:password,:balance,:is_admin,:ban)";

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

    public static function retrieveObject($user_id){      //metodo per recuperare un oggetto user dal DB
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $user_id);
        if(count($result) > 0){
            $obj = self::createEntity($result);
            return $obj;
        }else{
            return null;
        }
    }

    public static function updateObject($obj, $field, $fieldValue){            //metodo per aggiornare un oggetto user dal DB

        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, self::getKey(), $obj->getId());
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

    public static function createEntity($queryResult) {
        $users = array();
    
        foreach ($queryResult as $result) {
            $user = new EUser(

                $result['email'],
                $result['password'],
                $result['username']);
            

            $user->setUserId($result['user_id']);
            
            $user->setHashedPassword($result['password']);
            $user->setBalance($result['balance']);
            $user->setBan($result['ban']);
            $user->setAdmin($result['is_admin']);
            $users[] = $user;
        }
    
        // Restituisce un singolo oggetto utente se c'è un solo elemento nell'array
        if (count($users) === 1) {
            return $users[0];
        }
    
        // Restituisce un array di utenti se ci sono più elementi nell'array
        return $users;
    }

    public static function bind($stmt, EUser $user){  
        $stmt->bindValue(':user_id', null, PDO::PARAM_NULL);                           //bind function 
        $stmt->bindValue(':username',$user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(':email',$user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':password',$user->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(':balance',$user->getBalance(), PDO::PARAM_STR);
        $stmt->bindValue(':is_admin',$user->isAdmin(), PDO::PARAM_BOOL);
        $stmt->bindValue(':ban',$user->isBanned(), PDO::PARAM_BOOL);

    }

    //--------------------------------------------------------------------------------
    // return bool 
    public static function verify($field, $id){
        $queryResult = FDataBase::retrieve(self::getTable(), $field, $id);

        return FDataBase::getInstance()->existInDb($queryResult);
    }

    //verifica che l'id dell'utente, passato per parametro, sia lo stesso che risulta dalla query di un determinato oggetto di cui è stato fatto il retrieve dal db
    public static function userValidation($queryResult, $idUser){
        if(FDataBase::getInstance()->existInDb($queryResult) && $queryResult[0][FUser::getKey()] == $idUser){
            return true;
        }else{
            return false;
        }
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
    //restituisce lo username dello user di cui è stato passato l'id per parametro
    public static function getUserUsername($user_id) {
        $user = self::retrieveObject($user_id);
        return $user->getUsername();
    }



}