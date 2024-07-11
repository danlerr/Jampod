<?php

//DB Connection
define('DB_HOST', 'localhost');
define('DB_NAME', 'Jampod');
define('DB_USER', 'root');
define('DB_PASS', '');

//session cookie expiration
define('COOKIE_EXP_TIME', 2592000); //30 giorni

define("imageMaxSize", 5 * 1024 * 1024); //5MB
define("allowedImageTypes", ['image/jpeg', 'image/png', 'image/jpg']);


define("audioMaxSize", 10 * 1024 * 1024);//10MB
define("allowedAudioTypes",['audio/mpeg', 'audio/wav'] );