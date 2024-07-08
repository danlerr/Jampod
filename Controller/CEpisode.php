<?php
class CEpisode {

public static function creationEpisodeForm($podcast_id) {
    if (Cuser::isLogged()){
        $view = new VEpisode;
        $view->showCreationForm($podcast_id);
    }

}

//metodo per fare l'upload di un episodio in un podcast
public static function uploadEpisode($podcast_id)
{
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        $sub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
        $check = FPersistentManager::getInstance()->checkUser($podcast->getUserId(), $userId); // Controllo che chi sta facendo l'upload dell'episodio sia il creatore del podcast
        
        if ($check) {
            $episode = new EEpisode(
                UHTTPMethods::post('title'),
                UHTTPMethods::post('description'),
                $podcast_id
            );
            $episodesbefore = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
            $userRole ='creator';
            $creatorId = $podcast->getUserId();
            $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $creatorId) -> getUsername();
            
            // Get audio info
            $audioInfo = CFile::getAudioInfo();
            if ($audioInfo) {
                $episode->setAudioData($audioInfo['audiodata']);
                $episode->setAudioMimetype($audioInfo['audiomimetype']);
            } else { 
                $view->showError("Errore durante il caricamento dell'audio");
                return;
            }

            // Get image info
            $imageInfo = CFile::getImageInfo();
            if ($imageInfo) {
                $episode->setImageData($imageInfo['imagedata']);
                $episode->setImageMimetype($imageInfo['imagemimetype']);
            } else {
                $view->showError("Errore durante il caricamento dell'immagine");
                return;
            }

            // Create in db
            $result = FPersistentManager::getInstance()->createObj($episode);
            
            if ($result) {         
                $episodesupdated = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); // Recupera la lista degli episodi aggiornata associati al podcast 
                $view->showPodcastPage($podcast, $creator , $episodesupdated, $userRole, $sub, "Episodio aggiunto con successo", true); // Rimanda alla pagina del podcast con l'alert di conferma e l'episodio aggiunto
            } else {      
                $view->showPodcastError($podcast, $creator , $episodesbefore,  $userRole,$sub,"Impossibile effettuare il caricamento dell'episodio", false); // Rimanda alla pagina del podcast con l'alert di errore aggiunta
            }
        }
    }
}


//metodo per cancellare un episodio
public static function deleteEpisode($episode_id)
{
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $check = FPersistentManager::getInstance()->checkUser((array)$episode, $userId); // Controllo che il creatore dell'episodio sia lo stesso che lo sta eliminando
        

        if ($check) {
            $userRole ='creator';
            $podcast_id = $episode->getPodcastId();
            $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
            $creatorId = $podcast->getUserId();
            $creator = FPersistentManager::getInstance()->retrieveObj('EUser', $creatorId) -> getUsername();
            $episodesbefore = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
            $sub = FPersistentManager::getInstance()->isSubscribed($userId, $podcast_id);
            
            $result = FPersistentManager::getInstance()->deleteObj($episode); 
            
            if ($result) {
                $episodesupdated = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); // Recupera la lista degli episodi aggiornata associati al podcast       
                $view->showPodcastPage($podcast, $creator , $episodesupdated, $userRole, $sub, "Episodio eliminato con successo", true); 
            } else {
                $view->showPodcastError($podcast, $creator , $episodesbefore,  $userRole,$sub,"Impossibile eliminare l'episodio", false);
            }
        } 
    } 
}


public static function visitEpisode($episode_id) {  //{$episode->getId()} in data-episode-id="" in episode.tpl
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $userId = USession::getInstance()->getSessionElement('user');
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $episode->getPodcastId());
        $usernamecreator= FPersistentManager::getInstance()->retrieveObj('EUser',$podcast->getUserId())->getUsername();
        $checkvotearray = FPersistentManager::getInstance()->checkVote($episode_id, $userId); //ritorna un array [true,oggetto vote] se l'utente ha già votato, altrimenti [false ,null]
        if ($checkvotearray[0]) {
            $votevalue = $checkvotearray[1] -> getValue();
        } else {
            $votevalue = 0; //se l'utente non ha votato il valore del voto è 0 e le stelle saranno vuote
        }
        if ($episode !== null) {
            $episodeimage = [$episode->getImageMimeType(), $episode->getEncodedImageData()];
            $commentAndReplies = FPersistentManager::getInstance()->commentAndReplies($episode_id); // Array di commenti e risposte
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($episode,$podcast, $usernamecreator, $commentAndReplies, $votevalue, $avgVote, $episodeimage); 
            // Passa l'episodio,  podcast e username del creator, commenti e risposte ,voto medio, valore del voto dell'utente e immagine episodio alla vista
        } else {
            $view->showError("Impossibile trovare l'episodio");
        }
    } 
}

public static function listenEpisode($episode_id) {
    $view = new VHome;
    $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id); 
    $episode->setEpisodeStreams($episode->getEpisode_streams() + 1); //incrementa gli ascolti dell'episodio

    //recupero della traccia e passaggio al broswer
    $audioTrack = FPersistentManager::getAudioTrack($episode_id); //ritorna un array con ['audiodata', 'audiomimetype']

    if (!$audioTrack) { //se $audiotrack non restituisce dati
        $view->show404();
        return;
    }

    // Imposta l'header Content-Type per il tipo MIME dell'audio
    header('Content-Type: ' . $audioTrack['audiomimetype']);
    header('Content-Length: ' . strlen($audioTrack['audiodata'])); // Imposta la lunghezza del contenuto
    // Restituisci i dati dell'audio al broswer direttamente come blob
    echo $audioTrack['audiodata'];
}


//permette all'utente di votare o di aggiornare il proprio voto 
public static function voteEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $value = UHTTPMethods::post('rating');
        $userId = USession::getInstance()->getSessionElement('user');
        $checkvotearray = FPersistentManager::getInstance()->checkVote($episode_id, $userId); //ritorna un array [true,oggetto vote] se l'utente ha già votato, altrimenti [false ,null]
        if ($checkvotearray[0]) {
            // L'utente ha già votato: aggiornare il voto esistente
            $vote = $checkvotearray[1];
            $update = FPersistentManager::getInstance()->updateObj($vote, 'value', $value);
            
            if ($update) {  
                self::visitEpisode($episode_id);  //mostra la pagina dell'episodio (con il voto aggiornato)       
            } else {
                $view->showError("Impossibile modificare la votazione");
                
            }
        } else {
            // L'utente non ha votato: creare un nuovo voto
            $vote = new EVote($value, $userId, $episode_id);
            $result = FPersistentManager::getInstance()->createObj($vote);
            
            if ($result) {
                self::visitEpisode($episode_id); //mostra la pagina dell'episodio(con il voto impostato)
               
            } else {
                $view->showError("Impossibile caricare la votazione");
            }
        }
    } 
}




}







