<?php
    require_once 'StartSmarty.php';
    class VUser{
        
        private $smarty;

        public function __construct(){

            $this->smarty = StartSmarty::configuration();
    
        }

        public function showLoginForm(){
            $this->smarty->display('Smarty/templates/login.tpl');
        }
        
        public function showRegistrationForm(){
            $this->smarty->display('Smarty/templates/registration.tpl');
        }

        public function showError($string){
            $this->smarty->assign('string', $string);

            $this->smarty->display('Smarty/templates/error.tpl');
        }

        public function profile($podcasts, $user, $isAdmin){
            $this->smarty->assign('podcasts', $podcasts);
            $this->smarty->assign('user', $user);
            $this->smarty->assign('isAdmin', $isAdmin);
            $this->smarty->display('Smarty/templates/profile.tpl');
        }

        

        public function settings($username, $isAdmin, $email, $textalert = null, $success = true){
            $this->smarty->assign('username', $username);
            $this->smarty->assign('isAdmin', $isAdmin);
            $this->smarty->assign('email', $email);
            $this->smarty->assign('textalert', $textalert);
            $this->smarty->assign('success', $success);
            $this->smarty->display('Smarty/templates/settings.tpl');
        }

        public function creationCreditCardForm(){
            $this->smarty->display('Smarty/templates/creditcard.tpl');
        }
        
        public function showUserCards($username, $cards, $textAlert, $success) {
            if (!is_array($cards)) {
               $cards = []; // Ensure $cards is an array
             }
            $this->smarty->assign('username', $username);
            $this->smarty->assign('cards', $cards);
            $this->smarty->assign('textalert', $textAlert);
            $this->smarty->assign('success', $success);
            $this->smarty->assign('card_count', count($cards));
            $this->smarty->display('Smarty/templates/creditcard.tpl');
        }
    }