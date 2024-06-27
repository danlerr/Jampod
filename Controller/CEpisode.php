<?php
class CEpisode {

//metodo per fare l'upload di un episodio in un podcast
public static function uploadEpisode($podcast_id){
    if(CUser::isLogged()){
        $view = new VPost();
        $userId = USession::getInstance()->getSessionElement('user');
        $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass() ,$userId);


        $episode = new EEpisode(UHTTPMethods::post('title'), UHTTPMethods::post('description'), $podcast_id);   
        $checkresult =FPersistentManager::getInstance()->createObj($episode);
        if ($checkresult) {





        }
        

      



    
    }





















}

}