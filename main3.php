<?php
require_once 'libs/Smarty.class.php'; // Percorso al file di autoload di Composer per Smarty

$smarty = StartSmarty::configuration();
// Carica il template



// Visualizza il template
$template->display('Smarty/$templates/header.tpl');