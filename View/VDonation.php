<?php
require_once 'StartSmarty.php';
    class VDonation{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showDonation($recipient_id, $podcast_creator, $textalert = null, $success = false){
            $this->smarty->assign('recipient_id', $recipient_id);
            $this->smarty->assign('creator', $podcast_creator);
            $this->smarty->assign('success', $success);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->display('Smarty/templates/donation.tpl');
        }
        
        public function showError($string) {
            $this->smarty->assign('error_message', $string);
            $this->smarty->display('Smarty/templates/error.tpl');
        }

        // public function showAllDonations($balance,$allDonations){
        //     $this->smarty->assign('balance',$balance);            //da mettere in saldo 
        //     $this->smarty->assign('donations',$allDonations);
        //     $this->smarty->display('Smarty/templates/balance.tpl');

        // }
            
        

        






    
    }