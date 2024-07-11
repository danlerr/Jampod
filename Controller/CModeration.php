<?php
    class CModeration{


        public static function showDashboard(){
            $adminId = USession::getInstance()->getSessionElement('user');
            $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $adminId);
            if ($admin->isAdmin()){
                $users = FPersistentManager::getInstance()->retrieveUsers(); //array di oggetti
                if ($users){
                $view = new VModeration;
                $view->adminDashboard($users);
                }
            }else{
                $view = new VModeration;
                $view->showError('Non sei admin!');
            }
        }
        public static function showUserPodcasts($user_id){
            $adminId = USession::getInstance()->getSessionElement('user');
            $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $adminId);
            if ($admin->isAdmin()){
                $podcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($user_id); //array di array
                $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
                $view = new VModeration;
                if ($podcasts){
                    
                    $view->userPodcasts($user, $podcasts);
                } else {
                    $view->userPodcasts($user,[]);
                }
            }else{
                $view = new VModeration;
                $view->showError('Non sei admin!');
            }
}
        public static function showEpisodePodcasts($podcast_id) {
            $adminId = USession::getInstance()->getSessionElement('user');
            $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $adminId);
            if ($admin->isAdmin()){
                $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); //array di oggetti
                $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast', $podcast_id);
                    $view = new VModeration;
                if ($episodes){
                    
                    $view->podcastEpisodes($podcast, $episodes);
                }else {
                    $view->podcastEpisodes($podcast,[]);
                }
            }else{
                $view = new VModeration;
                $view->showError('Non sei admin!');
            }

}
        public static function showEpisodeComments($episode_id) {
            $adminId = USession::getInstance()->getSessionElement('user');
            $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $adminId);
            if ($admin->isAdmin()){
                $comments = FPersistentManager::getInstance()->retrieveComments($episode_id);//array di oggetti
                $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode', $episode_id);
                $view = new VModeration;
                if ($comments){
                    
                    $view->episodeComments($episode, $comments);

                }else {
                $view->episodeComments($episode,[]);
                }
            }else{
                $view = new VModeration;
                $view->showError('Non sei admin!');
            }
        }
        public static function deleteUser($user_id){

            if (CUser::isLogged()){
    

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->isAdmin()){
                    $user = FPersistentManager::getInstance()->retrieveObj('EUser',$user_id);
                    FPersistentManager::getInstance()->deleteObj($user);
                    $view = new VRedirect();
                    $view->redirect("/Jampod/Moderation/showDashboard");
                } else {
                    $view = new VUser();
                    $view->showError("Non hai il diritto di compiere questa operazione");
                }
            }
        
        }


        public static function deletePodcast($podcast_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->isAdmin()){
                    $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcast_id);
                    FPersistentManager::getInstance()->deleteObj($podcast);
                    $view = new VRedirect();
                    $view->redirect("/Jampod/Moderation/showDashboard");
                }else {
                    $view = new VUser();
                    $view->showError("Non hai il diritto di compiere questa operazione");
                }
            }
        }

        public static function deleteEpisode($episode_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->isAdmin()){
                    $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode',$episode_id);
                    FPersistentManager::getInstance()->deleteObj($episode);
                    $view = new VRedirect();
                    $view->redirect("/Jampod/Moderation/showDashboard");
                } else {
                    $view = new VUser();
                    $view->showError("Non hai il diritto di compiere questa operazione");
                }
            }
        }

        public static function deleteComment($comment_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->isAdmin()){
                    $comment = FPersistentManager::getInstance()->retrieveObj('EComment',$comment_id);
                    FPersistentManager::getInstance()->deleteObj($comment);
                    $view = new VRedirect();
                    $view->redirect("/Jampod/Moderation/showDashboard");
                } else {
                    $view = new VUser();
                    $view->showError("Non hai il diritto di compiere questa operazione");
                }
            }
        }
    }