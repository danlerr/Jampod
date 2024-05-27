<?php

/**
 * La classe ECreditcard contiene tutte le proprietà (attributi e metodi) riguardanti una carta di credito
 * Gli attributi o la descrivono sono:
 * -card_id: è un identificativo autoincrement, relativo alla carta di credito;
 * -card_holder: intestatario carta;
 * -card_number: numero della carta;
 * -security_code: codice di sicurezza a tre cifre;
 * -expiration_date: data di scadenza della carta;
 * -user_id: è un identificativo autoincrement, relativo all'utente che utilizza la carta
 * 
 */
class ECreditcard{
    /**
     * identificativo univoco della carta di credito
     * @AttributeType int
     */
    private $card_id;

    /**
     * intestatario carta
     * @AttributeType string
     */
    private $card_holder;
    

    /**
     * numero della carta
     * @AttributeType String
     */
    private $card_number;

    /**
     * codice di sicurezza della carta
     * @AttributeType string
     */
    private $security_code;

    /**
     * data di scadenza della carta nel formato mm/aa
     * @AttributeType String
     */
    private $expiration_date;



     /**
     * identificativo univoco dell'utente
     * @AttributeType int
     */
    private $user_id;





    // CONSTRUCTOR
    public function __construct($card_holder,$card_number,$security_code,$expiration_date) {
        $this->card_holder = $card_holder;
        $this->card_number = $card_number;
        $this->security_code=$security_code;
        $this->expiration_date=$expiration_date;
       

    }
    // GET METHODS
    /**
     * Get the value of card_id
     *
     * @return $card_id
     */

    public function getCardId() {
		return $this->card_id;}

    /**
     * Get the value of card_holder
     *
     * @return $card_holder
     */

    public function getCreditCardHolder() {
		return $this->card_holder;}

    
    /**
     * Get the value of card_number
     *
     * @return $card_number
     */
    public function getCreditCardNumber() {
		return $this->card_number;}


    /**
     * Get the value of security_code
     *
     * @return $security_code
     */
    public function getCreditCardSecurityCode() {
        return $this->security_code;}


    /**
     * Get the value of expiration_date
     * 
     * @return $expiration_date
     */
    
    public function getCreditCardExpirationDate() {
        return $this->expiration_date;}

    
    /**
     * Get the value of user_id
     *
     * @return $user_id
     */

     public function getUserId() {
		return $this->user_id;}
    


    // SET METHODS

     /**
     * Set the value of card_id
     *
     * @param $card_id
     */

    public function setCreditCardId($card_id){
        $this->card_id=$card_id;
    }

     /**
     * Set the value of card_holder
     *
     * @param $card_holder
     */
    public function setCreditCardHolder($card_holder){
        $this->card_holder=$card_holder;
    }

    
    /**
     * Set the value of card_number
     * 
     * @return $card_number
     */
    private function setCreditCardNumber($card_number) {
        $this->card_number= $card_number;
    }

     /**
     * Set the value of security_code
     *
     * @param $security_code
     */
    public function setCreditCardSecurityCode($security_code){
        $this->security_code=$security_code;
    }

     /**
     * Set the value of expiration_date
     *
     * @param $expiration_date
     */

    public function setCreditCardExpirationDate($expiration_date){
        $this->expiration_date=$expiration_date;
    }
    


}
?>