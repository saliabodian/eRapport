<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 30.01.2018
 * Time: 09:07
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

use \Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    if($_POST['chantier_id'])
    {
        $listOuvrier = Interimaire::getOuvrier($_POST['chantier_id']);

        //    var_dump($listOuvrier);
    }
 //   var_dump($listOuvrier);
 //exit;

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'getOuvrier.php';
    include $conf->getViewsDir().'footer.php';
}else {
    header('Location: index.php');
}