<?php
    
    class CBalance{
        
        public static function viewBalance() {
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance;
                // Recupera l'ID dell'utente dalla sessione
                $user = USession::getInstance()->getSessionElement('user');    
                // Ottiene il saldo dell'utente
                $balance = $user->getBalance();
                // Mostra il saldo all'utente
                $view->showBalance($balance);
            }
        }

        public static function rechargeBalance() {
            // Verifica se l'utente è loggato
            if (CUser::isLogged()) {
                $view = new VBalance();
                
                // Recupera l'ID dell'utente dalla sessione
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                
                // Recupera l'oggetto utente utilizzando l'ID utente
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                
                // Verifica che l'utente esista
                if (!$user) {
                    $view->showBalanceError("Errore: utente non trovato.");
                    return;
                }
                // Recupera l'importo dall'input dell'utente e ?valida?(da validare)
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $amount = UHTTPMethods::post('amount');
        
                    // Calcola il nuovo saldo se l'importo è valido
                    if ($amount > 0) {
                        $newBalance = $user->getBalance() + $amount;
                    
                        // Aggiorna il saldo dell'utente
                        $result = FPersistentManager::getInstance()->updateObj($user, 'balance', $newBalance);
                        if ($result) {
                            $user->setBalance($newBalance);
                            $view->showBalanceSuccess("Hai ricaricato €{$amount}. Il tuo nuovo saldo è €{$newBalance}."); //alert
                        } else {
                            $view->showBalanceError("Errore durante la ricarica del saldo.");
                        }
                    } else {
                        $view->showBalanceError("Errore: importo non valido.");
                    }
                } else {
                    $view->showBalanceForm();
                }    
            } else {
                $view = new VBalance;
                $view->showBalanceError("Errore: utente non loggato.");      //log control??
            }
        }

        public static function withdrawFromBalance() {         //da commentare 
            if (CUser::isLogged()) {
                $view = new VBalance();
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                
                if (!$user) {
                    $view->showBalanceError("Errore: utente non trovato.");
                    return;
                }
        
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $amount = UHTTPMethods::post('amount');
                    $balance = $user->getBalance();
                    
                    if ($amount !== null && $amount > 0 && $balance >= $amount) {
                        $newBalance = $balance - $amount;
                        $result = FPersistentManager::getInstance()->updateObj($user, 'balance', $newBalance);
                        if ($result) {
                            $user->setBalance($newBalance);
                            $view->showBalanceSuccess("Hai prelevato €{$amount}. Il tuo nuovo saldo è €{$newBalance}.");
                        } else {
                            $view->showBalanceError("Errore durante il prelievo del saldo.");
                        }
                    } else {
                        $view->showBalanceError("Errore: importo non valido o saldo insufficiente.");
                    }
                } else {
                    $view->showBalanceForm();
                }
            } else {
                $view->showBalanceError("Errore: utente non loggato.");  //log control??
            }
        }
    }