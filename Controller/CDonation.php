<?php

class CDonation{

    /**
     * Create a donation taking info from the compiled form
     * @param int $podcastId Refers to the id of the podcast to which a donation has been made
     * 
     * // Per creare una donazione
     *CDonation::createDonation($donationId);
     */

     public static function createDonation($podcastId) { //!!!!!!!!!!!!!!!!!!!!!!!!!! quando si dona dalla pagine dell'episodio fornire il podcastId
        $userId = USession::getInstance()->getSessionElement('user');
        $podcast=FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcastId);
        $recipientId=$podcast->getUserId();
        $donation = new EDonation(UHTTPMethods::post('amount'),UHTTPMethods::post('text'),$userId,$recipientId);
    
        $result = FPersistentManager::getInstance()->createObj($donation);
        if ($result) {
            $sender=FPersistentManager::getInstance()->retrieveObj('EUser',$userId);
            $recipient=FPersistentManager::getInstance()->retrieveObj('EUser',$recipientId);
            $balanceS=$sender->setBalance($sender->getBalance()-($donation->getDonationAmount()));
            $balanceR=$recipient->setBalance($recipient->getBalance()+$donation->getDonationAmount());
            FPersistentManager::getInstance()->updateObj($sender,'balance',$balanceS);
            FPersistentManager::getInstance()->updateObj($recipient,'balance',$balanceR);
            $view->showDonationSuccess("Donazione effettuata con successo!");
        } else {
            $view->showDonationErrorView("Problemi con l'invio della donazione.");
        }
    }
    //--------------------------------------------------TRANSACTIONS------------------------------------------------------------------------------
    /**
     * shows the list of the donations received by the user
     * 
     */

     public static function showDonationsReceived(){
        $userId = USession::getInstance()->getSessionElement('user');
        $donations = FPersistentManager::getInstance()->retrieveDonationsReceived($userId);
        $view->showDonations($donations);

     }

     /**
     * shows the list of the donations made by the user
     * 
     */
     public static function showDonationsMade(){
        $userId = USession::getInstance()->getSessionElement('user');
        $donations = FPersistentManager::getInstance()->retrieveDonationsMade($userId);
        $view->showDonations($donations);

     }
    
    /**
     * Shows the list of all donations related to the user, both received and made, ordered by date.
     */
    public static function showAllDonations() {
        $userId = USession::getInstance()->getSessionElement('user');
        $user=FPersistentManager::getInstance()->retrieveObj('EUser',$userId);
        $balance=$user->getBalance();

        // Retrieve donations made and received
        $donationsMade = FPersistentManager::getInstance()->retrieveDonationsMade($userId);
        $donationsReceived = FPersistentManager::getInstance()->retrieveDonationsReceived($userId);

        // Merge the donations into a single array
        $allDonations = array_merge($donationsMade, $donationsReceived);

        // Sort donations by date
        usort($allDonations, function($a, $b) {
            return strtotime($b->getDonationTime()) - strtotime($a->getDonationTime());
        });

        // Show donations in the view
        $view->showAllDonations($balance,$allDonations);
    }
     
    public static function donationForm($recipient_id){
        if (CUser::isLogged()) {
            $view = new VDonation;
            $view->showDonationForm($recipient_id);
        }
    }


    }