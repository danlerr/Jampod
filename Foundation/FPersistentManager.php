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
         * verify if exist a user with this username 
         * @param string $username
         */
        public static function verifyUserUsername($username){
            $result = FUser::verify('username', $username);

            return $result;
        }
                /**
             * verify if exist a user with this email 
             * @param string $email
             */
        public static function verifyUserEmail($email){
                $result = FUser::verify('email', $email);

                return $result;
            }


            
        //verifica che l'utente passato per parametro sia lo stesso che risulta dalla query di un determinato oggetto di cui è stato fatto il retrieve dal db.
        //( si suppone che $queryResult sia un array)
           
        public static function checkUser($queryResult, $idUser){
            if(FUser::userValidation($queryResult, $idUser)){
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

        public static function updatePassword($password, $oldHash, $newPassword, $user){
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);   //check password 
            if ($passwordHashed == $oldHash){
                $result = FPersistentManager::getInstance()->updateObj($user,'password', $newPassword);
                if ($result){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
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
                return array();
            }
        }
        public static function commentAndReplies($episode_id) {
            $commentAndReplies = FComment::getCommentAndReplies($episode_id);
            return $commentAndReplies;
        }
        public static function getAudioTrack($episode_id) {
            return FEpisode::retrieveAudioTrack($episode_id);
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
//verifica se esiste un voto da parte di un utente su un determinato episodio. Ritorna true se esiste, false altrimenti

        public static function checkVote($episode_id, $user_id) {
            $result = FVote::voteValidation($user_id, $episode_id);
            return $result;

        }
    

    //-------------------------------------PODCAST-----------------------------------------------------

        public static function retrieveEpisodesByPodcast($podcast_id){
            
            $episodes = FEpisode::retrieveMoreEpisodes($podcast_id);
            if($episodes){
                return $episodes;
            }else{
                return array();
            }
        }

        public static function isSubscribed($userId, $podcast_id){
            $result = FSubscribe::isSub($userId, $podcast_id);

            return $result ? true : false;
        }

        public static function retrieveSubscribe($userId, $podcastId){
            $sub = FSubscribe::retrieveSub($userId, $podcastId);
            if ($sub){
                return $sub;
            }else{
                return null;
            }
        }

        public static function retrieveNewPodcast(){
            $news = FPodcast::retrieveNewPods();
            // Codifica i dati binari dell'immagine in Base64
            foreach ($news as &$podcast) {                 //& modifica direttamente $myPodcast
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if ($news){
                return $news;
            }else{
                return null;
            }
        }

        public static function retrieveFeature(){
            $feature = FPodcast::retrieveFeaturePodcasts();
            // Codifica i dati binari dell'immagine in Base64
            if ($feature){
                foreach ($feature as &$podcast) {                 
                    $podcast['image_data'] = base64_encode($podcast['image_data']);
                    return $feature;
                }
            }else{
                return array();
            }
        }
        
        public static function retrieveRandomPodcasts(){
            $randomPodcasts = FPodcast::randomPodcasts();
            // Codifica i dati binari dell'immagine in Base64
            foreach ($randomPodcasts as &$podcast) {                 
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if ($randomPodcasts){
                return $randomPodcasts;
            }else{
                return null;
            }
        }

        public static function retrieveMyPodcasts($user_id){
            $myPodcasts = FPodcast::myPodcasts($user_id);
            // Codifica i dati binari dell'immagine in Base64
            foreach ($myPodcasts as &$podcast) {                 
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if ($myPodcasts){
                return $myPodcasts;
            }else{
                return array();
            }
        }

        //-------------------------------------CATEGORIE-----------------------------------------------------
        public static function retrieveCategories(){ 
            $categories = FPodcast::allCategories();
            if ($categories){
                return $categories;
            }else{
                return null;
            }
        }  
        
        public static function retrievePodByCategory($category_name){
            $result = FPodcast::retrieveBycategory($category_name);
            // Codifica i dati binari dell'immagine in Base64
            foreach ($result as &$podcast) {                 
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if($result){
                return $result;
            }else{
                return array();
            }

        }

        //-------------------------------------DONATION-----------------------------------------------------
        public static function retrieveDonationsReceived($userId){ //metodo che a partire dall' userId restituisce 
            $donations=FDonation::retrieveDonationsReceived($userId);     //tutte le donazioni fatte a quell'utente
            return is_array($donations) ? $donations : []; //per assicurarmi che ritorni un array
            
        }
        
        public static function retrieveDonationsMade($userId) {
            try {
                $donations = FDonation::retrieveDonationsMade($userId);
                if (is_array($donations)) {
                    return $donations;
                } else {
                    return [];
                }
            } catch (Exception $e) {
                error_log("Error retrieving donations made by user with ID $userId: " . $e->getMessage());
                return []; // Ritorno di un array vuoto in caso di errore
            }
        }
    

        //-------------------------------------CREDIT CARD-----------------------------------------------------
        public static function retrieveUserCreditCards($userId) {               ///forse da cancellare
            try {
                $creditCards = FCreditCard::retrieveOwnedCreditCards($userId);
        
                if ($creditCards !== null) {
                    return $creditCards;
                } else {
                    return []; // Ritorna un array vuoto se non ci sono carte di credito trovate
                }
            } catch (PDOException $e) {
                error_log("PDOException in retrieveUserCreditCards: " . $e->getMessage());
                return []; // In caso di errore, ritorna un array vuoto
            }
        }

        //-------------------------------------COMMENT-----------------------------------------------------
        public static function retrieveComments($episode_id){   //metodo che ritorna tutti i commenti di un episodio
            $comments=FComment::retrieveMoreComments($episode_id);
            return $comments;
        }
}

            
