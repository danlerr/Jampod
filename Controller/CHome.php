<?php
class CHome {
    public static function homePage() {
        $view = new VHomePage();
        
        // Recupera i podcast in evidenza
        $featuredPodcasts = FPersistentManager::getInstance()->retrieveFeaturedPodcasts();
        
        // Recupera le categorie
        $categories = FPersistentManager::getInstance()->retrieveCategories();
        
        // Recupera le novità
        $newPodcasts = FPersistentManager::getInstance()->retrieveNewPodcasts();
        
        // Recupera i podcast consigliati
        $recommendedPodcasts = FPersistentManager::getInstance()->retrieveRecommendedPodcasts();
        
        $view->showHomePage($featuredPodcasts, $categories, $newPodcasts, $recommendedPodcasts);
    }
}