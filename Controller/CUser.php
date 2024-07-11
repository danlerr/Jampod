<?php
   
class CUser{


        /**
        * check if the user is logged (using session)
        * @return boolean
        */
        public static function isLogged() {              //letsgo
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
                
            }
    
            // Se l'utente non è loggato, reindirizza alla pagina di login attraverso la view
            if (!$logged) {
                $view = new VUser();
                $view->showLoginForm();
                exit; 
            }
    
            return true; // Restituisce true se l'utente è loggato
        }

        
        public static function loginForm(){              //letsgo
            // Verifica se il cookie di sessione PHPSESSID è impostato
            if (UCookie::isSet('PHPSESSID')) {
                // Controlla se la sessione non è ancora avviata
                if (session_status() == PHP_SESSION_NONE) {
                    USession::getInstance(); // Avvia una nuova sessione
                }
            }
            
            // Verifica se l'elemento 'user' è presente nella sessione (utente loggato)
            if (USession::isSetSessionElement('user')) {
                $userId = USession::getInstance()->getSessionElement('user');
                $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
                if ($usersession->isAdmin()) {
                    CModeration::showDashboard();
                    exit;
                }
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
        public static function registration()              //letsgo
{
    $view = new VUser();

    // Recupera i dati dal POST
    $email = UHTTPMethods::post('email');
    $username = UHTTPMethods::post('username');
    $password = UHTTPMethods::post('password');

    // Verifica che tutti i campi siano stati riempiti
    if (empty($email) || empty($username) || empty($password)) {
        $view->showError('Tutti i campi sono obbligatori', false);
        return;
    }

    // Verifica che lo username e l'email non esistano nel db
    if (!FPersistentManager::getInstance()->verifyUserEmail($email) && !FPersistentManager::getInstance()->verifyUserUsername($username)) {
        $user = new EUser($email, $password, $username); // Nuovo oggetto entity user
        $result = FPersistentManager::getInstance()->createObj($user); // Salvataggio dell'utente nel db

        if ($result) {
            $view->showLoginForm(); // Mostra il form di login 
        } else {
            $view->showError('Errore durante la registrazione', false);
        }
    } else {
        $view->showError('Email o username già esistenti', false);
    }
}


        public static function registrationForm(){              //letsgo
            $view = new VUser;
            $view->showRegistrationForm();
        }

        /**
         * check if exist the Username inserted, and for this username check the password. If is everything correct the session is created and
         * the User is redirected in the homepage
         */
        public static function login() {              //letsgo
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
                    } else{
                        if (USession::getSessionStatus() == PHP_SESSION_NONE) {
                        USession::getInstance(); // Session start
                        USession::setSessionElement('user', $user->getId()); // L'ID dell'utente viene posto nell'array $_SESSION
                        if($user->isAdmin()){
                            $view = new VRedirect();
                            $view->redirect("/Jampod/Moderation/showDashboard");
                            exit;
                        }
                        CHome::homePage();
                        }
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
        public static function logout(){              //letsgo
            USession::getInstance();
            USession::unsetSession();
            USession::destroySession();
            $view = new VUser();
            $view->showLoginForm();
        }

        public static function profile($userId) {              //letsgo
            if (CUser::isLogged()){
                $view = new VUser;
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $podcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                if ($userId === USession::getSessionElement('user')){
                    CPodcast::myPodcast();
                }else{
                    $view->profile($podcasts, $user);
                }
            }
        }

    //--------------------------------------------------SETTINGS-----------------------------------------------------------------------
        public static function settings() {              //letsgo
            if (CUser::isLogged()){
                $view = new VUser();
                $userId = USession::getInstance()->getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $view->settings($user);
            }
        }

        public static function editPassword(){              //letsgo
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                if (FPersistentManager::getInstance()->checkUser($user->getId(),$userId)){
                    $user_password = $user->getPassword(); //password criptata dal db
                    $password = UHTTPMethods::post('old_password');
                    $newPassword = UHTTPMethods::post('new_password');  
                    $hashedNewPassword=password_hash($newPassword, PASSWORD_DEFAULT);
                    if (password_verify($password, $user_password)){
                        $result = FPersistentManager::getInstance()->updateObj($user, 'password', $hashedNewPassword); 
                        if ($result){
                            $view=new VUser;
                            $view->settings($user->getUsername(),$user->getEmail(),'password modificata con successo',true);
                        }else{
                            $view = new VUser;
                            $view->settings($user->getUsername(),$user->getEmail(),'impossibile modificare la password',false);
                        }
                    }else{
                            $view = new VUser;
                            $view->settings($user->getUsername(),$user->getEmail(),'non è questa la tua vecchia password',false);
                    }
                   
            }
        }}
        

        public static function editUsername(){                //letsgo
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                $email = $user->getEmail();
                if (FPersistentManager::getInstance()->checkUser($user->getId(),$userId)){
                    $oldUsername = $user->getUsername();
                    $newUsername = UHTTPMethods::post('nuovo_username');
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

        public static function editEmail(){                //letsgo 
            if (CUser::isLogged()){
                $userId = USession::getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
                $username = $user->getUsername();
                if (FPersistentManager::getInstance()->checkUser($user->getId(),$userId)){
                    $oldEmail = $user->getEmail();
                    $newEmail = UHTTPMethods::post('email');
                    if (FPersistentManager::getInstance()->verifyUserEmail($newEmail) == false){
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
        $username = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();
        $cardNumber = UHTTPMethods::post('card_number');
        $cardHolder = UHTTPMethods::post('card_holder');
        $securityCode = UHTTPMethods::post('security_code');
        $expirationDate = UHTTPMethods::post('expiration_date');
        
        
        // Convert MM/AA to Y/m
        $creditCard = new ECreditCard($cardHolder, $cardNumber, $securityCode, $expirationDate, $userId);
        $result = FPersistentManager::getInstance()->createObj($creditCard);  // Convert MM/AA to Y/m in createObject di FCreditCard
        $creditCards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
            $view=new VUser();
       
            if ($result) {
                $view->showUserCards($username, $creditCards,"carta inserita con successo! :)",true);
            } else {
                $view->showUserCards($username, $creditCards,"problemi con l'inserimento della carta :(",false);
            }
        }

     /**
     * Remove a credit card 
     * @param int $cardId Refers to the id of the card to remove
     * 
     */

     public static function removeCreditCard($cardId) { 
        $userId = USession::getInstance()->getSessionElement('user');
        $username = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();
       
        $card= FPersistentManager::getInstance()->retrieveObj('ECreditCard', $cardId);
        if (!$card) {
            $creditCards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
            $view=new VUser();
            $view->showUserCards($username, $creditCards,"Carta di credito non trovata o non autorizzata.", false);
            return;
        }
    
        $result = FPersistentManager::getInstance()->deleteObj($card);
        $creditCards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
        if ($result) {
            $view=new VUser();
            $view->showUserCards($username, $creditCards,"Carta rimossa con successo.", true);
        } else {
            $view=new VUser();
            $view->showUserCards($username, $creditCards,"Problemi con la rimozione della carta.", false);
        }
    }



    public static function userCards() {       //metodo che mostra tutte le carte dell'utente  
        $userId = USession::getInstance()->getSessionElement('user');
        $username = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();
        $creditCards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
    
       if(!empty($creditCards)){
            // Maschera i numeri delle carte di credito
            foreach ($creditCards as $card) {
                $maskedNumber = FPersistentManager::getInstance()->maskCreditCardNumber($card->getCreditCardNumber());
                $card->setCreditCardNumber($maskedNumber);
            }
       }
        $view=new VUser();
        $view->showUserCards($username, $creditCards,$textAlert=null,$success=null);
    
    }
}