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

        // Get audio info
        $audioInfo = CFile::getAudioInfo();
        if (is_array($audioInfo) && !empty($audioInfo['audiodata']) && !empty($audioInfo['audiomimetype'])) {
            $episode->setAudioData($audioInfo['audiodata']);
            $episode->setAudioMimetype($audioInfo['audiomimetype']);
        } else {
            $view->showPodcastError("Errore durante il caricamento dell'audio.");
            return;
        }

        // Get image info
        $imageInfo = CFile::getImageInfo();
        if (is_array($imageInfo) && !empty($imageInfo['imagedata']) && !empty($imageInfo['imagemimetype'])) {
            $episode->setImageData($imageInfo['imagedata']);
            $episode->setImageMimetype($imageInfo['imagemimetype']);
        } else {
            $view->showPodcastError("Errore durante il caricamento dell'immagine.");
            return;
        }

        // Create in db
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        $check = FPersistentManager::getInstance()->checkUser((array)$podcast, $userId); // Controllo che chi sta facendo l'upload dell'episodio sia il creatore del podcast
        if ($check) {
            $result = FPersistentManager::getInstance()->createObj($episode);

            if ($result) {
                $view->showPodcastPage(); // Rimanda alla pagina del podcast con l'episodio aggiunto
            } else {
                $view->showPodcastError('Impossibile effettuare il caricamento.');
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
        $check = FPersistentManager::getInstance()->checkUser((array)$episode, $userId); // Controllo che il creatore dell'episodio sia lo stesso che lo sta eliminando
        if ($check) {
            $result = FPersistentManager::getInstance()->deleteObj($episode); 
            
            if ($result) {
                $view->showPodcastPage();
                echo "Episodio eliminato correttamente.";
                return true;
            } else {
                $view->showPodcastError("Errore durante l'eliminazione dell'episodio");
                echo "Errore durante l'eliminazione dell'episodio.";
                return false;
            }
        } else {
            $view->showPodcastError("L'utente non ha il diritto di eliminare questo episodio.");
            echo "L'utente non ha il diritto di eliminare questo episodio.";
            return false;
        }
    } 
}

public static function visitEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        $podcast_id = $episode->getPodcastId();
        $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
        $podcast_title = $podcast->getPodcastName();
        $creatorId = $podcast->getUserId();
        $user = FPersistentManager::getInstance()->retrieveObj('EUser',$creatorId);
        $usernamecreator = $user->getUsername();
        
        if ($episode !== null) {
            $image = [$episode->getImageMimeType, $episode->getEncodedImageData()];
            $comments = FPersistentManager::getInstance()->retrieveCommentsOnEpisode($episode_id); // Array di commenti
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($episode,$podcast_title, $usernamecreator, $comments, $avgVote, $image); // Passa l'episodio, commenti ,voto medio e immagine alla vista
        } else {
            $view->showEpisodeError("Impossibile trovare l'episodio");
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
                
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($vote->getEpisodeId());
                $view->showEpisodePage();///???? oppure visit???
                return ['success' => true, 'avgVote' => $avgVote];
            } else {
                $view->showEpisodePage();///???? oppure visit???
                return ['success' => false, 'error' => 'Errore durante la votazione dell\'episodio.'];
            }
        } else {
            // L'utente non ha votato: creare un nuovo voto
            $vote = new EVote($value, $userId, $episode_id);
            $result = FPersistentManager::getInstance()->createObj($vote);
            
            if ($result) {
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
                $view->showEpisodePage();///???? oppure visit???
                return ['success' => true, 'avgVote' => $avgVote];
            } else {
                $view->showEpisodePage();///???? oppure visit???
                return ['success' => false, 'error' => 'Errore durante la votazione dell\'episodio.'];
            }
        }
    } else {
        return ['success' => false, 'error' => 'Utente non autenticato.'];
    }
}




}







