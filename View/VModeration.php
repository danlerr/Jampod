<?php
require_once 'StartSmarty.php';
    class VModeration{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function adminDashboard($users){
            $this->smarty->assign('users', $users);
            
            $this->smarty->display('Smarty/templates/Admin/users.tpl');
        }
        public function userPodcasts($user, $podcasts) {
            $this->smarty->assign('podcasts', $podcasts);
            $this->smarty->assign('user', $user);
            
            $this->smarty->display('Smarty/templates/Admin/podcasts.tpl');
        }
        public function podcastEpisodes($podcast, $episodes) {
            $this->smarty->assign('podcast', $podcast);
            $this->smarty->assign('episodes', $episodes);
            
            $this->smarty->display('Smarty/templates/Admin/episodes.tpl');
        }
        public function episodeComments($episode, $comments) {
            $this->smarty->assign('episode', $episode);
            $this->smarty->assign('comments', $comments);
            
            $this->smarty->display('Smarty/templates/Admin/comments.tpl');
        }

    }