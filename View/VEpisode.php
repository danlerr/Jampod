<?php


class VEpisode{
    private $smarty;

    public function __construct(){
 
        $this->smarty = StartSmarty::configuration();
 
    }

    public function showEpisodePage($episode, $podcast_title,$usernamecreator, $comments, $avgVote, $image , $textalert= null, $success =null) {
        $this->smarty -> assign('podcast_title', $podcast_title);
        $this->smarty -> assign('episode_title' , $episode->getEpisode_title());
        $this->smarty -> assign('episode_streams', $episode->getEpisode_streams());
        $this->smarty -> assign ('usernamecreator' , $usernamecreator);
        $this->smarty -> assign ('avgVote', $avgVote);
        $this->smarty -> assign( 'episode_description ', $episode->getEpisode_description());
        $this->smarty -> assign ('comments' , $comments);
        $this->smarty -> assign('mimetype', $image[0]);
        $this->smarty -> assign('imagedata', $image[1]);
        $this->smarty -> assign('textalert', $textalert);
        $this->smarty -> assign('success', $success);
        $this->smarty -> display('episode.tpl');
        //manca audio 




    }
    public function showEpisodeError() {


    }
    public function showVote() {

    }
    
}