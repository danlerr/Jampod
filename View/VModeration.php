<?php
require_once 'StartSmarty.php';
    class VModeration{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function adminDashboard($users, $podcasts, $episodes, $comments){
            $this->smarty->assign('users', $users);
            $this->smarty->assign('podcasts', $podcasts);
            $this->smarty->assign('episodes', $episodes);
            $this->smarty->assign('comments', $comments);
            $this->smarty->display('Smarty/templates/admin.tpl');
        }
    }