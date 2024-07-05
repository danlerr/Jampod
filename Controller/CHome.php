<?php
class CHome {
    public static function homePage() {
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
    }
}