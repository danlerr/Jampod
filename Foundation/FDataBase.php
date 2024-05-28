<?php
    
    require_once('config/config.php');

    class FDataBase{

        private static $instance;

        private  $db;

        private function __construct(){
            try{
                self::$db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST."; charset=utf8;", DB_USER, DB_PASS);
            }catch(PDOException $e){
                error_log("Database Connection Error: " . $e->getMessage());
                die("Database connection error. Check logs for details.");
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

        public function loadObjects ($table, $field, $id)
        {
            try{

                $query = "SELECT * FROM " .$table. " WHERE ".$field." = '".$id."';";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':id',$id);                // !
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);   // !  

            }catch(PDOException $e){

                error_log("Load Objects Error: " . $e->getMessage());
                return array();
            }
        }

        public static function loadMoreAttributesObjects ($table, $field1, $id1, $field2, $id2)
        {
            try{
                $query = "SELECT * FROM " . $table . " WHERE " . $field1 . " = '".$id1. "' AND " . $field2 . " = '". $id2. "';";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':id1', $id1);
                $stmt->bindParam(':id2', $id2);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                
                error_log("Load More Attributes Objects Error: " . $e->getMessage());
                return array();
            }
        }

        public static function queryCheck ($queryResult) :bool
        {
            return count($queryResult) > 0; //return true if there are results, otherwise false 
        }

        public static function updateObject($table, $field, $fieldValue, $cond, $condValue){
        
            try{
                $query = "UPDATE " . $table . " SET ". $field. " = '" . $fieldValue . "' WHERE " . $cond . " = '" . $condValue . "';";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':fieldValue', $fieldValue);
                $stmt->bindParam(':condValue', $condValue);
                $stmt->execute();
                return true;

            }catch(Exception $e){

                error_log("Update Objects Error: " . $e->getMessage());
                return false;
            }
        }

        public static function saveObject($fClass, $obj)
        {
            try{
                $query = "INSERT INTO " . $fClass::getTable() . " VALUES " . $fClass::getValue();
                $stmt = self::$db->prepare($query);
                $fClass::bind($stmt, $obj);
                $stmt->execute();
                $id = self::$db->lastInsertId();
                return $id;

            }catch(Exception $e){

                error_log("Save Objects Error: " . $e->getMessage());
                return null;
            }
        }

        public static function saveObjectFromId($fClass, $obj, $id)
        {
            try{
                $query = "INSERT INTO " . $fClass::getTable() . " VALUES " . $fClass::getValue();
                $stmt = self::$db->prepare($query);
                $fClass::bind($stmt,$obj, $id);
                $stmt->execute(); 
                return true;
            }catch(Exception $e){

                error_log("Save Objects FromId Error: " . $e->getMessage());
                return false;
            }
        }

        public static function deleteObject($table, $field, $id){
            try{
                $query = "DELETE FROM " . $table . " WHERE " . $field . " = '".$id."';";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                return true;

            }catch(Exception $e){
                
                error_log("Delete Objects Error: " . $e->getMessage());
                return false;
            }
        }

    }