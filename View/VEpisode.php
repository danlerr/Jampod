<?php

require_once 'StartSmarty.php';
class VEpisode{
    private $smarty;

    public function __construct(){
 
        $this->smarty = StartSmarty::configuration();
 
    }
    public function showCreationForm($podcast_id) {
        $this->smarty->assign('podcast_id', $podcast_id);
        $this->smarty->display('Smarty/templates/createEpisode.tpl');
    }

    public function showEpisodePage($episode, $podcast,$usernamecreator, $commentAndReplies, $votevalue, $avgVote, $image,  $textalert = null, $success = null) {
        $this->smarty -> assign('podcast_title', $podcast->getPodcastName());
        $this->smarty->assign('podcast_id', $podcast->getId());
        $this->smarty -> assign('episode_title' , $episode->getEpisode_title());
        $this->smarty -> assign('episode_streams', $episode->getEpisode_streams());
        $this->smarty->assign('episode_id', $episode->getId());
        $this->smarty -> assign ('usernamecreator' , $usernamecreator);
        $this->smarty -> assign ('votevalue', $votevalue);
        $this->smarty -> assign ('avgVote', $avgVote);
        $this->smarty -> assign( 'episode_description', $episode->getEpisode_description());
        $this->smarty -> assign ('commentAndReplies' , $commentAndReplies);
        $this->smarty -> assign('mimetype', $image[0]);
        $this->smarty -> assign('imagedata', $image[1]);
        $this->smarty->assign('success', $success);
        $this->smarty->assign('textalert', $textalert);
        $this->smarty -> display('Smarty/templates/episode.tpl');
    }
    public function showEpisodeError($episode, $podcast,$usernamecreator, $commentAndReplies, $votevalue, $avgVote, $image) {
        $this->showEpisodePage($episode, $podcast,$usernamecreator, $commentAndReplies, $votevalue, $avgVote, $image );
    }

    
    public function showError($string){
        $this->smarty->assign('string', $string);
        $this->smarty->display('Smarty/templates/error.tpl');
    }

    
}