<?php
class CEpisode {

//metodo per fare l'upload di un episodio in un podcast
public static function uploadEpisode($podcast_id)
{
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $user = FPersistentManager::getInstance()->retrieveObj(EUser::getEClass(), $userId);
        $episode = new EEpisode(UHTTPMethods::post('title'), UHTTPMethods::post('description'), $podcast_id);
        $audioInfo = CFile::getAudioInfo();
        if ($audioInfo) {
            $episode->setAudioData($audioInfo['audiodata']);
            $episode->setAudioMimetype($audioInfo['audiomimetype']);
        } else {
            $view->showErrorPage();
            return;
        }
        $imageInfo = CFile::getImageInfo();
        if ($imageInfo) {
            $episode->setImageData($imageInfo['imagedata']);
            $episode->setImageMimetype($imageInfo['imagemimetype']);
        } else {
            $view->showErrorPage();
            return;
        }
        $result = FPersistentManager::getInstance()->createObj($episode);
        
        if ($result) {
            $view->showPodcastPage(); //rimanda alla pagina del podcast con l'episodio aggiunto
        } else {
            $view->showErrorPage();
        }
    }
}
public static function deleteEpisode($episode_id) {
    
    if (CUser::isLogged()) {
        $view= new VPodcast();
        $userId = USession::getInstance()->getSessionElement('user');
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
        
        if (!$episode) {
            echo "Episodio non trovato.";
            return false;
        }
        $check = FPersistentManager::getInstance()->checkUser($episode, $userId);
        if ($check) {
            $result = FPersistentManager::getInstance()->deleteObj($episode); 
            
            if ($result) {
                
                $view->showPodcastPage();
                echo "Episodio eliminato correttamente.";
                return true;
            } else {
                $view->showErrorPage();
                echo "Errore durante l'eliminazione dell'episodio.";
                return false;
            }
        } else {
            $view->showErrorPage();
            echo "L'utente non ha il diritto di eliminare questo episodio.";
            return false;
        }
    } else {
        echo "Utente non loggato.";
        return false;
    }
}
public static function visitEpisode($episode_id) {
    if (CUser::isLogged()) {
        $view = new VPodcast();
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);        
        if ($episode !== null) {
            $comments = FPersistentManager::getInstance()->retrieveCommentsOnEpisode($episode_id); // array di commenti
            $avgVote = FPersistentManager::getInstance()->getAverageVoteOnEpisode($episode_id);
            $view->showEpisodePage($episode, $comments, $avgVote); // Passa l'episodio, commenti e voto medio alla vista
        } else {
            $view->showEpisodeError();
        }
    } 
    }



}
















