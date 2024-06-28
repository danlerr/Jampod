<?php
    
    class FPersistentManager{

        private static $instance;

        private function __construct(){

        }

        public static function getInstance()
        {
            if (!self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        //----------------------------------CRUD------------------------------------------

        //C
        public static function createObj($obj){
            $fclass = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$fclass, "createObject"], $obj);
            return $result;
        }

        //R
        public static function retrieveObj($eclass, $id){

            $fclass = "F" . substr($eclass, 1);                               
            $result = call_user_func([$fclass,"retrieveObject"], $id);
            return $result;
        }

        //U
        public function updateObj($obj, $field, $value){
            $class = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$class, "updateObject"], $obj, $field, $value);         
            return $result;
        }

        //D
        public function deleteObj($obj){
            $class = "F" . substr(get_class($obj), 1);
            $result = call_user_func([$class, "deleteObject"], $obj->getId());
            return $result;
        }

     
        //----------------------------------------------USER-----------------------------------------------


        /**
         * verify if exist a user with this username (also mod)
         * @param string $username
         */
        public static function verifyUserUsername($username){
            $result = FUser::verify('username', $username);

            return $result;
        }
                /**
             * verify if exist a user with this email (also mod)
             * @param string $email
             */
        public static function verifyUserEmail($email){
                $result = FUser::verify('email', $email);

                return $result;
            }
            //verifica che l'utente passato per parametro sia lo stesso che risulta dalla query di un determinato oggetto di cui è stato fatto il retrieve dal db
        public static function checkUser($queryResult, $idUser){
            if(FUser::userValdiation($queryResult, $idUser)){
                return true;
            }else{
                return false;
            }
        }
        
        public static function retriveUserOnUsername($username)
        {
            $result = FUser::getUserByUsername($username);

            return $result;
        }

       //-------------------------------------FILE VALIDATION-----------------------------------------------------
        public static function validateImage($file)
        {
        $imageMaxSize = 2 * 1024 * 1024; // 2 MB ??????
        $allowedImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!is_uploaded_file($file['tmp_name'])) {
            return [false, 'Impossibile eseguire l\'upload del file.'];
        }

        if ($file['size'] > $imageMaxSize) {
            return [false, 'File troppo grande! Dimensione massima consentita: ' . ($imageMaxSize / 1024 / 1024) . ' MB'];
        }

        if (!in_array($file['type'], $allowedImageTypes)) {
            return [false, 'Tipo di file non supportato. Sono ammessi solo file immagine di tipo JPEG o PNG.'];
        }

        return [true, null];
    }

        public static function validateAudio($file)
        {
            $audioMaxSize = 200 * 1024 * 1024; // 200 MB ?????
            $allowedAudioTypes = ['audio/mpeg', 'audio/wav'];
        
            if (!is_uploaded_file($file['tmp_name'])) {
                return [false, 'Impossibile eseguire l\'upload del file.'];
            }
        
            if ($file['size'] > $audioMaxSize) {
                return [false, 'File troppo grande! Dimensione massima consentita: ' . ($audioMaxSize / 1024 / 1024) . ' MB'];
            }
        
            if (!in_array($file['type'], $allowedAudioTypes)) {
                return [false, 'Tipo di file non supportato. Sono ammessi solo file audio di tipo MP3 o WAV.'];
            }
        
            return [true, null];
        }

       //-------------------------------------EPISODE-----------------------------------------------------
        public static function retrieveCommentsOnEpisode($episode_id) {
            $comments = FComment::retrieveMoreComments($episode_id);
            if ($comments !== null){
                return $comments;
            }
            else {
                return null;
            }
        }
    //-------------------------------------VOTE-----------------------------------------------------

        public static function getAverageVoteOnEpisode($episode_id) {
            $votesOnEpisode = FVote::retrieveVotesOnEpisode($episode_id);
        
            if (empty($votesOnEpisode)) {
                return 0; // O è il valore che indichi che non ci sono voti
            }
        
            $values = array_map(function($vote) { //il valore dei voti sono estratti in un nuovo array
                return $vote->getValue();
            }, $votesOnEpisode);
        
            $sum = array_sum($values);
            $count = count($values);
        
            $avgVote = $sum / $count; // media
            return round($avgVote, 1); //arrotondata
        }
    

    //-------------------------------------PODCAST-----------------------------------------------------

        public static function retrieveEpisodesByPodcast($podcast_id){
            
            $podcasts = FEpisode::retrieveMoreEpisodes($podcast_id);
            if($podcasts!== null){
                return $podcasts;
            }else{
                return null;
            }
        }
        public static function isSubscribed($userId, $podcast_id){
            $result = FSubscribe::isSub($userId, $podcast_id);
            if($result){
                return true;
            }else{
                return false;
            }
        }
}

            
