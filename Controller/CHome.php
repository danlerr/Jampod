<?php

class CHome {
    //La funzione homePage() recupera gli i podcast da inserire nelle varie sezioni e mostra la home page
    public static function homePage() {            //letsgo
        if(CUser::isLogged()){
            

            $view = new VHome();
            $userId = USession::getSessionElement('user');

            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            
            $username = $user->getUsername();
            $isAdmin = $user->isAdmin();
            
            // Recupera i podcast in evidenza
            $featuredPodcasts = FPersistentManager::getInstance()->retrieveFeature();
            
            // Recupera le categorie
            $categories = FPersistentManager::getInstance()->retrieveCategories();
            
            // Recupera le novità
            $newPodcasts = FPersistentManager::getInstance()->retrieveNewPodcast();
            
            // Recupera i podcast consigliati
            $recommendedPodcasts = FPersistentManager::getInstance()->retrieveRandomPodcasts();


            
            
            
            $view->showHome($username, $isAdmin, $featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts);
        } else{
            CUser::loginForm();
        }
    }
    //La funzione visitCategory($category_name) prende e mostra tutti i podcast di una determinata categoria
    public static function visitCategory($category_name){            
        if (CUser::isLogged()){
            
            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            $category_podcasts = FPersistentManager::getInstance()->retrievePodByCategory($category_name);
            //print_r($category_podcasts);
            if ($category_podcasts){
                $view = new VHome;
                $view->showCategory($user, $category_name, $category_podcasts);
            }
        }
    }
    //La funzione About() mostra la sezione con le informazioni del sito
    public static function About() {
        $userId = USession::getInstance()->getSessionElement('user');
        $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
        $view = new VHome();
        $view->showAbout($user);

    }


}