<?php
    class CModeration{


        public static function showDashboard($podcast_id, $episode_id){
            $users = FPersistentManager::getInstance()->retrieveUsers();
            $podcasts = FPersistentManager::getInstance()->retrievePodcasts();
            $episodes = FPersistentManager::getInstance()->retrieveEpisodesByPodcast($podcast_id);
            $comments = FPersistentManager::getInstance()->commentAndReplies($episode_id);
            $view = new VModeration;
            $view->adminDashboard($users, $podcasts, $episodes, $comments);

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