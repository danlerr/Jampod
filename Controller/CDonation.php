<?php

class CDonation{

    /**
     * Crea una donazione prendendo le informazioni dal form
     * @param int $podcastId Refers to the id of the podcast to which a donation has been made
     * 
     * // Per creare una donazione
     *CDonation::createDonation($donationId);
     */

    public static function createDonation($recipient_id) {            
        if (CUser::isLogged()){
            $view = new VDonation;
            $userId = USession::getInstance()->getSessionElement('user');
            $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
            $amount = UHTTPMethods::post('amount');
            $sender = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            $recipient = FPersistentManager::getInstance()->retrieveObj('EUser', $recipient_id);
            $creator_username = $recipient->getUsername();
            $senderBalance = $sender->getBalance();
            
            if ($amount>0 && $usersession->getBalance()>$amount){
                $donation = new EDonation(UHTTPMethods::post('amount'), UHTTPMethods::post('donationDescription'), $userId, $recipient_id);
                $result = FPersistentManager::getInstance()->createObj($donation);

                if ($result) {
                    $senderBalance = floatval($sender->getBalance());

                    $donationAmount = floatval($donation->getDonationAmount());

                    $recipientBalance = floatval($recipient->getBalance());

                    $newBalanceSender = $senderBalance - $donationAmount;
                    $sender->setBalance($newBalanceSender);
                    $newBalanceRecipient = $recipientBalance + $donationAmount;
                    $sender->setBalance($newBalanceRecipient);

                    FPersistentManager::getInstance()->updateObj($sender, 'balance', $newBalanceSender);
                    FPersistentManager::getInstance()->updateObj($recipient, 'balance', $newBalanceRecipient);
                    $view->showDonation($usersession,$recipient_id, $creator_username, $senderBalance, "Donazione effettuata con successo!", true);
                } else {
                    $senderBalance = floatval($sender->getBalance());
                    $view->showDonation($usersession,$recipient_id, $creator_username, $senderBalance, "Problemi con l'invio della donazione.", false);
                }
            }else{
                $view->showDonation($usersession,$recipient_id, $creator_username, $senderBalance, "Impossibile effettuare la donazione, saldo insufficiente.", false);
            }
        }
    }
    //metodo per mostrare la form della donazione all'utente
    public static function donationForm($podcast_id){          
        if (CUser::isLogged()) {
            $userId = USession::getInstance()->getSessionElement('user');
            $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
            $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
            $recipient_id = $podcast->getUserId();
            $podcast_creator_user = FPersistentManager::getInstance()->retrieveObj('EUser', $recipient_id);
            $creator_username = $podcast_creator_user->getUsername();
            $sender = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            $senderBalance = floatval($sender->getBalance());
            $view = new VDonation;
            $view->showDonation($usersession,$recipient_id, $creator_username, $senderBalance);
        }
    }
}