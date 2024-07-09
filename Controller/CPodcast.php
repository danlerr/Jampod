<?php

    class CPodcast{


        public static function createPodcast(){       //letsgo

            if (CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');//->getId();

                $podcast = new EPodcast(UHTTPMethods::post('podcast_name'),
                                        UHTTPMethods::post('podcast_description'),
                                        $userId,
                                        UHTTPMethods::post('category_name'));

                $imageInfo = CFile::getImageInfo();
                if ($imageInfo){
                    $podcast->setImageData((CFile::getImageInfo()['imagedata']));
                    $podcast->setImageMimetype(CFile::getImageInfo()['imagemimetype']);
                }else{
                    $view->showError("Problemi con il caricamento dell'immagine di copertina :(");
                }

                $result = FPersistentManager::getInstance()->createObj($podcast);

                $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast->getId()); //forse non serve, quando viene creato un podcast non ha episodi 

                $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $userId)->getUsername();

                $userRole ='creator';

                if($result){
                    $view->showPodcastPage($podcast, $creator, $episodes, $userRole, "Podcast creato con successo! :)", null, true);
                }else{
                    $view->showError('Impossibile creare il podcast :('); 
                }
            }
        }

        public static function deletePodcast($podcast_id){            //letsgo

            if(CUser::isLogged()){
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcast_id);

                if(FPersistentManager::getInstance()->checkUser($podcast->getUserId(), $userId)){

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
                }
            }else{
                $view = new VPodcast;
                $view->showError('Registrati :/');
            }
        }

        public static function visitPodcast($podcast_id){            //letsgo
            if (CUser::isLogged()){
                $view = new VPodcast;

                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
                $userId = USession::getInstance()->getSessionElement('user');
                $creator_id = $podcast->getUserId();
                $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $creator_id);
                $userRole = ($userId == $podcast->getUserId()) ? 'creator' : 'listener';
                $sub = (FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id));

                if($podcast!==null){

                    // Recupera la lista degli episodi associati al podcast
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); 
                    if (!is_array($episodes)) {
                        $episodes = [$episodes];
                    }
                    $view->showPodcastPage($podcast, $creator, $episodes, $userRole, $sub);             
                }else{
                    $view->showError('impossibile trovare il podcast :('); 
                }
            }
        }

        public static function searchPodcasts() {            //letsgo
            $query = UHTTPMethods::post('query');
            $podcasts = FPersistentManager::getInstance()->searchPodcasts($query);
            $view = new VPodcast;
            if ($podcasts){
                $view->showSearchResults($podcasts, $query);
                echo $podcasts;
            } else {
                // Gestisci il caso in cui non c'è nessuna query di ricerca
                $view = new VPodcast;
                $view->showError('nessun risultato! :(');
            }
        }

        public static function Subscribe($podcast_id) {            //letsgo
            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');
                $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);

        
                if ($podcast) {
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
                    $userRole = 'listener';

                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);  //vedere se issub funziona 

                    if ($isSub === false) {

                        $subscribe = new ESubscribe($podcast_id, $userId);
                        $result = FPersistentManager::getInstance()->createObj($subscribe);
        
                        if ($result) {

                            $oldSubCount = $podcast->getSubscribeCounter();
                            $newSubCount = $oldSubCount + 1;
                            $podcast->setSubcribe_counter($newSubCount);
                            $update = FPersistentManager::getInstance()->updateObj($podcast, 'subscribe_counter', $newSubCount); 
                            
                            if ($update){
                                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
                                $view->showPodcastPage($podcast, $creator, $episodes, $userRole, true, 'Iscrizione avvenuta con successo! :)', true);

                            }else{
                                error_log("Errore nell'aggiornamento del contatore di iscritti.");
                                $view->showPodcastError($podcast, $episodes, $creator, "Errore durante l'iscrizione al podcast :(", $userRole, false);
                            }
                        } else {
                            $view->showPodcastError($podcast, $episodes, $creator, "Errore durante l'iscrizione al podcast :(", $userRole, false);
                        }
                    }else{
                        self::visitPodcast($podcast_id); // Se l'utente è già iscritto, semplicemente mostra il podcast
                    }
                } else {
                    $view->showError("impossibile effettuare l'iscrizione al podcast :(");
                }
            }
        }

        public static function Unsubscribe($podcast_id) {            //letsgo
            if (CUser::isLogged()) {
                $view = new VPodcast;
                $userId = USession::getInstance()->getSessionElement('user');
                $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $userId);
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        
                if ($podcast) {
                    $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
                    $userRole = 'listener';

                    $isSub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
        
                    if ($isSub) {
                        $sub = FPersistentManager::getInstance()->retrieveSubscribe($userId, $podcast_id);
                        $unsubscribe = FPersistentManager::getInstance()->deleteObj($sub);
        
                        if ($unsubscribe) {
                            $oldSubCount = $podcast->getSubscribeCounter();
                            $newSubCount = $oldSubCount - 1;
                            $update = FPersistentManager::getInstance()->updateObj($podcast, 'subscribe_counter', $newSubCount);
        
                            if ($update) {

                                $view->showPodcastPage($podcast, $creator, $episodes, $userRole, false, 'Non sei più iscritto! :(', false);
                            } else {
                                $view->showError("Errore durante l'aggiornamento del contatore delle iscrizioni");
                            }
                        } else {
                            $view->showError("Errore durante la rimozione dell'iscrizione");
                        }
                    } else {
                        self::visitPodcast($podcast_id); // Se l'utente non è iscritto, mostra comunque il podcast
                    }
                } else {
                    $view->showError("Impossibile trovare il podcast");
                }
            }
        }

        public static function myPodcast(){            //letsgo
            if (CUser::isLogged()){
                $userId = USession::getInstance()->getSessionElement('user');
                $view = new VPodcast;
                $myPodcast = FPersistentManager::getInstance()->retrieveMyPodcasts($userId);
                //print_r($myPodcast);
                $view->showMyPodcastPage($myPodcast);
            }
        }

        public static function creationForm(){            //letsgo
            if (Cuser::isLogged()){
                $view = new VPodcast;
                $categories = FPersistentManager::getInstance()->retrieveCategories(); //prendo le categorie per passarle al form 
                $view->showForm($categories);
            }
        }
    }
    
