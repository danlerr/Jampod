<?php
class CHome {
    public static function homePage() {
        $view = new VHome();
        
        // Recupera i podcast in evidenza
        $featuredPodcasts = FPersistentManager::getInstance()->retrieveFeature();
        
        // Recupera le categorie
        $categories = FPersistentManager::getInstance()->retrieveCategories();
        
        // Recupera le novità
        $newPodcasts = FPersistentManager::getInstance()->retrieveNewPodcast();
        
        // Recupera i podcast consigliati
        $recommendedPodcasts = FPersistentManager::getInstance()->retrieveRandomPodcasts();
        
        $view->showHome($featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts);
    }
}