<?php

class FDonation{
    
    private static $table="donation";
    private static $value="(:donation_id,:donation_description,:sender_id,:recipient_id,:amount,:donation_date)";
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

    public static function createEntity($queryResult){
        if(count($queryResult) == 1){
            $donation = new EDonation($queryResult[0]['amount'],$queryResult[0]['donation_description'], $queryResult[0]['sender_id'],$queryResult[0]['recipient_id'],$queryResult[0]['donation_id']);
            $donation->setDonationId($queryResult[0]['idComment']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['donation_date']);
            $donation->setDonationCreationTime($dateTime);
            return $donation;
        }elseif(count($queryResult) > 1){
            $donations = array();
            for($i = 0; $i < count($queryResult); $i++){
                $donation = new EDonation($queryResult[$i]['amount'],$queryResult[$i]['donation_description'], $queryResult[$i]['sender_id'],$queryResult[$i]['recipient_id'],$queryResult[$i]['donation_id']);
                $donation->setDonationId($queryResult[$i]['donation_id']);
                $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['donation_date']);
                $donation->setDonationCreationTime($dateTime);
                $donations[] = $donation;
            }
            return $donations;
        }else{
            return array();
        }
    }

    
    public static function bind($stmt, $donation){
        $stmt->bindValue(":donation_id:", $donation->getDonationId(), PDO::PARAM_INT);
        $stmt->bindValue(":donation_description", $donation->getDonationText(), PDO::PARAM_STR);
        $stmt->bindValue(":sender_id", $donation->getDonationSenderId(), PDO::PARAM_STR);
        $stmt->bindValue(":recipient_id", $donation->getDonationRecipientId(), PDO::PARAM_STR); 
        $stmt->bindValue(":amount", $donation->getDonationAmount(), PDO::PARAM_INT); 
        $stmt->bindValue(":donation_date", $donation->getDonationTime(), PDO::PARAM_STR); 
    }

    // function update oggetto nel db e crea se fieldArray===null
    public static function createObject($obj, $fieldArray = null){   

        if($fieldArray === null){
            $saveDonation = FDataBase::getInstance()->create(self::getClass(), $obj);
            if($saveDonation !== null){
                return true;
            }else{
                return false;
            }
        }else{
            try{
                foreach($fieldArray as $fv){
                    FDataBase::getInstance()->update(FDonation::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
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
            $donation = self::createEntity($result);
            return $donation;
        }else{
            return null;
        }
    }

    //non possiamo eliminare una donazione



}