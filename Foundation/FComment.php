<?php
/**
 * La classe FComment gestisce le operazioni di persistenza relative ai commenti.
 */
class FComment{
    
    private static $table="comment";
    private static $value="(NULL,:comment_text,:comment_creation_date,:user_id,:episode_id,:parent_comment_id,:commentUsername)";
    private static $key="comment_id";

    
    public static function getTable(){
        return self::$table;
    }
    public static function getValue(){
        return self::$value;
    }
    public static function getClass(){
        return self::class;
    }

    public static function getKey(){
        return self::$key;
    }
    
    /**
     * Associa i valori dei campi del commento ai placeholder nella query SQL.
     * @param PDOStatement $stmt L'oggetto PDOStatement.
     * @param EComment $comment L'oggetto commento.
     */

    public static function bind($stmt, $comment){
        $stmt->bindValue(":comment_text", $comment->getCommentText(), PDO::PARAM_STR);
        $stmt->bindValue(":comment_creation_date", $comment->getCommentTime()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(":episode_id", $comment->getEpisodeId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $comment->getUserId(), PDO::PARAM_INT); 
        $stmt->bindValue(":parent_comment_id", $comment->getParentCommentId(), PDO::PARAM_INT);
        $stmt->bindValue(":commentUsername", FUser::getUserUsername($comment->getUserId()), PDO::PARAM_STR); 
        
    }


    public static function createObject($obj) :bool{            //metodo per "salvare" un oggetto comment dal DB

        $ObjectCommentId = FDataBase::getInstance()->create(self::class, $obj);  //il metodo create restituisce l'd del commento
        if($ObjectCommentId !== null){
            $obj->setCommentId($ObjectCommentId);
            return true;
        }else{
            return false;
        }
    }

    
    public static function retrieveObject($id){                //metodo per recuperare un oggetto dal DB, ritorna un oggetto della classe EComment
        $result = FDataBase::getInstance()->retrieve(self::getTable(), self::getKey(), $id); 
        if(count($result) > 0){
            $comment = self::createEntity($result);
            return $comment;
        }else{
            return null;
        }
    }

    public static function updateObject($obj, $field, $fieldValue){            //metodo per aggiornare un oggetto user dal DB

        $result = FDatabase::getInstance()->update(self::getTable(), $field, $fieldValue, self::getKey(),$obj->getId());
        if($result){
            return true;
        }else{
         return false;
        }
    }
    

    public static function deleteObject($id){                //metodo per eliminare un oggetto comment dal DB
        
        $result = FDatabase::getInstance()->delete(self::getTable(), self::getKey(), $id);
        if($result){
            return true;
        }else{
         return false;
        }
    }

    //
    public static function createEntity($queryResult) {
        $comments = array();
    
        foreach ($queryResult as $result) {
            $comment = new EComment($result['comment_text'], $result['user_id'], $result['episode_id']);
            $comment->setCommentId($result['comment_id']);
            $comment->setCommentUsername($result['commentUsername']);
            
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $result['comment_creation_date']);
            $comment->setCommentCreationTime($dateTime);
            
            if (!is_null($result['parent_comment_id'])) {
                $comment->setParentCommentId($result['parent_comment_id']);
            }
            
            $comments[] = $comment;
        }
    
        // Restituisce un singolo oggetto commento se c'è un solo elemento nell'array
        if (count($comments) === 1) {
            return $comments[0];
        }
    
        // Restituisce un array di commenti se ci sono più elementi nell'array
        return $comments;
    }

    

        // Metodo che permette di prendere dal db tutti i commenti dato un episodio. Ritorna un array di commenti 
        public static function retrieveMoreComments($episode_id) {
            $result = FDataBase::getInstance()->retrieve(self::getTable(), FEpisode::getKey(), $episode_id); 
            if (count($result) > 0) {
                $comments = self::createEntity($result);
                if (!is_array($comments)) {
                    $comments = [$comments];
                }
                return $comments;
            } else {
                return [];
            }
        } 
    
       // Metodo che permette di prendere tutte le risposte a un commento
    public static function replies($parent_comment_id) {
        $rep = FDataBase::getInstance()->retrieve(self::getTable(), 'parent_comment_id', $parent_comment_id);
        if (count($rep) > 0) {
            $replies = self::createEntity($rep);
            if (!is_array($replies)) {
                $replies = [$replies];
            }
            return $replies;
        } else {
            return [];
        }
    }

    // Metodo che recupera tutte le risposte di un commento in modo ricorsivo e le organizza in un array associativo
    public static function getRepliesRecursive($comment_id) {
        // Array per mantenere la struttura delle risposte
        $replyStructure = [];

        // Recupera tutte le risposte al commento specificato
        $replies = self::replies($comment_id);

        // Itera attraverso ogni risposta trovata
        foreach ($replies as $reply) {
                // Ricorsivamente otteniamo le risposte per questa risposta
                $replyStructure[] = [
                    'comment' => $reply,
                    'replies' => self::getRepliesRecursive($reply->getId())
                ];
            }
        // Restituisce l'array di risposte (che può contenere altre risposte)
        return $replyStructure;
        }


    // Metodo che ritorna un array di array in cui sono presenti [commento, risposte a quel commento]. Le risposte al commento possono essere un altro array strutturato allo stesso modo.
    //Grazie a questo metodo prendiamo tutti i commenti principali (cioè che non sono risposte) ed estraiamo tutte le risposte, che eventualmente avranno altre risposte.
    public static function getCommentAndReplies($episode_id) {
        $commentAndReplies = [];

        // Recupera tutti i commenti per l'episodio specificato
        $comments = self::retrieveMoreComments($episode_id);

        if ($comments) { // Verifica se ci sono commenti
            foreach ($comments as $comment) {
                // Verifica se il commento non ha un commento genitore (quindi è un commento principale)
                if ($comment->getParentCommentId() === null) {
                    $comment_id = $comment->getId();
                    // Recupera ricorsivamente tutte le risposte al commento principale
                    $replies = self::getRepliesRecursive($comment_id);
                    // Aggiunge il commento principale e le sue risposte all'array di risultati
                    $commentAndReplies[] = [
                        'comment' => $comment,
                        'replies' => $replies
                    ];
                }
            }
        }

        // Restituisce l'array di commenti principali e le loro risposte
        return $commentAndReplies;
    }

  
}