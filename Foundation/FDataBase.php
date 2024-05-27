<?php
    
    require_once('config/config.php');

    class FDataBase{

        private static $instance;

        private  $db;

        private function __construct(){
            try{
                self::$db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST."; charset=utf8;", DB_USER, DB_PASS);
            }catch(PDOException $e){
                echo "ERROR". $e->getMessage();
                die;
            }
    
         }

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public static function closeConnection(){

            static::$instance = null;
        }

        public static function getDb(){
            return self::$db;
        }

    }