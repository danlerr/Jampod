<?php
require_once 'StartSmarty.php';
    class VDonation{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showDonationForm($recipient_id){
            $this->smarty->assign('recipient_id',$recipient_id);
            $this->smarty->display('Smarty/templates/donation.tpl');
        }
        
        /**
         * Mostra una conferma di successo dopo aver effettuato una donazione.
         *
         * @param string $message Il messaggio di successo da visualizzare.
         */
        public function showDonationSuccess($message) {
            $this->smarty->assign('success_message', $message);
            $this->smarty->display('/Smarty/templates/donation.tpl');
        }
            
        /**
         * Mostra una conferma di successo dopo aver effettuato una donazione.
         *
         * @param string $message Il messaggio di successo da visualizzare.
         */
        public function showDonationErrorView($message) {
            $this->smarty->assign('error_message', $message);
            $this->smarty->display('/Smarty/templates/donation.tpl');
        }

        public function showAllDonations($balance,$allDonations){
            $this->smarty->assign('balance',$balance);
            $this->smarty->assign('donations',$allDonations);
            $this->smarty->display('/Smarty/templates/balance.tpl');

        }
            
        

        






    
    }