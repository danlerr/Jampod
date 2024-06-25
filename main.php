<?php
      require_once __DIR__. '/Model/EUser.php';
      require_once __DIR__. '/Model/EPodcast.php';
      require_once __DIR__. '/Model/EEpisode.php';
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
$updateSuccess = FPersistentManager::getInstance()->updateObj($retrieve, 'podcast_name', 'stocazzo');
 echo "Update User: " . ($updateSuccess ? "Success" : "Failure") . "\n";
FPersistentManager::getInstance()->deleteObj($retrieve);