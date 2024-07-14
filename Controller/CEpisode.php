<?php
class CEpisode {

//metodo per avere la form di creazione dell'episodio
public static function creationEpisodeForm($podcast_id) {
    if (Cuser::isLogged()){
        $view = new VEpisode;
        $view->showCreationForm($podcast_id);
    }

}

//metodo per eseguire l'upload di un episodio in un podcast
public static function uploadEpisode($podcast_id)
{
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
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
            $creator = FPersistentManager::getInstance()->retrieveObj('EUser',  $podcast->getUserId());
            
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
                
                $view->showPodcastPage($usersession, $podcast, $creator , $episodesupdated,"creator", $sub, "Episodio aggiunto con successo", true); // Rimanda alla pagina del podcast con l'alert di conferma e l'episodio aggiunto
                
                // Recupera gli utenti iscritti al podcast
                $subscribes = FPersistentManager::getInstance()->getSubscribers($podcast_id);
                
                
                // Invia una email di notifica a ciascun iscritto
                foreach ($subscribes as $subscribe) {
                    $subscriber = FPersistentManager::getInstance()->retrieveObj('EUser', $subscribe->getSubscriberid());
                    $subject = "Nuovo episodio del podcast: " . $podcast->getPodcastName();
                    $message = "<p>Un nuovo episodio è stato aggiunto al podcast " . $podcast->getPodcastName() . ".</p>
                                <p>Titolo episodio: " . $episode->getEpisode_title() . "</p>
                                <p>Descrizione: " . $episode->getEpisode_description() . "</p>";
                                //<p> link:  /Jampod/Episode/visitEpisode/" . $episode->getId(). "</p>" ;
                    $mailer = CMail::getInstance();
                    $mailer->sendMail($subscriber->getEmail(), $subject, $message);
                }
            } else {     
                
                $view->showPodcastPage($usersession, $podcast, $creator , $episodesbefore, "creator",$sub,"Impossibile effettuare il caricamento dell'episodio", false); // Rimanda alla pagina del podcast con l'alert di errore aggiunta
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
        $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
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
                $view->showPodcastPage($usersession, $podcast, $creator , $episodesupdated, "creator", $sub, "Episodio eliminato con successo", true); 
            } else {
                $view->showPodcastPage($usersession, $podcast, $creator , $episodesbefore, "creator ",$sub,"Impossibile eliminare l'episodio", false);
            }
        } 
    } 
}

//metodo per visualizzare un episodio insieme alle sue votazioni, ascolti e commenti
public static function visitEpisode($episode_id) {  
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $userId = USession::getInstance()->getSessionElement('user');
        $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        if (!$episode) {
            $view->showError("Impossibile trovare l'episodio :(");
        }
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $episode->getPodcastId());
        $creator= FPersistentManager::getInstance()->retrieveObj('EUser',$podcast->getUserId());
        $checkvotearray = FPersistentManager::getInstance()->checkVote($episode_id, $userId); //ritorna un array [true,oggetto vote] se l'utente ha già votato, altrimenti [false ,null]
        if ($checkvotearray[0]) {
            $votevalue = $checkvotearray[1] -> getValue();
        } else {
            $votevalue = 0; //se l'utente non ha votato il valore del voto è 0 e le stelle saranno vuote
        }
        if ($episode !== null) {
            $commentAndReplies = FPersistentManager::getInstance()->commentAndReplies($episode_id); // Array di commenti e risposte
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $votevalue, $avgVote); 
            // Passa l'utente in sessione,l'episodio,  podcast e username del creator, commenti e risposte ,voto medio, valore del voto dell'utente
        } 
    } 
}
//metodo per restituire al broswer i dati della traccia e impostare il content-type/lenght
public static function listenEpisode($episode_id) {
    $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id); 

    //recupero della traccia e passaggio al broswer
    $audioTrack = FPersistentManager::getAudioTrack($episode_id); //ritorna un array con ['audiodata', 'audiomimetype']

    if (!$audioTrack) { //se $audiotrack non restituisce dati
        $view = new VHome;
        $view->show404();
        return;
    }

    // Imposta l'header Content-Type per il tipo MIME dell'audio
    $view = new VRedirect();
    $view->setHeader('Content-Type: ' . $audioTrack['audiomimetype']);
    $view->setHeader('Content-Length: ' . strlen($audioTrack['audiodata']));
    
    // Restituisci i dati dell'audio al broswer direttamente come blob
    echo $audioTrack['audiodata'];
}
//metodo per incrementare il numero di ascolti
public static function incrementEpisodeStreams($episode_id) {
    $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id); 
    if ($episode) {
        $streams = $episode->getEpisode_streams() + 1;
        FPersistentManager::getInstance()->updateObj($episode, 'episode_streams', $streams); // Aggiorna l'oggetto episodio nel database
        return true;
    }
    return false;
}


//metodo per permettere all'utente di votare o di aggiornare il proprio voto 
public static function voteEpisode($episode_id) {
    if (CUser::isLogged()) { 
        $view = new VEpisode();
        $userId = USession::getInstance()->getSessionElement('user');
        $usersession = FPersistentManager::getInstance()->retrieveObj("EUser", $userId);
        $value = UHTTPMethods::post('rating');
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $episode->getPodcastId());
        $creator= FPersistentManager::getInstance()->retrieveObj('EUser',$podcast->getUserId());
        
        $commentAndReplies = FPersistentManager::getInstance()->commentAndReplies($episode_id); // Array di commenti e risposte
        $checkvotearray = FPersistentManager::getInstance()->checkVote($episode_id, $userId); //ritorna un array [true,oggetto vote] se l'utente ha già votato, altrimenti [false ,null]
        if ($checkvotearray[0]) {
            // L'utente ha già votato: aggiornare il voto esistente
            $vote = $checkvotearray[1];
            $update = FPersistentManager::getInstance()->updateObj($vote, 'value', $value);
            
            if ($update) {  
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $value, $avgVote, "Voto aggiornato :D", true);      
            } else {
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $value, $avgVote, "Impossibile modificare la votazione :(", false);
                
            }
        } else {
            
            // L'utente non ha votato: creare un nuovo voto
            if (FPersistentManager::getInstance()->checkVoteValue($value)) {
            $vote = new EVote($value, $userId, $episode_id);
            $result = FPersistentManager::getInstance()->createObj($vote);
            
            if ($result) {
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $value, $avgVote, "Grazie per aver votato :D", true);     
               
            } else {
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $value, $avgVote, "Impossibile inserire la votazione :(", false);
            }
        } else {
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($usersession,$episode,$podcast, $creator, $commentAndReplies, $value, $avgVote, "Inserire un voto valido :(", false); 
        }

    } 
}
}



}







