<?php
require_once 'StartSmarty.php';
    class VPodcast{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showPodcastPage($user, $podcast, $creator, $episodes, $userRole, $sub = null, $textalert = null, $success = null){
            $this->smarty->assign('user', $user);
            $this->smarty->assign('podcast', $podcast);
            $this->smarty->assign('creator', $creator);
            $this->smarty->assign('episodes', $episodes);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->assign('userRole', $userRole);
            $this->smarty->assign('sub', $sub);
            $this->smarty->assign('success', $success);
            $this->smarty->display('Smarty/templates/podcast.tpl');

        }
         

        public function showMyPodcastPage($user, $myPodcasts, $success = null, $textalert = null){
            $this->smarty->assign('user', $user);
            $this->smarty->assign('userPodcasts',$myPodcasts);
            $this->smarty->assign('success', $success);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->display('Smarty/templates/myPodcasts.tpl');
        }

        public function showError($string){
            $this->smarty->assign('string', $string);
            $this->smarty->display('error.tpl');
        }

        // public function showEditSuccess(){

        // }

        public function showForm($user, $categories){
            $this->smarty->assign('user', $user);
            $this->smarty->assign('categories', $categories);
            $this->smarty->display('Smarty/templates/createPodcast.tpl');
        }

        public function showSearchResults($user, $podcasts, $query){
            $this->smarty->assign('user', $user);
            $this->smarty->assign('podcasts', $podcasts);
            $this->smarty->assign('query', $query);
            $this->smarty->display('Smarty/templates/search.tpl');
        }
    }