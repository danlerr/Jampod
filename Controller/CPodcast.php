<?php

    class CPodcast{


        public static function createPodcast(){

            if (CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');//->getId();

                $podcast = new EPodcast(UHTTPMethods::post('podcast_name'),
                                        UHTTPMethods::post('podcast_description'),
                                        $userId,
                                        UHTTPMethods::post('category_name'));

                $imageInfo = CFile::getImageInfo();
                if ($imageInfo){
                    $podcast->setImageData(CFile::getImageInfo()['imagedata']);
                    $podcast->setImageMimetype(CFile::getImageInfo()['imagemimetype']);
                }else{
                    $view->showError("Problemi con il caricamento dell'immagine di copertina :(");
                }

                $result = FPersistentManager::getInstance()->createObj($podcast);

                $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast->getId()); //forse non serve, quando viene creato un podcast non ha episodi 

                $userRole ='creator';

                $success = 'true';

                if($result){
                    $view->showPodcastPage($podcast, $imageInfo, $episodes, $userRole, "Podcast creato con successo! :)", $success);
                }else{
                    $view->showError('Impossibile creare il podcast :('); 
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
                        $myPodcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                        $success = true;
                        $textalert = 'eliminazione del podcast avvenuta con successo :)';
                        $view->showMyPodcastPage($myPodcasts, $success, $textalert);
                    }else{
                        $myPodcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                        $success = false;
                        $textalert = "problemi con l'eliminazione del podcast :(";
                        $view->showMyPodcastPage($myPodcasts, $success, $textalert);
                    }
                }else{
                    $view->showError('Registrati :/');
                }
            }
        }

        public static function visitPodcast($podcast_id){
            if (CUser::isLogged()){
                $view = new VPodcast;

                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);

                $userId = USession::getInstance()->getSessionElement('user');
                $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();
                $userRole = ($userId == $podcast->getUserId()) ? 'creator' : 'listener';
                $sub = (FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id));

                if($podcast!==null){
                    // Recupera la lista degli episodi associati al podcast
                    $image = [$podcast->getImageMimeType(), $podcast->getEncodedImageData()];

                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);   

                    if ($userRole == 'creator'){                                                                       //
                        $view->showPodcastPage($podcast, $creator, $image, $episodes, $userRole);                     //controllo per vedere se chi visita il podcast 
                    }else{                                                                                           //è il creatore di quel podcast  
                        $view->showPodcastPage($podcast, $creator, $image, $episodes, $userRole, $sub);             //
                    }
                    
                }else{
                    $view->showError('impossibile trovare il podcast :(');
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

        public static function Subscribe($podcast_id) {
            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
                if ($podcast) {
                    $image = [$podcast->getImageMimeType(), $podcast->getEncodedImageData()];
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
                    $userRole = 'listener';
        
                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
                    if (!$isSub) {
                        $subscribe = new ESubscribe($podcast_id, $userId);
                        $result = FPersistentManager::getInstance()->createObj($subscribe);
        
                        if ($result) {
                            $newSubCount = $podcast->setSubscribeCounter($podcast->getSubscribeCounter() + 1);
                            FPersistentManager::getInstance()->updateObj($podcast, 'subscribe_counter', $newSubCount); // Assicurati di avere una funzione di aggiornamento per il contatore di iscrizioni
                            self::visitPodcast($podcast_id);
                        } else {
                            $success = false;
                            $view->showPodcastError($podcast, $image, $episodes, "Errore durante l'iscrizione al podcast :(", $userRole, $success);
                        }
                    } else {
                        self::visitPodcast($podcast_id); // Se l'utente è già iscritto, semplicemente mostra il podcast
                    }
                } else {
                    $view->showError("impossibile effettuare l'iscrizione al podcast :(");
                }
            }
        }

        public static function Unsubscribe($subscribe_id, $podcast_id) {
            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user')->getId();
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
                if ($podcast) {
                    $image = [$podcast->getImageMimeType(), $podcast->getEncodedImageData()];
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
                    $userRole = 'listener';
        
                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
                    if ($isSub) {
                        $subscribe = FPersistentManager::getInstance()->retrieveObj('ESubscribe', $subscribe_id);
                        $result = FPersistentManager::getInstance()->deleteObj($subscribe);
        
                        if ($result) {
                            $newSubCount = $podcast->setSubscribeCounter($podcast->getSubscribeCounter() - 1);
                            FPersistentManager::getInstance()->updateObj($podcast, 'subscribe_counter', $newSubCount); // Assicurati di avere una funzione di aggiornamento per il contatore di iscrizioni
                            self::visitPodcast($podcast_id);
                        } else {
                            $success = false;
                            $view->showPodcastError($podcast, $image, $episodes, "Errore durante la cancellazione dell'iscrizione al podcast", $userRole, $success);
                        }
                    } else {
                        self::visitPodcast($podcast_id); // Se l'utente non è iscritto, semplicemente mostra il podcast
                    }
                } else {
                    $view->showError("impossibile eliminare l'iscrizione al podcast");
                }
            }
        }

        public static function myPodcast(){
            if (CUser::isLogged()){
                $userId = USession::getInstance()->getSessionElement('user');
                $view = new VPodcast;
                $myPodcast = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                //print_r($myPodcast);
                $view->showMyPodcastPage($myPodcast);
            }
        }

        public static function creationForm(){
            if (Cuser::isLogged()){
                $view = new VPodcast;
                $categories = FPersistentManager::getInstance()->retrieveCategories(); //prendo le categorie per passarle al form 
                $view->showForm($categories);
            }
        }
    }
    
