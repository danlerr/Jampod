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
        
        public static function loginForm(){
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
                    $result = FPersistentManager::getInstance()->createObj($user); //salvataggio dell'utente nel db
                if ($result) {

                    $view->showLoginForm(); //mostra il form di login 
                }
            }else{
                    $view->showError('Errore durante la registrazione', false);
                }
        }

        public static function registrationForm(){
            $view = new VUser;
            $view->showRegistrationForm();
        }

        /**
         * check if exist the Username inserted, and for this username check the password. If is everything correct the session is created and
         * the User is redirected in the homepage
         */
        public static function login() {
            $view = new VUser();
            $username = trim(UHTTPMethods::post('username'));
            $password = trim(UHTTPMethods::post('password'));
            if (!$username || !$password) {
                $view->showError('Username e password sono obbligatori', false);
                return;
            }
        
            $usernameExists = FPersistentManager::getInstance()->verifyUserUsername($username);
        
            if ($usernameExists) {
                $user = FPersistentManager::getInstance()->retriveUserOnUsername($username);
        
                if ($user && password_verify($password, $user->getPassword())) {
                    if ($user->isBanned()) {
                        $view->showError('Sei bannato!', false);
                    } elseif (USession::getSessionStatus() == PHP_SESSION_NONE) {
                        USession::getInstance(); // Session start
                        USession::setSessionElement('user', $user->getId()); // L'ID dell'utente viene posto nell'array $_SESSION
                        CHome::homePage();
                    }
                } else {
                    $view->showError('Password errata', false);
                }
            } else {
                $view->showError('Username non trovato', false);
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

        public static function profile($userId) { 
            if (CUser::isLogged()){
                $view = new VUser;
                $username = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();
                $podcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                if ($userId = USession::getSessionElement('user')){
                    CPodcast::myPodcast();
                }else{
                    $view->profile($podcasts, $username);
                }
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

        public static function editPassword(){
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                if (FPersistentManager::getInstance()->checkUser(array($user),$userId)){
                    $user_password = $user->getPassword();
                    $password = UHTTPMethods::post('vecchia password');
                    $newPassword = UHTTPMethods::post('nuova password');
                    $result = FPersistentManager::getInstance()->updatePassword($password, $user_password, $newPassword, $user); 
                    if ($result){
                        self::settings();
                    }else{
                        $view = new VUser;
                        $view->showError('impossibile modificare la password', false);
                    }
                }else{
                    $view = new VUser;
                    $view->showError('puoi modificare solamente la tua password', false);
                }
            }
        }
        

        public static function editUsername(){  
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                $email = $user->getEmail();
                if (FPersistentManager::getInstance()->checkUser(array($user),$userId)){
                    $oldUsername = $user->getUsername();
                    $newUsername = UHTTPMethods::post('nuovo username');
                    if (FPersistentManager::getInstance()->verifyUserUsername($newUsername) == false){
                        $result = FPersistentManager::getInstance()->updateObj($user, 'username', $newUsername);
                        if ($result){
                            $view = new VUser;
                            $view->settings($newUsername, $email, 'username modificato con successo', true);
                        }else{
                            $view = new VUser;
                            $view->settings($oldUsername, $email, 'impossibile modificare lo username', false);
                        }
                    }else{
                         $view = new VUser;
                         $view->settings($oldUsername, $email, 'username non disponibile', false);
                    }
                }else{
                    $view = new VUser;
                    $view->showError('puoi modificare solamente il tuo username', false);
                }
            }
        }

        public static function editEmail(){   
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                $username = $user->getUserUsername();
                if (FPersistentManager::getInstance()->checkUser(array($user),$userId)){
                    $oldEmail = $user->getEmail();
                    $newEmail = UHTTPMethods::post('nuova email');
                    if (FPersistentManager::getInstance()->verifyUserUsername($newEmail) == false){
                        $result = FPersistentManager::getInstance()->updateObj($user, 'email', $newEmail);
                        if ($result){
                            $view = new VUser;
                            $view->settings($username, $newEmail, 'email modificata con successo', true);
                        }else{
                            $view = new VUser;
                            $view->settings($username, $oldEmail, "impossibile modificare l' email", false);
                        }
                    }else{
                         $view = new VUser;
                         $view->settings($username, $oldEmail, 'email non disponibile', false);
                    }
                }else{
                    $view = new VUser;
                    $view->showError('puoi modificare solamente la tua email', false);
                }
            }
        }


        //--------------------------------------------------CREDIT CARD-----------------------------------------------------------------------
    
     /**
     * Adds a credit card taking info from the compiled form
     * $userId Refers to the id of the user who owns the card
     * 
     */

     public static function addCreditCard() { 
        $userId = USession::getInstance()->getSessionElement('user');
        $creditCard = new ECreditCard(UHTTPMethods::post('card_holder'),UHTTPMethods::post('card_number'),UHTTPMethods::post('security_code'),UHTTPMethods::post('expiration_date'),$userId);
    
        $result = FPersistentManager::getInstance()->createObj($creditCard);
        if ($result) {
            $view->showCreditCardSuccess("carta inserita con successo! :)");
        } else {
            $view::showCreditCardErrorView("problemi con l'inserimento della carta :(");
        }
    }

     /**
     * Remove a credit card 
     * @param int $cardId Refers to the id of the card to remove
     * 
     */

     public static function removeCreditCard($cardId) { 
        $userId = USession::getInstance()->getSessionElement('user');
        $creditCard = FPersistentManager::getInstance()->retrieveObj('ECreditCard',$cardId);
    
        $result = FPersistentManager::getInstance()->deleteObj($creditCard);
        if ($result) {
            $view->showCreditCardSuccess("carta rimossa con successo! :)");
        } else {
            $view::showCreditCardErrorView("Non è stato possibile rimuovere la carta :(");
        }
    }


    public static function showUserCreditCards() {       //metodo che mostra tutte le carte dell'utente 
        $userId = USession::getInstance()->getSessionElement('user');
        $creditCards = FPersistentManager::getInstance()->retrieveUserCreditCards($userId);
        
        if ($creditCards) {
            if ($creditCards) {
                // Maschera i numeri delle carte di credito
                foreach ($creditCards as &$creditCard) {
                    $maskedNumber = self::maskCreditCardNumber($creditCard->getCardNumber());
                    $creditCard->setCardNumber($maskedNumber);
                }
            VCreditCard::showCreditCards($creditCards);
        } else {
            VCreditCard::showCreditCardErrorView("Nessuna carta di credito trovata.");
        }
        }
    }
    
    public static function maskCreditCardNumber($cardNumber) {    //metodo che fa visualizzare solo le ultime 4 cifre di una carta
        return str_repeat('*', strlen($cardNumber) - 4) . substr($cardNumber, -4);  //di credito per motivi di sicurezza
    }

    }