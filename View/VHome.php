<?php
    class VHome{

        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }
    
        public function show404($string){
            $this->smarty->assign('string',$string);
        }

        public function showHome($featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts){
            $this->smarty->assign('featuredPodcasts',$featuredPodcasts);
            $this->smarty->assign('categories',$categories);
            $this->smarty->assign('newPodcasts',$newPodcasts);
            $this->smarty->assign('recommendedPodcasts',$recommendedPodcasts); 

            $this->smarty->display('Smarty/templates/home.tpl');
            
        }
    }