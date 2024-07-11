<?php
    class CModeration{


        public static function showDashboard(){
            $user_id = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
            if ($user->isAdmin()){
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
            $user_id = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
            if ($user->isAdmin()){
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
            $user_id = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
            if ($user->isAdmin()){
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
            $user_id = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
            if ($user->isAdmin()){
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
                if ($admin->is_admin()){
                    $user = FPersistentManager::getInstance()->retrieveObj('EUser',$user_id);
                    FPersistentManager::getInstance()->deleteObj($user);
                    header("");
                }
            }
        }

        public static function banUser($user_id){
            if (CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->is_admin()){
                    $user = FPersistentManager::getInstance()->retrieveObj('EUser', $user_id);
                    $ban = FPersistentManager::getInstance()->updateObj($user, 'ban', true);   //true oppure 1?
                    FPersistentManager::getInstance()->deleteObj($user);
                    header("");
                }
            }
        }

        public static function deletePodcast($podcast_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->is_admin()){
                    $podcast = FPersistentManager::getInstance()->retrieveObj('EPodcast',$podcast_id);
                    FPersistentManager::getInstance()->deleteObj($podcast);
                    header("");
                }
            }
        }

        public static function deleteEpisode($episode_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->is_admin()){
                    $episode = FPersistentManager::getInstance()->retrieveObj('EEpisode',$episode_id);
                    FPersistentManager::getInstance()->deleteObj($episode);
                    header("");
                }
            }
        }

        public static function deleteComment($comment_id){            

            if(CUser::isLogged()){

                $admin_id = USession::getInstance()->getSessionElement('user');
                $admin = FPersistentManager::getInstance()->retrieveObj('EUser', $admin_id);
                if ($admin->is_admin()){
                    $comment = FPersistentManager::getInstance()->retrieveObj('EComment',$comment_id);
                    FPersistentManager::getInstance()->deleteObj($comment);
                    header("");
                }
            }
        }
    }