<?php
    require_once 'StartSmarty.php';
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

        public function showCategory($category_name, $category_podcasts){   //da prendere category_name giù 
            $this->smarty->assign('category_name', $category_name);
            $this->smarty->assign('category_podcasts', $category_podcasts);
            $this->smarty->display('Smarty/templates/category.tpl');
        }
    }