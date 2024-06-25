<?php

class FDonation{
    
    private static $table="donation";
    private static $value="(NULL,:donation_description,:sender_id,:recipient_id,:amount,:donation_date)";
    private static $key="donation_id";

    
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


    public static function createObject($obj) :bool{            //metodo per "salvare" un oggetto donation nel DB

        $ObjectCardId = FDataBase::getInstance()->create(self::class, $obj);
        if($ObjectCardId !== null){
            $obj->setDonationId($ObjectCardId);
            return true;
        }else{
            return false;
        }
    }

    
    
    public static function bind($stmt, $donation){
        $stmt->bindValue(":donation_id", $donation->getDonationId(), PDO::PARAM_INT);
        $stmt->bindValue(":donation_description", $donation->getDonationText(), PDO::PARAM_STR);
        $stmt->bindValue(":sender_id", $donation->getDonationSenderId(), PDO::PARAM_STR);
        $stmt->bindValue(":recipient_id", $donation->getDonationRecipientId(), PDO::PARAM_STR); 
        $stmt->bindValue(":amount", $donation->getDonationAmount(), PDO::PARAM_INT); 
        $stmt->bindValue(":donation_date", $donation->getDonationTime(), PDO::PARAM_STR); 
    }


    //R getCommentEntity
    public static function retrieveObject($id){                 //metodo per recuperare un oggetto donation dal DB
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $id); 
        if(count($result) > 0){
            $donation = self::createEntity($result);
            return $donation;
        }else{
            return null;
        }
    }

    //non possiamo eliminare una donazione

    public static function createEntity($queryResult){          //metodo che crea un nuovo oggetto della classe EDonation
       
        $donation = new EDonation($queryResult[0]['amount'], $queryResult[0]['donation_description'], $queryResult[0]['sender_id'],$queryResult[0]['recipient_id']);
        $donation->setDonationId($queryResult[0]['donation_id']);
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['donation_date']);
        $donation->setDonationCreationTime($dateTime);

        return $donation;
    
    }

}

