<?php

class CHome {
    public static function homePage() {            //letsgo
        if(CUser::isLogged()){

            $view = new VHome();
            $userId = USession::getSessionElement('user');

            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
            
            $username = $user->getUsername();
            
            // Recupera i podcast in evidenza
            $featuredPodcasts = FPersistentManager::getInstance()->retrieveFeature();
            
            // Recupera le categorie
            $categories = FPersistentManager::getInstance()->retrieveCategories();
            
            // Recupera le novità
            $newPodcasts = FPersistentManager::getInstance()->retrieveNewPodcast();
            
            // Recupera i podcast consigliati
            $recommendedPodcasts = FPersistentManager::getInstance()->retrieveRandomPodcasts();

            
            
            
            $view->showHome($username, $featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts);
        } else{
            CUser::loginForm();
        }
    }

    public static function visitCategory($category_name){            //letsgo
        if (CUser::isLogged()){
            
            $category_podcasts = FPersistentManager::getInstance()->retrievePodByCategory($category_name);
            //print_r($category_podcasts);
            if ($category_podcasts){
                $view = new VHome;
                $view->showCategory($category_name, $category_podcasts);
            }
        }
    }


}