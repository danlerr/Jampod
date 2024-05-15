<?php

class EVote {
    private $vote_id;

    private int $number;
    
    private $user_id;

    private $episode_id;

    public function __construct(int $number, int $user_id, int $episode_id) {
         $this->number = $number;
         $this->user_id = $user_id;
         $this->episode_id = $episode_id;
     }
     public function getVoteId(): int {
        return $this->vote_id;
    }   
    public function getNumber(): int {
        return $this->number;
    }
    public function getUserId(): int {
        return $this->user_id;
    }
    public function getEpisodeId(): int {
        return $this->episode_id;
    }
    public function setVoteId(int $vote_id) {
        $this->vote_id = $vote_id;
    }
    public function setNumber(int $number){
        $this->number = $number;
    }
    public function setUserId(int $user_id){
        $this->user_id = $user_id;
    }
    public function setEpisodeId(int $episode_id){
        $this->episode_id = $episode_id;
}

}