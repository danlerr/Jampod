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

                if($podcast!==null){
                    // Recupera la lista degli episodi associati al podcast
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);   //metodo da fare in FEpisode
                    $view->showPodcast($podcast, $episodes);
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

        public static function searchPodcasts() {}
    }
    
