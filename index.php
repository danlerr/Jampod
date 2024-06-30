<?php
require_once "config/config.php";
require_once 'autoloader.php';



$fc = new CFrontController();
$fc->run($_SERVER['REQUEST_URI']);