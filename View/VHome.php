<?php
    require_once 'C:\xampp\htdocs\Jampod\StartSmarty.php';
    class VHome{

        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }
    
        public function show404(){
            $this->smarty -> display('Smarty/templates/404.tpl');
            
        }

        public function showHome($username, $featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts){
            $this->smarty->assign('username', $username);
            $this->smarty->assign('featuredPodcasts',$featuredPodcasts);
            $this->smarty->assign('categories',$categories);
            $this->smarty->assign('newPodcasts',$newPodcasts);
            $this->smarty->assign('recommendedPodcasts',$recommendedPodcasts); 

            $this->smarty->display('Smarty/templates/home.tpl');
            
        }
    }