<?php
require_once 'StartSmarty.php';
    class VPodcast{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showPodcastPage($podcast, $creator, $episodes, $userRole, $sub = null, $textalert = null, $success = null){

            $this->smarty->assign('podcast', $podcast);
            $this->smarty->assign('podcast_creator', $creator);
            $this->smarty->assign('episodes', $episodes);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->assign('userRole', $userRole);
            $this->smarty->assign('sub', $sub);
            $this->smarty->assign('success', $success);
            $this->smarty->display('Smarty/templates/podcast.tpl');

        }

        //metodo per mostrare modifiche/errori tramite alert nella pagina del podcast 
        public function showPodcastError($podcast, $creator,$episodes, $userRole, $textalert = null, $sub = null, $success = null){
            self::showPodcastPage($podcast, $creator, $episodes, $userRole, $textalert = null, $sub = null, $success = null);
        } 

        public function showMyPodcastPage($myPodcasts, $success = null, $textalert = null){
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

        public function showForm($categories){

            $this->smarty->assign('categories', $categories);
            $this->smarty->display('Smarty/templates/createPodcast.tpl');
        }
    }