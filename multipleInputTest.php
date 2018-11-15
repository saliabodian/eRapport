<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 10.10.2018
 * Time: 08:48
 */

spl_autoload_register(function ($pClassName) {
    if (strpos($pClassName, "\\")) {
        $namespaces = explode("\\", $pClassName);
        $classname = array_pop($namespaces);
        $includingClassname = __DIR__.'/'.join('/', $namespaces).'/'.$classname.'.php';
    }
    else {
        $includingClassname = __DIR__.'/'.$pClassName.'.php';
    }
    require $includingClassname;
});

use Classes\Cdcl\Config\Config;


$conf = Config::getInstance();

include $conf->getViewsDir().'header.php';
include $conf->getViewsDir().'sidebar.php';
include $conf->getViewsDir().'multipleInputTest.php';
include $conf->getViewsDir().'footer.php';