<?php

/**
 * La classe EComment contiene tutte le proprietà (attributi e metodi) riguardanti un commento
 * Gli attributi o la descrivono sono:
 * -comment_id: è un identificativo autoincrement, relativo al commento;
 * -comment_text: testo del commento;
 * -comment_time: data e ora in cui viene scritto il commento;
 * -user_id: identificativo univoco utente che scrive il commento
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
     * @AttributeType Datetime
     */
    private  $comment_time;

    /**
     * utente che ha effettuato il commento
     * @AttributeType int
     */
    private $user_id;


    /**
     * identificativo episodio commentato
     * @AttributeType String
     */
    private $episode_id;

    


    /**
     * identificativo commento commentato
     * @AttributeType int
     */
    private $parentCommentId = null; // Campo parentCommentId, inizializzato a null
    private $commentUsername;

    // CONSTRUCTOR
    public function __construct($comment_text,$user_id,$episode_id) {
        $this->comment_text = $comment_text;
        $this->user_id=$user_id;
        $this->episode_id=$episode_id;
        $this->setTime();

    }

    // GET METHODS
    /**
     * Get the value of comment_id
     *
     * @return $comment_id
     */

    public function getId() {
		return $this->comment_id;}
        /**
     * Get the value of comment_text
     *
     * @return $comment_text
     */

    public function getCommentText() {
		return $this->comment_text;}

    
    /**
     * Get the value of comment_time
     *
     * @return $comment_time
     */
    public function getCommentTime() {
		return $this->comment_time;}
    /**
     * Get the value of user_id
     *
     * @return $user_id
     */
    public function getUserId() {
        return $this->user_id;}
    
    /**
     * Get the value of episode_id
     *
     * @return $episode_id
     */
    
    public function getEpisodeId() {
        return $this->episode_id;}
    
    /**
     * Get the value of parentCommentId
     *
     * @return $parentCommentId
     */
    
    public function getParentCommentId() {
        return $this->parentCommentId;
    }
    
    

    // SET METHODS

     /**
     * Set the value of comment_id
     *
     * @param $comment_id
     */

    public function setCommentId($comment_id){
        $this->comment_id=$comment_id;
    }

     /**
     * Set the value of comment_text
     *
     * @param $text
     */
    public function setCommentText($text){
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

    public function setCommentCreationTime( $commentTime){
        $this->comment_time = $commentTime;
    }
    
    /**
     * Set the value of parentCommentId
     * 
     * @return $parentCommentId
     */
    public function setParentCommentId($parentCommentId) {
        $this->parentCommentId = $parentCommentId;
    }

    
    public function setCommentUsername($commentUsername) {
        $this->commentUsername = $commentUsername;
    }
    public function getCommentUsername() {
        return $this->commentUsername;
    }

    
    public function getTimetoStr()
    {
        return $this->comment_time->format('Y-m-d H:i:s');
    }
}
