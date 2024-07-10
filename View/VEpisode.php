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

    public function showEpisodePage($usersession,$episode, $podcast,$creator, $commentAndReplies, $votevalue, $avgVote,  $textalert = null, $success = null) {
        $this->smarty -> assign('podcast_title', $podcast->getPodcastName());
        $this->smarty -> assign('creatorId', $podcast->getUserId());
        $this->smarty->assign('podcast_id', $podcast->getId());
        $this->smarty -> assign('episode_title' , $episode->getEpisode_title());
        $this->smarty -> assign('episode_streams', $episode->getEpisode_streams());
        $this->smarty->assign('episode_id', $episode->getId());
        $this->smarty -> assign ('usernamecreator' , $creator->getUsername());
        $this->smarty -> assign ('votevalue', $votevalue);
        $this->smarty -> assign ('avgVote', $avgVote);
        $this->smarty -> assign( 'episode_description', $episode->getEpisode_description());
        $this->smarty -> assign ('commentAndReplies' , $commentAndReplies);
        $this->smarty -> assign('mimetype', $episode->getImageMimeType());
        $this->smarty -> assign('imagedata', $episode->getEncodedImageData());
        $this->smarty->assign('success', $success);
        $this->smarty->assign('textalert', $textalert);
        $this->smarty->assign('username', $usersession->getUsername());
        $this->smarty -> display('Smarty/templates/episode.tpl');
    }
    
    public function showError($string){
        $this->smarty->assign('string', $string);
        $this->smarty->display('Smarty/templates/error.tpl');
    }

    
}