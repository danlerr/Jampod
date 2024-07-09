<?php
 // Percorso al file di autoload di Composer per Smarty
require_once 'StartSmarty.php';
require_once 'Foundation/FDataBase.php';
require_once 'Foundation/FPodcast.php';
require_once 'autoloader.php';
require_once 'Controller/CMail.php';

//$smarty = StartSmarty::configuration();
// Carica il template



// Visualizza il template
//$pods = array();

//$smarty->assign('myPodcasts', $pods);

//$smarty->display('Smarty/templates/myPodcasts.tpl');

//$categories =FPodcast::allCategories();

//print_r($categories);

//$pod = new EPodcast('ii', 'de', '66', 'Salute');

//$result = FPersistentManager::getInstance()->createObj($pod);

// if ($result){
//     echo 'pod creato';
// }else{
//     echo 'problemi';
// }



//$idp = $pod->getId();

//$retrieve2 = FPersistentManager::getInstance()->retrieveObj('EPodcast', $idp);

//$update = FPersistentManager::getInstance()->updateObj($pod, 'subscribe_counter', 35);

//echo (FPersistentManager::getInstance()->isSubscribed(69, 43));
// if ($update){
//     echo 'yes';
// }
//echo($pod->getPodcastCategory());


$mailer = CMail::getInstance();
        
$mailer->sendMail('jampodPodcast@gmail.com', 'abc', 'messaggio');
        
echo "Email inviata a:    ";