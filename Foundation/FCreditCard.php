<?php

class FCreditCard{
    
    private static $table="credit_card";
    private static $value="(:card_id,:card_holder,:card_number,:security_code,:expiration_date,:user_id)";
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
    // crea entity a partire dalla query
    public static function createEntity($queryResult){
        if(count($queryResult) == 1){
            $credit_card = new ECreditCard($queryResult[0]['card_holder'], $queryResult[0]['card_number'], $queryResult[0]['security_code'],$queryResult[0]['expiration_date']);
            $credit_card->setCreditCardId($queryResult[0]['card_id']);
            return $credit_card;
        }elseif(count($queryResult) > 1){
            $credit_cards = array();
            for($i = 0; $i < count($queryResult); $i++){
                $credit_card = new ECreditCard($queryResult[$i]['card_holder'], $queryResult[$i]['card_number'], $queryResult[$i]['security_code'],$queryResult[$i]['expiration_date']);
                $credit_card->setCreditCardId($queryResult[$i]['card_id']);
                $credit_cards[]=$credit_card;
            }
            return $credit_cards;
        }else{
            return array();
        }
    }

    public static function bind($stmt, $creditCard){
        $stmt->bindValue("card_id:", $creditCard->getCardId(), PDO::PARAM_INT);
        $stmt->bindValue(":card_holder", $creditCard->getCreditCardHolder(), PDO::PARAM_STR);
        $stmt->bindValue(":card_number", $creditCard->getCreditCardNumber(), PDO::PARAM_STR);
        $stmt->bindValue(":security_code", $creditCard->getCreditCardSecurityCode(), PDO::PARAM_STR); 
        $stmt->bindValue(":expiration_date", $creditCard->getCreditCardExpirationDate(), PDO::PARAM_STR); 
        $stmt->bindValue(":user_id", $creditCard->getUserId(), PDO::PARAM_INT); 

    }


    // function update oggetto nel db// crea
    public static function createObject($obj, $fieldArray = null){   

        if($fieldArray === null){
            $saveCredit_card = FDataBase::getInstance()->create(self::getClass(), $obj);
            if($saveCredit_card !== null){
                return true;
            }else{
                return false;
            }
        }else{
            try{
                foreach($fieldArray as $fv){
                    FDataBase::getInstance()->update(FCreditCard::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                }
                FDataBase::getInstance()->getDb()->commit();
                return true;

            }catch(PDOException $e){
                echo "ERROR " . $e->getMessage();
                return false;
            }finally{
                FDataBase::getInstance()->closeConnection();
            }
        }
        
        }

    //R getCommentEntity
    public static function retrieveObject($id){
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $id); 
        if(count($result) > 0){
            $credit_card = self::createEntity($result);
            return $credit_card;
        }else{
            return null;
        }
    }

    public static function deleteObject($card_id,$user_id){        
        try{
            $queryResult = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $card_id);

            if(FDataBase::getInstance()->existInDb($queryResult) && FDatabase::getInstance()->checkCreator($queryResult, $user_id)){ //fare check CReator e existInDb in FDataBase
                //mi servono solo gli id della query //??
            
                FDataBase::getInstance()->delete(self::getTable(), self::getKey(), $card_id);

                FDataBase::getInstance()->getDb()->commit();
                return true;
            }else{
                FDataBase::getInstance()->getDb()->commit();
                return false;
            }
        }catch(PDOException $e){
            echo "ERROR " . $e->getMessage();
            return false;
        }finally{
            FDataBase::getInstance()->closeConnection();
        }
    }




}
