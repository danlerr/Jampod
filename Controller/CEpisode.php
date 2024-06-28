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
        $view = new VPodcast();
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        
        if ($episode !== null) {
            $comments = FPersistentManager::getInstance()->retrieveCommentsOnEpisode($episode_id); // Array di commenti
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($episode, $comments, $avgVote); // Passa l'episodio, commenti e voto medio alla vista
        } else {
            $view->showEpisodeError("Impossibile trovare l'episodio");
        }
    } 
}

public static function voteEpisode($episode_id, $value) {
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $userId = USession::getInstance()->getSessionElement('user');       
        $vote = new EVote($value, $userId, $episode_id);
        $result = FPersistentManager::getInstance()->createObj($vote);
        
        if ($result) {
            // Recupera i voti aggiornati e calcola la media
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showAvgVoteUpdated($avgVote); // DA CONTROLLARE COSA RESTITUISCE 
        } else {
            $view->showVoteEpisodeError("Errore durante la votazione dell'episodio."); // DA CONTROLLARE COSA RESTITUISCE 
        }
    }
}



public static function updateVoteEpisode($vote_id, $newvalue) { 
    if (CUser::isLogged()) {
        $view = new VEpisode();
        $userId = USession::getInstance()->getSessionElement('user');
        $vote = FPersistentManager::getInstance()->retrieveObj('EVote', $vote_id); // Oggetto voto
        $check = FPersistentManager::getInstance()->checkUser((array)$vote, $userId);
        
        if ($check) {
            $update = FPersistentManager::getInstance()->updateObj($vote, 'value', $newvalue);
            
            if ($update) {
                $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($vote->getEpisodeId());
                $view->showAvgVoteUpdated($avgVote); // DA CONTROLLARE COSA RESTITUISCE 
            } else {
                $view->showVoteEpisodeError("Errore durante la votazione dell'episodio."); // DA CONTROLLARE COSA RESTITUISCE 
            }
        }
    }
}






}







