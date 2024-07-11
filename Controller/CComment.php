<?php

class CComment{

    /**
     * Create a comment taking info from the compiled form and associate it to the post
     * @param int $episodeId Refers to the id of the episode
     * @param int|null $parentCommentId Refers to the id of the parent comment (if any)
     * 
     * // Per creare un commento normale
     *CComment::createComment($episodeId);

     * // Per creare un commento in risposta a un altro commento
     *CComment::createComment($episodeId, $parentCommentId);
     */

    public static function createComment($episodeId, $parentCommentId = null) {
        
        $userId = USession::getInstance()->getSessionElement('user');
        $comment = new EComment(UHTTPMethods::post('body'), $userId, $episodeId);
        

        if ($parentCommentId !== null) {
            $comment->setParentCommentId($parentCommentId);
        }

        $result = FPersistentManager::getInstance()->createObj($comment);
        if ($result) {
            $view=new VRedirect();
            $view->redirect('/Jampod/Episode/visitEpisode/' . $episodeId);

            
        } else {
            $view = new VEpisode();
            $view-> showError("Impossibile creare il commento");
            
        }
    }
    
    public static function deleteComment($comment_id){
        $userId=USession::getInstance()->getSessionElement('user');
        $comment=FPersistentManager::getInstance()->retrieveObj('EComment',$comment_id);
        $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode',$comment->getEpisodeId());
        $view = new VEpisode();   
        // Controlla se l'utente ha il permesso di eliminare il commento
        $check = FPersistentManager::getInstance()->checkUser($comment->getUserId(), $userId);
        if (!$check)  {
            $view->showError("Non hai il diritto di eliminare questo commento");
            return;
        }else{
            $result=FPersistentManager::getInstance()->deleteObj($comment);
            if ($result) {
                $view=new VRedirect();
                $view->redirect('/Jampod/Episode/visitEpisode/' . $episode->getId());
            
            } else {
            $view->showError("Impossibile eliminare il commento");
            
            }
        }
    }

}