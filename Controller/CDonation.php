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
        $donation = new EDonation(UHTTPMethods::post('amount'),UHTTPMethods::post('text'),$userId,$podcast->getUserId());
    
        $result = FPersistentManager::getInstance()->createObj($donation);
        if ($result) {
            $view->showDonationSuccess("donazione effettuata con successo! :)");
        } else {
            $view::showDonationErrorView("problemi con l'invio della donazione :(");
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
        VDonation::showDonations($donations);

     }

     /**
     * shows the list of the donations made by the user
     * 
     */
     public static function showDonationsMade(){
        $userId = USession::getInstance()->getSessionElement('user');
        $donations = FPersistentManager::getInstance()->retrieveDonationsMade($userId);
        VDonation::showDonations($donations);

     }

     //--------------------------------------------------CREDIT CARD-----------------------------------------------------------------------
    
     /**
     * Adds a donation taking info from the compiled form
     * @param int $userId Refers to the id of the user who owns the card
     * 
     */

     public static function createDonation($podcastId) { //!!!!!!!!!!!!!!!!!!!!!!!!!! quando si dona dalla pagine dell'episodio fornire il podcastId
        $userId = USession::getInstance()->getSessionElement('user');
        $podcast=FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcastId);
        $donation = new EDonation(UHTTPMethods::post('amount'),UHTTPMethods::post('text'),$userId,$podcast->getUserId());
    
        $result = FPersistentManager::getInstance()->createObj($donation);
        if ($result) {
            $view->showDonationSuccess("donazione effettuata con successo! :)");
        } else {
            $view::showDonationErrorView("problemi con l'invio della donazione :(");
        }
    }



    



}