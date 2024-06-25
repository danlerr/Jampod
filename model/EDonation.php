<?php

/**
 * La classe EDonation contiene tutte le proprietà (attributi e metodi) riguardanti una donazione
 * Gli attributi o la descrivono sono:
 * -donation_id: è un identificativo autoincrement, relativo alla donazione;
 * -text: descrizione facoltativa della donazione
 * -sender_id: è un identificativo autoincrement, relativo all'utente che effettua la donazione;
 * -recipient_id:è un identificativo autoincrement, relativo all'utente che riceve la donazione;
 * -amount:somma donata;
 * -sender_balance: saldo presente sulla carta del donatore;
 * -recipient_balance: saldo presente sulla carta del ricevente;
 * -time: data e ora di quando è avvenuta la donazione
 * 
 * (??? aggiungere donazione a lista dei movimenti del sender e del recipient (quindi aggiungere attributo array 'movimenti' a EUser 
 * e passarlo al costruttore di donazione??
 * nel costruttore la donazione viene aggiunta agli array movimenti del sender e del recipient??)
 */
class EDonation{
    /**
     * identificativo univoco della donazione
     * @AttributeType int
     */
    private $donation_id;

/**
     * descrizione della donazione
     * @AttributeType String
     */
    private $text;

/**
     * identificativo univoco dell'utente che effettua la donazione
     * @AttributeType int
     */
    private $sender_id;


     /**
     * identificativo univoco dell'utente che riceve la donazione
     * @AttributeType int
     */
    private $recipient_id;


    /**
     * somma donata
     * @AttributeType Int
     */
    private $amount;
    
/**
     * data e ora in cui è avvenuto il commento
     * @AttributeType Datetime
     */
    private Datetime $time;

    // CONSTRUCTOR
    public function __construct($amount,$text,$sender_id,$recipient_id) {
        $this->amount = $amount;
        $this->text = $text;
        $this->sender_id=$sender_id;
        $this->recipient_id=$recipient_id;
        $this->setTime();
    
    }
    // GET METHODS
    /**
     * Get the value of donation_id
     *
     * @return $donation_id
     */

    public function getId() {
		return $this->donation_id;}

    /**
     * Get the value of text
     *
     * @return $text
     */

    public function getDonationText() {
		return $this->text;}

    
    /**
     * Get the value of sender_id
     *
     * @return $sender_id
     */
    public function getDonationSenderId() {
		return $this->sender_id;}


    /**
     * Get the value of recipient_id
     *
     * @return $recipient_id
     */
    public function getDonationRecipientId() {
        return $this->recipient_id;}


    /**
     * Get the value of amount
     * 
     * @return $amount
     */
    
    public function getDonationAmount() {
        return $this->amount;}

    /**
     * Get the value of time
     *
     * @return $time
     */
    public function getDonationTime() {
		return $this->time;}


    // SET METHODS

     /**
     * Set the value of donation_id
     *
     * @param $donation_id
     */

    public function setDonationId($donation_id){
        $this->donation_id=$donation_id;
    }

     /**
     * Set the value of card_holder
     *
     * @param $card_holder
     */
    public function setDonationText($text){
        $this->text=$text;
    }


     /**
     * Set the value of amount
     *
     * @param $amount
     */

    public function setDonationAmount($amount){
        $this->amount=$amount;
    }
    
    

    /**
     * Set the value of time
     * 
     * @return $time
     */
    private function setTime() {
    
        $this->time = new DateTime("now");
    }


    public function setDonationCreationTime(DateTime $time){
        $this->time = $time;
    }
   
}
?>