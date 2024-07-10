<?php
require_once 'StartSmarty.php';
    class VBalance{

        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showBalance($usersession,$balance, $donationsReceived, $donationsMade, $textalert = null, $success = false){
            $this->smarty->assign('username', $usersession->getUsername());
            $this->smarty->assign('balance', $balance);
            $this->smarty->assign('donationsReceived', $donationsReceived);
            $this->smarty->assign('donationsMade', $donationsMade);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->assign('success', $success);
            $this->smarty->display('Smarty/templates/balance.tpl');
        }

        public function showError($string){
            $this->smarty->assign('string', $string);
            $this->smarty->display('error.tpl');
        }





    }