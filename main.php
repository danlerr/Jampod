<?php
      require_once "autoloader.php";
      
    $db = FDataBase::getInstance()->getDb();
    if ($db) {
        echo "Database connection established.\n";
    } else {
        die("Database connection failed.\n");
    }
$user = new EUser("blablafdsds@gmail.com", "ssaaass", "ssssssaaaaaaonooo");
echo(FPersistentManager::getInstance()->createObj($user));
