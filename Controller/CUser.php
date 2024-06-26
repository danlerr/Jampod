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
    
            // Se l'utente non è loggato, reindirizza alla pagina di login attraverso la view989
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
                $view->loginBan();
            }
        }
        /*
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
                // Se l'utente è già loggato, reindirizza alla pagina di home
                //header('Location: /Jampod/home'); // Reindirizzamento alla view della home!!
                exit; // Assicurati di terminare lo script dopo il reindirizzamento
            }
            
            // Se l'utente non è autenticato, mostra il modulo di login
            $view = new VUser();
            $view->showLoginForm();
        }
        */
        
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
                    $view->registrationError();
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
                        $view->loginBan();

                    }elseif(USession::getSessionStatus() == PHP_SESSION_NONE){
                        USession::getInstance(); //session start
                        USession::setSessionElement('user', $user->getId()); //l'id dell'utente viene posto nell'array $_SESSION
                        //header('Location: /Jampod/home'); RICHIAMO DELLA VIEW PER IL REDIRECT ALLA HOME!!!!!!!
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
            $view = new VUser();
            $view->showLoginForm();
            //header('Location: /Jampod'); REDIRECT NELLA SCHERMATA DI LOGIN
        }

        public static function home() {

        }
        public static function mypodcasts(){

        }
        /*???????????
        public static function user_profile() {

        }
        */
        public static function settings() {

        }
        public static function mybalance() {

        }
        /** DA VEDERE
     * load all the post finded by a specifyc category
     * @param String $category Refers to a name of a category
     */
    public static function category($category)
    {
        if(CUser::isLogged()){
            $view = new VUser();
        
            $userId = USession::getInstance()->getSessionElement('user');
            $userAndPropic = FPersistentManager::getInstance()->loadUsersAndImage($userId);

            //load the VIP Users, their profile Images and the foillower number
            $arrayVipUserPropicFollowNumb = FPersistentManager::getInstance()->loadVip();

            $postCategory = FPersistentManager::getInstance()->loadPostPerCategory($category);

            $view->category($userAndPropic, $postCategory, $arrayVipUserPropicFollowNumb);
        }
    }

    }