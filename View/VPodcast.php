<?php
    class VPodcast{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showPodcastPage($podcast, $imageInfo, $textalert = null){

            $this->smarty->assign('podcast_name', $podcast->getPodcastName);
            $this->smarty->assign('podcast_description', $podcast->getPodcastDescription);
            $this->smarty->assign('podcast_creator', $podcast->getUserId);
            $this->smarty->assign('podcast_category', $podcast->getPodcastCategory);
            $this->smarty->assign('mimetype', $imageInfo[0]);
            $this->smarty->assign('imagedata', $imageInfo[1]);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->display('podcast_page.tpl');

        }

        public function showPodcastError(){

        }

        public function showDeleteSuccess(){

        }

        public function showEditSuccess(){

        }

        public function showSubSuccess(){

        }

        public function showDeleteSubSuccess(){

        }

    }