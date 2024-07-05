<?php


class VEpisode{
    private $smarty;

    public function __construct(){
 
        $this->smarty = StartSmarty::configuration();
 
    }
    public function showCreationForm() {
        $this->smarty->display('creationEpisode.tpl');
    }

    public function showEpisodePage($episode, $podcast_title,$usernamecreator, $commentAndReplies, $votevalue=null, $avgVote, $image , $textalert= null, $success =null) {
        $this->smarty -> assign('podcast_title', $podcast_title);
        $this->smarty -> assign('episode_title' , $episode->getEpisode_title());
        $this->smarty -> assign('episode_streams', $episode->getEpisode_streams());
        $this->smarty -> assign ('usernamecreator' , $usernamecreator);
        $this->smarty -> assign ('votevalue', $votevalue);
        $this->smarty -> assign ('avgVote', $avgVote);
        $this->smarty -> assign( 'episode_description ', $episode->getEpisode_description());
        $this->smarty -> assign ('commentAndReplies' , $commentAndReplies);
        $this->smarty -> assign('mimetype', $image[0]);
        $this->smarty -> assign('imagedata', $image[1]);
        $this->smarty -> assign('textalert', $textalert);
        $this->smarty -> assign('success', $success);
        $this->smarty -> assign ('episode_id', $episode->getId());
        $this->smarty -> display('episode.tpl');
    }
    public function showEpisodeError($episode, $podcast_title, $usernamecreator, $comments, $avgVote, $image, $textalert = null, $success = null) {
        $this->showEpisodePage($episode, $podcast_title, $usernamecreator, $comments, $avgVote, $image, $textalert, false);
    }

    
    public function showError($string){
        $this->smarty->assign('string', $string);
        $this->smarty->display('error.tpl');
    }

    
}