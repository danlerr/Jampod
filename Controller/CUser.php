<?php
   
class CUser{

    /**
        * check if the user is logged (using session)
        * @return boolean
        */
    public static function isLogged()
    {
        $logged = false;

        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance(); //avvia una nuova sessione
            }
        }
        if(USession::isSetSessionElement('user')){
            $logged = true;
            self::isBanned();
        } 
        //reindirrizzamento alla pagina di login se non connesso
        if(!$logged){
            header('Location: /Jampod/login'); //!!!! 
            exit;
        }
        return true;
    }

        /**
         * check if the user is banned
         * @return void
         */
        public static function isBanned()
        {
            $userId = USession::getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId); //!!
            if($user->isBanned()){  
                $view = new VUser();
                USession::unsetSession();
                USession::destroySession();
                $view->loginBan();
            }
        }

        public static function login(){
            if(UCookie::isSet('PHPSESSID')){
                if(session_status() == PHP_SESSION_NONE){
                    USession::getInstance();
                }
            }
            if(USession::isSetSessionElement('user')){ //se utente loggato
                header('Location: /Jampod/home'); //!!! se nella sessione esiste user vai sulla home
            }
            //se l'utente non è autenticato
            $view = new VUser();
            $view->showLoginForm();
        }

        
            /**
         * verify if the choosen username and email already exist, create the User Obj and set a default profile image 
         * @return void
         */
        public static function registration()
        {
            $view = new VUser();
            if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
                    $user = new EUser(UHTTPMethods::post('name'), UHTTPMethods::post('surname'),UHTTPMethods::post('email'),UHTTPMethods::post('password'),UHTTPMethods::post('username'));
                    $user->setIdImage(1);
                    FPersistentManager::getInstance()->createObj($user);

                    $view->showLoginForm();
            }else{
                    $view->registrationError();
                }
        }

            /**
         * check if exist the Username inserted, and for this username check the password. If is everything correct the session is created and
         * the User is redirected in the homepage
         */
        public static function checkLogin(){
            $view = new VUser();
            $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));                                            
            if($username){
                $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
                if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                    if($user->isBanned()){
                        $view->loginBan();

                    }elseif(USession::getSessionStatus() == PHP_SESSION_NONE){
                        USession::getInstance();
                        USession::setSessionElement('user', $user->getUserId());
                        header('Location: /Jampod/home');   //!!  se la pagina iniziale 'Jampod' è il form di login lascia /Jampod/home
                    }
                }else{
                    $view->loginError();
                }
            }else{
                $view->loginError();
            }
        }

            /**
         * this method can logout the User, unsetting all the session element and destroing the session. Return the user to the Login Page
         * @return void
         */
        public static function logout(){
            USession::getInstance();
            USession::unsetSession();
            USession::destroySession();
            header('Location: /Jampod');
        }

    


    }