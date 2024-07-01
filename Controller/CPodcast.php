<?php

    class CPodcast{


        public static function createPodcast(){

            if (CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');//->getId();

                $podcast = new EPodcast(UHTTPMethods::post('podcast_name'),
                                        UHTTPMethods::post('podcast_description'),
                                        $userId,
                                        UHTTPMethods::post('category'));

                $imageInfo = CFile::getImageInfo();
                if ($imageInfo){
                    $podcast->setImageData(CFile::getImageInfo()['imagedata']);
                    $podcast->setImageMimetype(CFile::getImageInfo()['imagemimetype']);
                }else{
                    $view->showPodcastError();
                }

                $result = FPersistentManager::getInstance()->createObj($podcast);

                $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast->getId());

                $userRole ='creator';

                $success = 'true';

                if($result){
                    $view->showPodcastPage($podcast, $imageInfo, $episodes, "Podcast creato con successo!", $userRole, $success);
                }else{
                    $view->showPodcastError();
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

                    //$success = false;

                    if($result){
                        
                        $view->showMyPodcastPage();
                    }else{
                        
                        $view->showMyPodcastPage();
                    }
                }else{
                    $view->showMyPodcastPage();
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
                    $image = [$podcast->getImageMimeType, $podcast->getEncodedImageData()];

                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);   

                    if ($userRole == 'creator'){                                                             //
                        $view->showPodcastPage($podcast, $image, $episodes, $userRole, $sub);               //controllo per vedere se chi visita il podcast 
                    }else{                                                                                 //è il creatore di quel podcast  
                        $view->showPodcastPage($podcast, $image, $episodes, $userRole, $sub);             //
                    }
                    
                }else{
                    $view->showPodcastError();
                }
            }
        }

        // public static function editPodcast($podcast_id){

        //     if (CUser::isLogged()) {
        //         $view = new VPodcast;
        //         $userId = USession::getInstance()->getSessionElement('user');
        //         $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
        //         if ($podcast && $podcast->getUserId() == $userId) {
        //             if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //                 $field = UHTTPMethods::post('field'); // Nome del campo da aggiornare (es. 'podcast_name')
        //                 $value = UHTTPMethods::post('value'); // Nuovo valore del campo
        
        //                 $result = FPersistentManager::getInstance()->updateObj($podcast, $field, $value);
        
        //                 if ($result) {
        //                     $view->showEditSuccess("Podcast aggiornato con successo.");
        //                 } else {
        //                     $view->showPodcastError("Errore durante l'aggiornamento del podcast.");
        //                 }
        //             } else {
        //                 //$view->showEditForm($podcast);
        //             }
        //         } else {
        //             $view->showPodcastError("Podcast non trovato o non autorizzato.");
        //         }
        //     }
        // }

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
                            $view->showSubSuccess(); //il bottone iscriviti diventa bottone iscritto
                        }else{
                            $view->showPodcastError(); //errore durante l'iscrizione 
                        }
                    }else{
                        $view->showPodcastError(); //sei già iscritto al podcast 
                    }
                }else{
                    $view->showPodcastError(); //podcast non trovato 
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
                                $view->showDeleteSubSuccess(); // Il bottone iscritto diventa bottone iscriviti
                            } else {
                                $view->showPodcastError(); // Errore durante la rimozione dell'iscrizione
                            }
                        } else {
                            $view->showPodcastError(); // Iscrizione non trovata
                        }
                    } else {
                        $view->showPodcastError(); // Non sei iscritto al podcast
                    }
                } else {
                    $view->showPodcastError(); // Podcast non trovato
                }
            }
        }
    }
    
