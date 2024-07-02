<?php

class EVote {
    //attributes
    private  $vote_id;

    private  $value;
    
    private  $user_id;

    private  $episode_id;
    //constructor
    public function __construct( $value,  $user_id,  $episode_id) {
         $this->setValue($value);
         $this->user_id = $user_id;
         $this->episode_id = $episode_id;
     }
     //Methods
     /**
     * Get the value of vote_id
     * 
     * @return $vote_id
     */

     public function getId()  {
        return $this->vote_id;
    }   
    /**
     * Get the value of value
     * 
     * @return $value
     */
    public function getValue() {
        return $this->value;
    }
    /**
     * Get the value of user_id
     * 
     * @return $user_id
     */
    public function getUserId() {
        return $this->user_id;
    }
    /**
     * Get the value of episode_id
     * 
     * @return $episode_id
     */
    public function getEpisodeId() {
        return $this->episode_id;
    }
    /**
     * Set the value of vote_id
     * 
     * @return $vote_id
     */
    public function setVoteId($vote_id) {
        $this->vote_id = $vote_id;
    }
    /**
     * Set the value of value
     * 
     * @return $value
     */
    public function setValue( $value){
            if ($value >= 1 && $value <= 5) {
                $this->value = $value;
            } else {
                throw new Exception("Vote value must be between 1 and 5.");
    
        }    
    }
   

}