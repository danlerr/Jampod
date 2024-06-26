<?php
    
    require_once('config/config.php');

    class FDataBase{

        private static $instance;

        private static $db;

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

        //----------------------------------CRUD------------------------------------------

        //C
        public static function create($fClass, $obj){
            try {
            // Inizia la transazione
            self::$db->beginTransaction();

            //  query di inserimento
            $table = $fClass::getTable();
            $values = $fClass::getValue();
            $query = "INSERT INTO " . $table . " VALUES " . $values;
            $stmt = self::$db->prepare($query);
            $fClass::bind($stmt, $obj);
            $stmt->execute();
            // Ottieni l'ultimo ID inserito
            $id = self::$db->lastInsertId();
            // Commit della transazione
            self::$db->commit();
            return $id;
        } catch (PDOException $e) {
            // Log dell'errore
            error_log("Save Objects Error (PDO): " . $e->getMessage());

            
            self::$db->rollBack();

            return null;
        } catch (Exception $e) {
            // Log dell'errore generico
            error_log("Save Objects Error: " . $e->getMessage());

            
            self::$db->rollBack();

            return null;
    }
}


        //R
        public static function retrieve ($table, $field, $id)
        {
            try{
                
                $query = "SELECT * FROM $table WHERE $field = :id";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':id',$id);                
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);   

            }catch(PDOException $e){

                error_log("Load Objects Error: " . $e->getMessage());
                return array();
            }
        }

        //U
        public static function update($table, $field, $fieldValue, $cond, $condValue){
        
            try{

                self::$db->beginTransaction();
                $query = "UPDATE " . $table . " SET " . $field . " = :fieldValue  WHERE " . $cond . "= :condValue";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':fieldValue', $fieldValue);
                $stmt->bindParam(':condValue', $condValue);
                $stmt->execute();
                self::$db->commit();
                return true;

            }catch(Exception $e){

                error_log("Update Objects Error: " . $e->getMessage());
                self::$db->rollBack();
                return false;
            }
        }

        //D
        public static function delete($table, $field, $id){
            try{
                self::$db->beginTransaction();
                $query = "DELETE FROM " . $table . " WHERE " . $field . " = :id";
                $stmt = self::$db->prepare($query);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                self::$db->commit();
                return true;

            }catch(Exception $e){
                
                error_log("Delete Objects Error: " . $e->getMessage());
                self::$db->rollBack();
                return false;
            }
        }

        //--------------------------------------------------------------------------------

        public static function closeConnection(){

            static::$instance = null;
        }

        public static function getDb(){
            return self::$db;
        }

        public static function loadMoreAttributesObjects ($table, $field1, $id1, $field2, $id2)
        {
            try{
                $query = "SELECT * FROM " . $table . " WHERE " . $field1 . " =:$id1" . " AND " . $field2 . " =:$id2 ";
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


        public static function existInDb($queryResult){ //return true if there are results, otherwise false 
            if(is_array($queryResult)||is_object($queryResult)){        //$query result può essere sia un array che un oggetto creato dal create entity dopo un retrieve
                return count((array)$queryResult) > 0;        //casting
            }else{
                return false;
            }
        }
    }       