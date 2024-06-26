<?php
      require_once __DIR__. '/Model/EUser.php';
      require_once __DIR__. '/Model/EVote.php';
      require_once __DIR__.'/Foundation/FVote.php';
      require_once __DIR__.'/Foundation/FSubscribe.php';
      require_once __DIR__. '/Model/EPodcast.php';
      require_once __DIR__. '/Model/EEpisode.php';
      require_once __DIR__. '/Model/ESubscribe.php';
      require_once __DIR__.'/Foundation/FUser.php';
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
$user = new EUser("sonoio@gmail.com", "ciaociao", "sonooo");
FPersistentManager::getInstance()->createObj($user);
$podcast = new EPodcast("uccisione","bellissima", $user->getId(), 1);
$podcast->setImageData(file_get_contents("Smarty/images/logo.png"));
FPersistentManager::getInstance()->createObj($podcast);
$idp = $podcast->getId();

$retrieve = FPersistentManager::getInstance()->retrieveObj(get_class($podcast), $idp);
echo($retrieve->getId());
$episode= new EEpisode("episodio1" , "natura" , $idp);
$episode->setImageData(file_get_contents("Smarty/images/logo.png"));
$episode->setAudioData(file_get_contents("Smarty/images/logo.png"));
FPersistentManager::getInstance()->createObj($episode);
$episodeid = $episode->getId();
echo("id episodio:" . $episodeid);
echo(FPersistentManager::getInstance()->retrieveObj(get_class($episode), $episodeid)-> getId()) ;


//vote:
$vote = new EVote(2, $user->getId(), $episodeid);
FPersistentManager::getInstance()->createObj($vote);

echo("Ecco l'id del voto:" . FPersistentManager::getInstance()->retrieveObj(get_class($vote), $vote->getId())-> getId()) ;

FPersistentManager::getInstance()->deleteObj($vote);
//sub
$sub = new ESubscribe($podcast->getId(), $user->getId());
FPersistentManager::getInstance()->createObj($sub);
$result= FPersistentManager::getInstance()->retrieveObj(get_class($sub),$sub->getId());
echo("idssss". $result->getId());
FPersistentManager::getInstance()->deleteObj($sub);