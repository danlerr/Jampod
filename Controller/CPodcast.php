<?php

    class CPodcast{


        public static function createPodcast(){

            if (CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');

                $podcast = new EPodcast(UHTTPMethods::post('podcast_name'),
                                        UHTTPMethods::post('podcast_description'),
                                        $userId,
                                        UHTTPMethods::post('category'));

                $imageInfo = CFile::getImageInfo();
                if ($imageInfo){
                    $podcast->setImageData(CFile::getImageInfo()['imagedata']);
                    $podcast->setImageMimetype(CFile::getImageInfo()['imagemimetype']);
                }else{
                    $view->showErrorPage();
                }

                $result = FPersistentManager::getInstance()->createObj($podcast);

                if($result){
                    //$view->showPodcastPage();
                }else{
                    //$view->showErrorPage();
                }
            }
        }

        public static function deletePodcast($podcast_id){

            if(CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcast_id);

                if(FPersistentManager::getInstance()->checkUser($podcast, $userId)){

                    $result = FPersistentManager::getInstance()->deleteObj($podcast);

                    if($result){
                        
                        $view->showSuccess();
                    }else{
                        
                        $view->showErrorPage();
                    }
                }else{
                    $view->showErrorPage();
                }
            }
        }

        public static function visitPodcast($podcast_id){
            if (CUser::isLogged()){
                $view = new VPodcast;

                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);

                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $userRole = ($userId == $podcast->getUserId()) ? 'creator' : 'listener';
                $sub = (FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id));

                if($podcast!==null){
                    // Recupera la lista degli episodi associati al podcast
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);   

                    if ($userRole == 'creator'){                                           //
                        $view->showPodcast($podcast, $episodes, $userRole);               //controllo per la scelta del bottone 
                    }else{                                                               //da mostrare nella pagina del podcast 
                        $view->showPodcast($podcast, $episodes, $userRole, $sub);       //
                    }
                    
                }else{
                    $view->showErrorPage;
                }
            }
        }

        public static function editPodcast($podcast_id){

            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
                if ($podcast && $podcast->getUserId() == $userId) {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $field = UHTTPMethods::post('field'); // Nome del campo da aggiornare (es. 'podcast_name')
                        $value = UHTTPMethods::post('value'); // Nuovo valore del campo
        
                        $result = FPersistentManager::getInstance()->updateObj($podcast, $field, $value);
        
                        if ($result) {
                            $view->showSuccess("Podcast aggiornato con successo.");
                        } else {
                            $view->showError("Errore durante l'aggiornamento del podcast.");
                        }
                    } else {
                        $view->showEditForm($podcast);
                    }
                } else {
                    $view->showError("Podcast non trovato o non autorizzato.");
                }
            }
        }

        public static function searchPodcasts() {

        }

        public static function Subcribe($podcast_id){
            if (CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);

                if($podcast){
                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId,$podcast_id);
                    if (!$isSub){
                        $subscribe = new ESubscribe($podcast_id, $userId);

                        $result = FPersistentManager::getInstance()->createObj($subscribe);

                        $podcast->setSubcribe_counter(($podcast->getSubscribeCounter)+1);

                        if($result){
                            $view->showSucces(); //il bottone iscriviti diventa bottone iscritto
                        }else{
                            $view->showErrorPage(); //errore durante l'iscrizione 
                        }
                    }else{
                        $view->showErrorPage(); //sei già iscritto al podcast 
                    }
                }else{
                    $view->showErrorPage(); //podcast non trovato 
                }
            }
        }

        public static function deleteSub($subscribe_id,$podcast_id) {
            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
                if ($podcast) {
                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
                    if ($isSub) {
                        // Trova l'iscrizione esistente
                        $subscribe = FPersistentManager::getInstance()->retrieveObj('ESubscribe', $subscribe_id);
        
                        if ($subscribe) {
                            // Elimina l'iscrizione
                            $result = FPersistentManager::getInstance()->deleteObj($subscribe);
        
                            // Decrementa il contatore delle iscrizioni
                            $podcast->setSubscribeCounter($podcast->getSubscribeCounter() - 1);
        
                            if ($result) {
                                $view->showSucces(); // Il bottone iscritto diventa bottone iscriviti
                            } else {
                                $view->showErrorPage(); // Errore durante la rimozione dell'iscrizione
                            }
                        } else {
                            $view->showErrorPage(); // Iscrizione non trovata
                        }
                    } else {
                        $view->showErrorPage(); // Non sei iscritto al podcast
                    }
                } else {
                    $view->showErrorPage(); // Podcast non trovato
                }
            }
        }
    }
    
