<?php

require_once 'Smarty\libs\Smarty.class.php';

use Smarty\Smarty;

class StartSmarty{
    static function configuration(){
        $smarty=new Smarty();
        $smarty->setTemplateDir('Smarty\templates');
        $smarty->setConfigDir('Smarty\templates_c');
        $smarty->setCompileDir('Smarty\configs');
        $smarty->setCacheDir('Smarty\cache');
        return $smarty;
    }
}