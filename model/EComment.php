<?php

/**
 * La classe EComment contiene tutte le proprietà (attributi e metodi) riguardanti un commento
 * Gli attributi o la descrivono sono:
 * -comment_id: è un identificativo autoincrement, relativo al commento;
 * -comment_text: testo del commento;
 * -comment_time: data e ora in cui viene scritto il commento;
 * -user: utente che scrive il commento
 * -podcast_id: identificativo podcast a cui appartiene l'episodio commentato
 * -episode_id: identificativo episodio che viene commentato
 * 
 */
class EComment{
    /**
     * identificativo univoco del commento
     * @AttributeType int
     */
    private $comment_id;

    /**
     * testo del commento
     * @AttributeType string
     */
    private $comment_text;
    

    /**
     * data e ora in cui è avvenuto il commento
     * @AttributeType String
     */
    private $comment_time;

    /**
     * utente che ha effettuato il commento
     * @AttributeType EUser
     */
    private $user;

    /**
     * identificativo podcast a cui appartiene l'episodio commentato
     * @AttributeType String
     */
    private $podcast_id;

    /**
     * identificativo episodio commentato
     * @AttributeType String
     */
    private $episode_id;

    // CONSTRUCTOR
    public function __construct($a,$c,EUser $d,$e,$f) {
        $this->comment_text = $a;
        $this->comment_time = $c;
        $this->user=new EUser($d->getName(),$d->getSurname(),$d->getEmail(),$d->getPassword(),$d->getUsername());  // aggiungere ai costruttori user_id (?)
        $this->podcast_id=$e;
        $this->episode_id=$f;

    }
    // GET METHODS
    /**
     * Get the value of comment_id
     *
     * @return $comment_id
     */

    public function getComment_id() {
		return $this->comment_id;}
        /**
     * Get the value of comment_text
     *
     * @return $comment_text
     */

    public function getComment_text() {
		return $this->comment_text;}

    
    /**
     * Get the value of comment_time
     *
     * @return $comment_time
     */
    public function getComment_time() {
		return $this->comment_time;}
    /**
     * Get the value of username
     *
     * @return $user->getUsername()
     */
    public function getUsername() {
        return $this->user->getUsername();}
    /**
     * Get the value of podcast_id
     *
     * @return $podcast_id
     */
    
    public function getPodcast_id() {
        return $this->podcast_id;}
    /**
     * Get the value of episode_id
     *
     * @return $episode_id
     */
    
    public function getEpisode_id() {
        return $this->episode_id;}
    


    // SET METHODS

     /**
     * Set the value of comment_id
     *
     * @param $comment_id
     */

    public function setComment_id($comment_id){
        $this->comment_id=$comment_id;
    }

     /**
     * Set the value of comment_text
     *
     * @param $text
     */
    public function setComment_text($text){
        $this->comment_text=$text;
    }

    
    /**
     * Set the value of comment_time
     * 
     * @return $comment_time
     */
    private function setTime() {
    
        $this->comment_time = new DateTime("now");
    }

     /**
     * Set the value of user_id
     *
     * @param $user_id
     */
    public function setUser_id(EUser $user){
        $this->user=$user;
    }

     /**
     * Set the value of podcast_id
     *
     * @param $podcast_id
     */

    public function setPodcast_id($podcast_id){
        $this->podcast_id=$podcast_id;
    
     /**
     * Set the value of episode_id
     *
     * @param $episode_id
     */
    }
    public function setEpisode_id($episode_id){
        $this->episode_id=$episode_id;
    }

    // TO STRING
     public function toString(){
        return $this->getUsername().": ".$this->comment_text;
     }

}
?>