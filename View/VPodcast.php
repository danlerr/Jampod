<?php
    class VPodcast{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showPodcastPage($podcast, $imageInfo, $episodes, $userRole, $textalert = null, $sub = null, $success = null){

            $this->smarty->assign('podcast_name', $podcast->getPodcastName);
            $this->smarty->assign('podcast_description', $podcast->getPodcastDescription);
            $this->smarty->assign('podcast_creator', $podcast->getUserId);
            $this->smarty->assign('podcast_category', $podcast->getPodcastCategory);
            $this->smarty->assign('mimetype', $imageInfo[0]);
            $this->smarty->assign('imagedata', $imageInfo[1]);
            $this->smarty->assign('episodes', $episodes);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->assign('userRole', $userRole);
            $this->smarty->assign('sub', $sub);
            $this->smarty->assign('success', $success);
            $this->smarty->display('Smarty/templates/podcast.tpl');

        }

        //metodo per mostrare modifiche/errori tramite alert nella pagina del podcast 
        public function showPodcastError($podcast, $imageInfo,$episodes, $userRole, $textalert = null, $sub = null, $success = null){
            self::showPodcastPage($podcast, $imageInfo,$episodes, $userRole, $textalert = null, $sub = null, $success = null);
        } 

        public function showMyPodcastPage($myPodcasts, $success = null, $textalert = null){
            $this->smarty->assign('userPodcasts',$myPodcasts);
            $this->smarty->assign('success', $success);
            $this->smarty->assign('textalert', $textalert);
            
        }

        public function showError($string){
            $this->smarty->assign('string', $string);
            $this->smarty->display('error.tpl');
        }

        // public function showEditSuccess(){

        // }

        public function showForm(){}
    }