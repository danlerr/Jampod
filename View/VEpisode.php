<?php


class VEpisode{
    private $smarty;

    public function __construct(){
 
        $this->smarty = StartSmarty::configuration();
 
    }

    public function showEpisodePage($episode, $comments, $avgVote, $image) {
        


    }
    public function showEpisodeError() {


    }
    public function showVote() {

    }
    
}