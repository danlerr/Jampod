<?php
    
    class CBalance{
        
        public static function viewBalance() {            
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance;
                // Recupera l'ID dell'utente dalla sessione
                $userId = USession::getInstance()->getSessionElement('user');
                $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);  
                $cards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
                foreach ($cards as $card) {
                    $maskedNumber = FPersistentManager::getInstance()->maskCreditCardNumber($card->getCreditCardNumber());
                    $card->setCreditCardNumber($maskedNumber);
                }
                // Ottiene il saldo dell'utente
                $balance = $user->getBalance();
                //recupero tutte le donazione fatte/ricevute 
                $donationsReceived = FPersistentManager::getInstance()->donationsReceived($userId);
                $donationsMade = FPersistentManager::getInstance()->donationsMade($userId);
                // Mostra il saldo all'utente
                $view->showBalance($usersession,$cards, $balance, $donationsReceived, $donationsMade);
            }
        }

        public static function rechargeBalance() {            
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance();
                
                // Recupera l'ID dell'utente dalla sessione
                $userId = USession::getInstance()->getSessionElement('user');
                $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
                $cards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
                foreach ($cards as $card) {
                    $maskedNumber = FPersistentManager::getInstance()->maskCreditCardNumber($card->getCreditCardNumber());
                    $card->setCreditCardNumber($maskedNumber);
                }
                $donationsReceived = FPersistentManager::getInstance()->donationsReceived($userId);
                $donationsMade = FPersistentManager::getInstance()->donationsMade($userId);
                
                // Recupera l'oggetto utente utilizzando l'ID utente
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $oldBalance = $user->getBalance();
                
                // Verifica che l'utente esista
                if (!$user) {
                    $view->showError("Errore: utente non trovato.");
                    return;
                }
                // Recupera l'importo dall'input dell'utente e ?valida?(da validare)
                $amount = UHTTPMethods::post('amount');
        
                    // Calcola il nuovo saldo se l'importo è valido
                if ($amount > 0) {
                    $newBalance = $user->getBalance() + $amount;
                    
                    // Aggiorna il saldo dell'utente
                    $result = FPersistentManager::getInstance()->updateObj($user, 'balance', $newBalance);
                    if ($result) {
                        $user->setBalance($newBalance);
                        $view->showBalance($usersession,$cards, $newBalance, $donationsReceived, $donationsMade, "Hai ricaricato {$amount} quartz. Il tuo nuovo saldo è {$newBalance} quartz.", true); //alert
                        
                    } else {
                            $view->showBalance($usersession,$cards, $oldBalance, $donationsReceived, $donationsMade, "Errore durante la ricarica del saldo.");
                        }
                    } else {
                        $view->showBalance($usersession,$cards, $oldBalance, $donationsReceived, $donationsMade, "Errore: importo non valido.");
                    
                }     
            } else {
                $view = new VBalance;
                $view->showError("Errore: utente non loggato.");      
            }
        }

        public static function withdrawBalance() {             
            if (CUser::isLogged()) {
                $view = new VBalance();
                $userId = USession::getInstance()->getSessionElement('user');
                $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
                $cards = FPersistentManager::getInstance()->retrieveMyCreditCards($userId);
                foreach ($cards as $card) {
                    $maskedNumber = FPersistentManager::getInstance()->maskCreditCardNumber($card->getCreditCardNumber());
                    $card->setCreditCardNumber($maskedNumber);
                }
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $donationsReceived = FPersistentManager::getInstance()->donationsReceived($userId);
                $donationsMade = FPersistentManager::getInstance()->donationsMade($userId);
                
                if (!$user) {
                    $view->showError("Errore: utente non trovato.");
                    return;
                }
        
                $amount = UHTTPMethods::post('amount');
                $balance = $user->getBalance();
                    
                if ($amount !== null && $amount > 0 && $balance >= $amount) {
                    $newBalance = $balance - $amount;
                    $result = FPersistentManager::getInstance()->updateObj($user, 'balance', $newBalance);
                    if ($result) {
                        $user->setBalance($newBalance);
                        $view->showBalance($usersession,$cards, $newBalance, $donationsReceived, $donationsMade, "Hai prelevato {$amount} quartz. Il tuo nuovo saldo è {$newBalance} quartz.");
                        } else {
                            $view->showBalance($usersession,$cards, $balance, $donationsReceived, $donationsMade, "Errore durante il prelievo del saldo.");
                        }
                    } else {
                        $view->showBalance($usersession,$cards, $balance, $donationsReceived, $donationsMade,"Errore: importo non valido o saldo insufficiente.");
                    
                }
            }else{
                $view = new VBalance();
                $view->showError("Errore: utente non loggato.");  
            }
        }
    }