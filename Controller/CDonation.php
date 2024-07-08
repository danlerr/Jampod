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
            $sender = FPersistentManager::getInstance()->retrieveObj('EUser',$userId);
            $recipient = FPersistentManager::getInstance()->retrieveObj('EUser',$recipient_id);
            $creator_username = $recipient->getUsername();
            if ($result) {
                $balanceS = $sender->setBalance($sender->getBalance()-($donation->getDonationAmount()));
                $balanceR = $recipient->setBalance($recipient->getBalance()+$donation->getDonationAmount());
                FPersistentManager::getInstance()->updateObj($sender,'balance',$balanceS);
                FPersistentManager::getInstance()->updateObj($recipient,'balance',$balanceR);
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
    //--------------------------------------------------TRANSACTIONS------------------------------------------------------------------------------
    /**
     * shows the list of the donations received by the user
     * 
     */

     public static function showDonationsReceived(){
        $view = new VDonation;
        $userId = USession::getInstance()->getSessionElement('user');
        $donations = FPersistentManager::getInstance()->retrieveDonationsReceived($userId);
        $view->showDonations($donations);

     }

     /**
     * shows the list of the donations made by the user
     * 
     */
     public static function showDonationsMade(){
        $view = new VDonation;
        $userId = USession::getInstance()->getSessionElement('user');
        $donations = FPersistentManager::getInstance()->retrieveDonationsMade($userId);
        $view->showDonations($donations);

     }
    
    /**
     * Shows the list of all donations related to the user, both received and made, ordered by date.
     */
    public static function showAllDonations() {
        $view = new VDonation;
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
     
        
    }