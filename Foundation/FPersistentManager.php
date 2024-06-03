<?php
    
    class FPersistentManager{

        private static $instance;

        private function __construct(){

        }

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        //----------------------------------CRUD------------------------------------------

        public static function createObj($obj){
            $fclass = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$fclass, "createObject"], $obj);
            return $result;
        }

        public static function retrieveObj($eclass, $id){

            $fclass = "F" . substr($eclass, 1);

            $result = call_user_func([$fclass,"retrieveObject"], $id);

            return $result;
        }

        public function updateObj($obj){
            $class = "F" . substr(get_class($obj),1);
            $result = call_user_func([$class, "updateObject"], $obj);
            return $result;
        }
        public function deleteObj($obj){
            $class = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$class, "deleteObject"], $obj);
            return $result;
        }

        //--------------------------------------------------------------------------------

    }

        