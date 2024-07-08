<?php

class FCreditCard{
    
    private static $table="credit_card";
    private static $value="(:card_id,:card_number,:card_holder,:security_code,:expiration_date,:user_id)";
    private static $key="card_id";

    
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
    

    public static function createObject($obj) :bool{            //metodo per "salvare" un oggetto CreditCard nel DB

        $ObjectCreditCardId = FDataBase::getInstance()->create(self::class, $obj);
        if($ObjectCreditCardId !== null){
            $obj->setCreditCardId($ObjectCreditCardId);
            return true;
        }else{
            return false;
        }
    }

    public static function bind($stmt, $creditCard){
        $stmt->bindValue(':card_id', null, PDO::PARAM_NULL); 
        $stmt->bindValue(":card_number", $creditCard->getCreditCardNumber(), PDO::PARAM_STR);         
        $stmt->bindValue(":card_holder", $creditCard->getCreditCardHolder(), PDO::PARAM_STR);
        $stmt->bindValue(":security_code", $creditCard->getCreditCardSecurityCode(),PDO::PARAM_STR); 
        $stmt->bindValue(":expiration_date", $creditCard->getCreditCardExpirationDate()->format('Y/m'), PDO::PARAM_STR);
        $stmt->bindValue(":user_id", $creditCard->getCreditCardUserId(), PDO::PARAM_INT); 

    }


    public static function retrieveObject($card_id) :?ECreditcard{      //metodo per recuperare un oggetto creditCard dal DB
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $card_id);
        if(count($result) > 0){
            $obj = self::createEntity($result);
            return $obj;
        }else{
            return null;
        }
    }


    public static function updateObject($obj, $field, $fieldValue){            //metodo per aggiornare un oggetto creditCard nel DB

        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue,self::getKey(),$obj->getId());
        if($result){
            return true;
        }else{
         return false;
        }
    }


    public static function deleteObject($card_id){                      //metodo per eliminare un oggetto creditCard dal DB
        $queryResult = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $card_id);
        $card=self::retrieveObject($card_id);

        if($card !== null && FUser::userValidation($queryResult, $card->getCreditCardUserId())){ 
        
            FDataBase::getInstance()->delete(self::getTable(), self::getKey(), $card_id);
            return true;
        }else{
            return false;
        }
    }
    public static function createEntity($queryResult) {
        if (!empty($queryResult) && isset($queryResult[0])) {
            $creditCard = new ECreditcard(
                $queryResult[0]['card_holder'],
                $queryResult[0]['card_number'],
                $queryResult[0]['security_code'],
                $queryResult[0]['expiration_date'],
                $queryResult[0]['user_id']
            );
            $creditCard->setCreditCardId($queryResult[0]['card_id']);
            return $creditCard;
        } else {
            return null;
        }
    }
    

    
    public static function retrieveOwnedCreditCards($userId){
        $creditCards=FDataBase::getInstance()->retrieve(self::getTable(),'user_id',$userId);
            return $creditCards;
        }

    }








