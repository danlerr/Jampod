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
