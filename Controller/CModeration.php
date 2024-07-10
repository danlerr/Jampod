<?php
    class CModeration{

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

        public static function deleteEpisode($episode_id){

            if (CUser::isLogged()) {
                $view = new VPodcast();
                $userId = USession::getInstance()->getSessionElement('user');
                $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
                $podcast_id = $episode->getPodcastId();
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
                $check = FPersistentManager::getInstance()->checkUser($podcast->getUserId(), $userId); // Controllo che il creatore dell'episodio sia lo stesso che lo sta eliminando
                

                if ($check) {
                    
                    $creatorId = $podcast->getUserId();
                    $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $creatorId);
                    $episodesbefore = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
                    $sub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
                    
                    $result = FPersistentManager::getInstance()->deleteObj($episode); 
                    
                    if ($result) {
                        $episodesupdated = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); // Recupera la lista degli episodi aggiornata associati al podcast 
                        $view->showPodcastPage($podcast, $creator , $episodesupdated, "creator", $sub, "Episodio eliminato con successo", true); 
                    } else {
                        $view->showPodcastError($podcast, $creator , $episodesbefore, "creator ",$sub,"Impossibile eliminare l'episodio", false);
                    }
                } 
            }
        }
        
    }