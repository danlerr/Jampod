<?php
   
class CUser{


        /**
        * check if the user is logged (using session)
        * @return boolean
        */
        public static function isLogged() {
            $logged = false;
    
            // Verifica se il cookie di sessione PHPSESSID è impostato
            if (UCookie::isSet('PHPSESSID')) {
                // Controlla se la sessione non è ancora avviata
                if (session_status() == PHP_SESSION_NONE) {
                    USession::getInstance(); // Avvia una nuova sessione
                }
            }
    
            // Verifica se l'elemento 'user' è presente nella sessione (utente loggato)
            if (USession::isSetSessionElement('user')) {
                $logged = true;
                self::isBanned(); // Verifica se l'utente è bandito
            }
    
            // Se l'utente non è loggato, reindirizza alla pagina di login attraverso la view
            if (!$logged) {
                $view = new VUser();
                $view->showLoginForm();
                exit; 
            }
    
            return true; // Restituisce true se l'utente è loggato
        }

        /**
         * check if the user is banned
         * @return void
         */
        public static function isBanned()
        {
            $userId = USession::getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId); //ritorna l'oggetto user
            if($user->isBanned()){  
                $view = new VUser();
                USession::unsetSession();
                USession::destroySession();
                $view->showError('Sei bannato! >.<', false);
            }
        }
        
        public static function login(){
            // Verifica se il cookie di sessione PHPSESSID è impostato
            if (UCookie::isSet('PHPSESSID')) {
                // Controlla se la sessione non è ancora avviata
                if (session_status() == PHP_SESSION_NONE) {
                    USession::getInstance(); // Avvia una nuova sessione
                }
            }
            
            // Verifica se l'elemento 'user' è presente nella sessione (utente loggato)
            if (USession::isSetSessionElement('user')) {
                CHome::homePage();// Se l'utente è già loggato, reindirizza alla pagina di home
                exit; // Assicurati di terminare lo script dopo il reindirizzamento
            }
            
            // Se l'utente non è autenticato, mostra il modulo di login
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
            //verifica che lo username e l'email non esistano nel db
            if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
                    $user = new EUser(UHTTPMethods::post('email'),UHTTPMethods::post('password'),UHTTPMethods::post('username')); //nuovo oggetto entity user
                    FPersistentManager::getInstance()->createObj($user); //salvataggio dell'utente nel db

                    $view->showLoginForm(); //mostra il form di login 
            }else{
                    $view->showError('Errore durante la registrazione', false);
                }
        }

        /**
         * check if exist the Username inserted, and for this username check the password. If is everything correct the session is created and
         * the User is redirected in the homepage
         */
        public static function checkLogin(){
            $view = new VUser();
            $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));    //verifica esistenza username nel db                                         
            if($username){
                $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username')); //ritorna l'oggetto user 
                if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                    if($user->isBanned()){
                        $view->showError('Sei bannato!', false);

                    }elseif(USession::getSessionStatus() == PHP_SESSION_NONE){
                        USession::getInstance(); //session start
                        USession::setSessionElement('user', $user->getId()); //l'id dell'utente viene posto nell'array $_SESSION
                        CHome::homePage();
                    }
                }else{
                    $view->showError('Errore durante la registrazione', false);
                }
            }else{
                $view->showError('Errore durante la registrazione', false);
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
            $view = new VUser();
            $view->showLoginForm();
        }

        public static function user_profile($userId) { 
            if (CUser::isLogged()){
                $view = new VUser;
                $podcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                $view->profile($podcasts);
            }
        }

        public static function settings() {
            if (CUser::isLogged()){
                $view = new VUser();
                $userId = USession::getInstance()->getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $username = $user->getUsername();
                $email = $user->getEmail();
                $pass = $user->getPassword();
                $view->settings($username, $email, $pass);
            }
        }
    }