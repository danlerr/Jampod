<?php
      require_once __DIR__. '/model/EUser.php';
      require_once __DIR__. '/model/EPodcast.php';
      require_once __DIR__. '/model/EComment.php';
      require_once __DIR__. '/model/EDonation.php';
      require_once __DIR__. '/model/ECreditCard.php';
      require_once __DIR__. '/Foundation/FComment.php';
      require_once __DIR__. '/Foundation/FDonation.php';
      require_once __DIR__. '/model/EEpisode.php';
      require_once __DIR__.'/Foundation/FUser.php';
      require_once __DIR__.'/Foundation/FCreditCard.php';
      require_once __DIR__.'/Foundation/FEpisode.php';
      require_once __DIR__.'/Foundation/FPodcast.php';
      require_once __DIR__.'/Foundation/FDataBase.php';
      require_once __DIR__.'/Foundation/FPersistentManager.php';
    $db = FDataBase::getInstance()->getDb();
    if ($db) {
        echo "Database connection established.\n";
    } else {
        die("Database connection failed.\n");
    }
/*$user = new EUser("sonoio@gmail.com", "ciaociao", "sonooo");
FPersistentManager::getInstance()->createObj($user);
$podcast = new EPodcast("uccisione","bellissima", $user->getId(), 1);
$podcast->setImageData(file_get_contents("Smarty/images/logo.png"));
FPersistentManager::getInstance()->createObj($podcast);
$idp = $podcast->getId();

$retrieve = FPersistentManager::getInstance()->retrieveObj(get_class($podcast), $idp);
echo($retrieve->getId());
$updateSuccess = FPersistentManager::getInstance()->updateObj($retrieve, 'podcast_name', 'r');
 echo "Update User: " . ($updateSuccess ? "Success" : "Failure") . "\n";
//FPersistentManager::getInstance()->deleteObj($retrieve);
$episode=new EEpisode('dio','j',$podcast->getId());
FPersistentManager::getInstance()->createObj($episode);

$comment=new EComment('ronnie',$user->getId(),$episode->getId());
FPersistentManager::getInstance()->createObj($comment);
echo $comment->getCommentText();
FPersistentManager::getInstance()->updateObj($comment,'comment_text','dio');
$comment=FPersistentManager::getInstance()->retrieveObj('EComment',$comment->getId());
echo $comment->getCommentText();
FPersistentManager::getInstance()->deleteObj($comment);

//$card= new ECreditCard('io','22','2','2025-12',$user->getId());
//FPersistentManager::getInstance()->createObj($card);
//$card= FPersistentManager::getInstance()->retrieveObj('ECreditCard',$card->getId());
//echo $card->getCreditCardHolder();
//FPersistentManager::getInstance()->updateObj($card,'card_holder','tu');
//$card= FPersistentManager::getInstance()->retrieveObj('ECreditCard',$card->getId());
//echo $card->getCreditCardHolder();
//FPersistentManager::getInstance()->deleteObj($card);

/*

$user1=new EUser('dpg@sferaebbasta','stefano','daniele');
FPersistentManager::getInstance()->createObj($user1);
$user=FPersistentManager::getInstance()->retrieveObj('EUser',$user->getId());
$user1=FPersistentManager::getInstance()->retrieveObj('EUser',$user1->getId());
$donation= new EDonation(65,'BASTA',$user->getId(),$user1->getId());
FPersistentManager::getInstance()->createObj($donation);
//$donation1= FPersistentManager::getInstance()->retrieveObj('EDonation',$donation->getId());
echo $donation->getDonationText();
*/
// Creazione di un utente
$user = new EUser("utente@test.com", "password", "Nome Utente");
FPersistentManager::getInstance()->createObj($user);

// Creazione di alcune carte di credito per l'utente
$card1 = new ECreditCard("Titolare Carta 1", "1111222233334444", "12", "2025-12", $user->getId());
FPersistentManager::getInstance()->createObj($card1);

$card2 = new ECreditCard("Titolare Carta 2", "5555666677778888", "12", "2025-12", $user->getId());
FPersistentManager::getInstance()->createObj($card2);

// Recupero delle carte di credito dell'utente
$userId = $user->getId();
$creditCards = FPersistentManager::getInstance()->retrieveUserCreditCards($userId);

// Verifica se sono state recuperate delle carte di credito
if (!empty($creditCards)) {
    echo "Carte di credito dell'utente con ID $userId:\n";
    foreach ($creditCards as $card) {
        echo " Titolare: " . $card->getCreditCardHolder() . ", Numero Carta: " . $card->getCreditCardNumber() . "\n";
    }
} else {
    echo "Nessuna carta di credito trovata per l'utente con ID $userId.\n";
}