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
            VComment::commentCreatedView();
        } else {
            VComment::commentErrorView();
        }
    }

    public static function deleteComment($comment_id){
        $userId=USession::getInstance()->getSessionElement('user');
        $comment=FPersistentManager::getInstance()->retrieveObj('EComment',$comment_id);
        if ($comment === null) {
            VComment::commentErrorView("Comment not found.");
            return;
        }
    
        // Controlla se l'utente ha il permesso di eliminare il commento : deve essere un admin o l'utente che ha scritto il commento
        if ($comment->getUserId() !== $userId && !(FPersistentManager::getInstance()->retrieveObj('EUser',$userId)->isAdmin())) {
            VComment::commentErrorView("Unauthorized action.");
            return;
        }
        
        $result=FPersistentManager::getInstance()->deleteObj($comment);
        if ($result) {
            VComment::commentDeletedView();
        } else {
            VComment::commentErrorView("Failed to delete comment");
        }

    }
}