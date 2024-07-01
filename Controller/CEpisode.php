<?php
class CEpisode {

//metodo per fare l'upload di un episodio in un podcast
public static function uploadEpisode($podcast_id)
{
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $episode = new EEpisode(
            UHTTPMethods::post('title'),
            UHTTPMethods::post('description'),
            $podcast_id
        );
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        $episodesbefore = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
        $userRole ='creator';
        $podcastimage = [$podcast->getImageMimeType, $podcast->getEncodedImageData()];

        // Get audio info
        $audioInfo = CFile::getAudioInfo();
        if (is_array($audioInfo) && !empty($audioInfo['audiodata']) && !empty($audioInfo['audiomimetype'])) {
            $episode->setAudioData($audioInfo['audiodata']);
            $episode->setAudioMimetype($audioInfo['audiomimetype']);
        } else { 
                $view->showNotfound();
                return;
            }
        // Get image info
        $imageInfo = CFile::getImageInfo();
        if (is_array($imageInfo) && !empty($imageInfo['imagedata']) && !empty($imageInfo['imagemimetype'])) {
            $episode->setImageData($imageInfo['imagedata']);
            $episode->setImageMimetype($imageInfo['imagemimetype']);
        } else {
                $view->showNotFound();
                return;
            }
        // Create in db
        $check = FPersistentManager::getInstance()->checkUser((array)$podcast, $userId); // Controllo che chi sta facendo l'upload dell'episodio sia il creatore del podcast
        
        if ($check) {
            $result = FPersistentManager::getInstance()->createObj($episode);           
            if ($result) {         
                $episodesupdated = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); // Recupera la lista degli episodi aggiornata associati al podcast 
                $view->showPodcastPage($podcast,$podcastimage, $episodesupdated, "Episodio aggiunto con successo", $userRole, true); // Rimanda alla pagina del podcast con l'alert di conferma e l'episodio aggiunto
            } else {      
                $view->showPodcastError($podcast, $podcastimage, $episodesbefore, "Impossibile effettuare il caricamento dell'episodio", $userRole, false); // Rimanda alla pagina del podcast con l'alert di errore aggiunta
            }
        }
    }
}

//metodo per cancellare un episodio
public static function deleteEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $podcast_id = $episode->getPodcastId();
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        $podcastimage = [$podcast->getImageMimeType, $podcast->getEncodedImageData()];
        $episodesbefore = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);

        $check = FPersistentManager::getInstance()->checkUser((array)$episode, $userId); // Controllo che il creatore dell'episodio sia lo stesso che lo sta eliminando
        if ($check) {
            $result = FPersistentManager::getInstance()->deleteObj($episode); 
            
            if ($result) {
                $episodesupdated = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); // Recupera la lista degli episodi aggiornata associati al podcast       
                $view->showPodcastPage($podcast,$podcastimage, $episodesupdated, 'Episodio eliminato correttamente', 'creator', true);
            } else {
                $view->showPodcastError($podcast,$podcastimage, $episodesbefore, "Impossibile eliminare l'episodio", 'creator', false);

            }
        } 
    } 
}

public static function visitEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $episode->getPodcastId());
        $podcast_title = $podcast->getPodcastName();
        $creatorId = $podcast->getUserId();
        $usercreator= FPersistentManager::getInstance()->retrieveObj('EUser',$creatorId);
        $usernamecreator = $usercreator->getUsername();
        
        if ($episode !== null) {
            $episodeimage = [$episode->getImageMimeType, $episode->getEncodedImageData()];
            $comments = FPersistentManager::getInstance()->retrieveCommentsOnEpisode($episode_id); // Array di commenti
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($episode,$podcast_title, $usernamecreator, $comments, $avgVote, $episodeimage); // Passa l'episodio, commenti ,voto medio e immagine alla vista
        } else {
            $view->showNotFound();
        }
    } 
}
//???????????
public static function listenEpisode($episode_id) {
    $audioTrack = FPersistentManager::getAudioTrack($episode_id);

    if (!$audioTrack) {
        http_response_code(404);
        echo 'Traccia audio non trovata';
        return;
    }

    // Imposta l'header Content-Type per il tipo MIME dell'audio
    header('Content-Type: ' . $audioTrack['audiomimetype']);

    // Restituisci i dati dell'audio direttamente come blob
    echo $audioTrack['audiodata'];
}


//???????????




//permette all'utente di votare o di aggiornare il proprio voto 
public static function voteEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $value = UHTTPMethods::post('rating');
        $userId = USession::getInstance()->getSessionElement('user');
        $checkarray = FPersistentManager::getInstance()->checkVote($episode_id, $userId);
        
        if ($checkarray[0]) {
            // L'utente ha già votato: aggiornare il voto esistente
            $vote = $checkarray[1];
            $update = FPersistentManager::getInstance()->updateObj($vote, 'value', $value);
            
            if ($update) {  
                self::visitEpisode($episode_id);         
            } else {
                $view->showNotFound("Impossibile modificare la votazione");
                
            }
        } else {
            // L'utente non ha votato: creare un nuovo voto
            $vote = new EVote($value, $userId, $episode_id);
            $result = FPersistentManager::getInstance()->createObj($vote);
            
            if ($result) {
                self::visitEpisode($episode_id);
               
            } else {
                $view->shotNotFound();
            }
        }
    } 
}




}







