<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 29.03.2018
 * Time: 11:08
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

use Classes\Cdcl\Db\User;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    //var_dump($_POST['chantier_id']);

    if($_POST['chantier_id'])

    //
    {
        $listChefDequipe = User::getChefDequipe($_POST['chantier_id']);

    //  var_dump($listChefDequipe);
    }
    //exit;

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'getChefDequipe.php';
    include $conf->getViewsDir().'footer.php';
}else {
    header('Location: index.php');
}