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

        //C
        public static function createObj($obj){
            $fclass = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$fclass, "createObject"], $obj);
            return $result;
        }

        //R
        public static function retrieveObj($eclass, $id){

            $fclass = "F" . substr($eclass, 1);                               
            $result = call_user_func([$fclass,"retrieveObject"], $id);
            return $result;
        }

        //U
        public function updateObj($obj, $field, $value){
            $class = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$class, "updateObject"], $obj, $field, $value);         
            return $result;
        }

        //D
        public function deleteObj($obj){
            $class = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$class, "deleteObject"], $obj->getId());
            return $result;
        }

     
        //----------------------------------------------VERIFY-----------------------------------------------------


        /**
         * verify if exist a user with this username (also mod)
         * @param string $username
         */
        public static function verifyUserUsername($username){
            $result = FUser::verify('username', $username);

            return $result;
        }
                /**
             * verify if exist a user with this email (also mod)
             * @param string $email
             */
            public static function verifyUserEmail($email){
                $result = FUser::verify('email', $email);

                return $result;
            }

        //--------------------------------------------------------------------------------

            /**
         * return a User findig it not on the id but on it's username
         * @param string $username Refers to the username of the user to get
         */
        public static function retriveUserOnUsername($username)
        {
            $result = FUser::getUserByUsername($username);

            return $result;
        }


            

        }

            
