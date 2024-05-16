<?php

class EVote {
    private $vote_id;

    private int $value;
    
    private $user_id;

    private $episode_id;
    //constructor
    public function __construct(int $value,  $user_id, $episode_id) {
         $this->setValue($value);
         $this->user_id = $user_id;
         $this->episode_id = $episode_id;
     }
     /**
     * Get the value of vote_id
     * 
     * @return $vote_id
     */

     public function getVoteId() {
        return $this->vote_id;
    }   
    /**
     * Get the value of value
     * 
     * @return $value
     */
    public function getValue(): int {
        return $this->value;
    }
    /**
     * Get the value of user_id
     * 
     * @return $user_id
     */
    public function getUserId()  {
        return $this->user_id;
    }
    /**
     * Get the value of episode_id
     * 
     * @return $episode_id
     */
    public function getEpisodeId(){
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
    public function setValue(int $value){
            if ($value >= 1 && $value <= 5) {
                $this->value = $value;
        }    
    }
     /**
     * Set the value of user_id
     * 
     * @return $user_id
     */
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    /**
     * Set the value of episode_id
     * 
     * @return $episode_id
     */
    public function setEpisodeId($episode_id){
        $this->episode_id = $episode_id;
}

}