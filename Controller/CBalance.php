<?php
    
    class CBalance{
        
        public static function viewBalance() {            //letsgo
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance;
                // Recupera l'ID dell'utente dalla sessione
                $userId = USession::getInstance()->getSessionElement('user');  
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);  
                // Ottiene il saldo dell'utente
                $balance = $user->getBalance();
                // Mostra il saldo all'utente
                $view->showBalance($balance);
            }
        }

        public static function rechargeBalance() {            //letsgo
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance();
                
                // Recupera l'ID dell'utente dalla sessione
                $userId = USession::getInstance()->getSessionElement('user');
                
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
                        $view->showBalance($newBalance, "Hai ricaricato €{$amount}. Il tuo nuovo saldo è €{$newBalance}.", true); //alert
                        } else {
                            $view->showBalance($oldBalance, "Errore durante la ricarica del saldo.");
                        }
                    } else {
                        $view->showBalance($oldBalance, "Errore: importo non valido.");
                    
                }     
            } else {
                $view = new VBalance;
                $view->showError("Errore: utente non loggato.");      //log control??
            }
        }

        public static function withdrawBalance() {         //da commentare      //letsgo
            if (CUser::isLogged()) {
                $view = new VBalance();
                $userId = USession::getInstance()->getSessionElement('user');
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                
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
                        $view->showBalance($newBalance, "Hai prelevato €{$amount}. Il tuo nuovo saldo è €{$newBalance}.");
                        } else {
                            $view->showBalance($balance, "Errore durante il prelievo del saldo.");
                        }
                    } else {
                        $view->showBalance($balance, "Errore: importo non valido o saldo insufficiente.");
                    
                }
            }else{
                $view = new VBalance();
                $view->showError("Errore: utente non loggato.");  //log control??
            }
        }
    }