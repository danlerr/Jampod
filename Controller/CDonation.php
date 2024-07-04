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
    

    /**
     * Shows the list of all donations related to the user, both received and made, ordered by date.
     */
    public static function showAllDonations() {
        $userId = USession::getInstance()->getSessionElement('user');

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
        VDonation::showAllDonations($allDonations);
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