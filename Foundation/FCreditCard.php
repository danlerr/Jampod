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


}