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


            
        //verifica dell'uguaglianza degli utenti passati per parametro
           
        public static function checkUser($objectUserId, $idUser){
            if(FUser::userValidation($objectUserId, $idUser)){
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

        public function retrieveUsers(){
            $users = FUser::retrieveAll();
            return $users;
        }

        
       //-------------------------------------FILE VALIDATION-----------------------------------------------------
        public static function validateImage($file)
        {
        

        if (!is_uploaded_file($file['tmp_name'])) {
            return [false, 'Impossibile eseguire l\'upload del file.'];
        }

        if ($file['size'] > imageMaxSize) {
            return [false, 'File troppo grande! Dimensione massima consentita: ' . (imageMaxSize / 1024 / 1024) . ' MB'];
        }

        if (!in_array($file['type'], allowedImageTypes)) {
            return [false, 'Tipo di file non supportato. Sono ammessi solo file immagine di tipo JPEG o PNG.'];
        }

        return [true, null];
    }

        public static function validateAudio($file)
        {
            
        
            if (!is_uploaded_file($file['tmp_name'])) {
                return [false, 'Impossibile eseguire l\'upload del file.'];
            }
        
            if ($file['size'] > audioMaxSize) {
                return [false, 'File troppo grande! Dimensione massima consentita: ' . (audioMaxSize / 1024 / 1024) . ' MB'];
            }
        
            if (!in_array($file['type'], allowedAudioTypes)) {
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
        //calcola e restituisce il voto medio in un episodio
        public static function getAverageVoteOnEpisode($episode_id) {
            $votesOnEpisode = FVote::retrieveVotesOnEpisode($episode_id); //funzione per prendere tutti i voti di un episodio
        
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
//verifica se esiste un voto da parte di un utente su un determinato episodio. Il risultato è  true se esiste, insieme all'oggetto voto, false altrimenti

        public static function checkVote($episode_id, $user_id) {
            $result = FVote::voteValidation($user_id, $episode_id);
            return $result;

        }
        //controllo del valore del voto, deve essere da 1 a 5
        public static function checkVoteValue($value) {
            if ($value>0 and $value<=5) {
                return true;
        } else {
            return false;
        }
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
            foreach($feature as &$podcast){
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if ($feature){
                return $feature;
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

        public static function searchPodcasts($query){
            $result = FPodcast::search($query);
            foreach ($result as &$podcast) {                 
                $podcast['image_data'] = base64_encode($podcast['image_data']);
            }
            if ($result){return $result;}else{return array();}
        }

        public function retrievePodcasts(){
            $podcasts = FPodcast::retrieveAll();
            return $podcasts;
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
        
        public static function donationsMade($userId) {
            $donations = FDonation::retrieveDonationsMade($userId);
            
            foreach ($donations as &$donation) {
                $recipientUser = FPersistentManager::getInstance()->retrieveObj('EUser', $donation['recipient_id']);
                if ($recipientUser) {
                    $donation['recipientUsername'] = $recipientUser->getUsername(); // Aggiungiamo il nome utente del destinatario come chiave nell'array donazione
                }
            }
            
            return $donations;
        }

        public static function donationsReceived($userId){
            $donations = FDonation::retrieveDonationsReceived($userId);
            foreach ($donations as &$donation) {
                $senderUser = FPersistentManager::getInstance()->retrieveObj('EUser', $donation['sender_id']);
                if ($senderUser) {
                    $donation['senderUsername'] = $senderUser->getUsername(); 
                }
            }
            
            return $donations;
        }

        

        //-------------------------------------COMMENT-----------------------------------------------------
        public static function retrieveComments($episode_id){   //metodo che ritorna tutti i commenti di un episodio
            $comments=FComment::retrieveMoreComments($episode_id);
            
            return $comments;
            
        }


            
        //-------------------------------------SUBSCRIBE-----------------------------------------------------
        public static function getSubscribers($podcast_id){
            $subs = FSubscribe::getAllSubscribed($podcast_id);
            if ($subs){
                return $subs;
            }else{
                return array();
            }
        }
    
        //-------------------------------------CREDIT CARDS-----------------------------------------------------
        public static function retrieveMyCreditCards($user_id) {
            $cards = FCreditCard::retrieveOwnedCreditCards($user_id);
            if ($cards){
                return $cards;

            } else {
                return array();
            }
            
        }

        public static function maskCreditCardNumber ($cardNumber) {    //metodo che fa visualizzare solo le ultime 4 cifre di una carta
            return str_repeat('*', strlen($cardNumber) - 4) . substr($cardNumber, -4);  //di credito per motivi di sicurezza
        }

    }