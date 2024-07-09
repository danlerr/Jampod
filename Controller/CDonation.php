<?php

class CDonation{

    /**
     * Create a donation taking info from the compiled form
     * @param int $podcastId Refers to the id of the podcast to which a donation has been made
     * 
     * // Per creare una donazione
     *CDonation::createDonation($donationId);
     */

    public static function createDonation($recipient_id) {             //letsgo
        if (CUser::isLogged()){
            $view = new VDonation;
            $userId = USession::getInstance()->getSessionElement('user');
            $donation = new EDonation(UHTTPMethods::post('amount'), UHTTPMethods::post('donationDescription'), $userId, $recipient_id);
            $result = FPersistentManager::getInstance()->createObj($donation);
            $sender = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            $recipient = FPersistentManager::getInstance()->retrieveObj('EUser', $recipient_id);
            $creator_username = $recipient->getUsername();
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
                $view->showDonation($recipient_id, $creator_username, "Donazione effettuata con successo!", true);
            } else {
                $view->showDonation($recipient_id, $creator_username, "Problemi con l'invio della donazione.", false);
            }
        }
    }

    public static function donationForm($podcast_id){          //letsgo
        if (CUser::isLogged()) {
            $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
            $recipient_id = $podcast->getUserId();
            $podcast_creator_user = FPersistentManager::getInstance()->retrieveObj('EUser', $recipient_id);
            $creator_username = $podcast_creator_user->getUsername();
            $view = new VDonation;
            $view->showDonation($recipient_id, $creator_username);
        }
    }
}