<?php
    class CModeration{


        public static function showDashboard(){
            $users = FPersistentManager::getInstance()->retrieveUsers(); //array di oggetti
            if ($users){
            $view = new VModeration;
            $view->adminDashboard($users);

        }
}
        public static function showUserPodcasts($user_id){
            $podcasts = FPersistentManager::getInstance()->retrieveMyPodcasts($user_id); //array di array
            if ($podcasts){
                $view = new VModeration();
                $view->userPodcasts($podcasts);
        } 
}
        public static function showEpisodePodcasts($podcast_id) {
            $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id); //array di oggetti
            if ($episodes){
                $view = new VModeration();
                $view->podcastEpisodes($episodes);
        }
}
        public static function showEpisodeComments($episode_id) {
            $comments = FPersistentManager::getInstance()->commentAndReplies($episode_id);//array di oggetti
            if ($comments){
                $view = new VModeration();
                $view->episodeComments($comments);

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