<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 10/10/2017
 * Time: 16:14
 */
// spl_autoload_register();

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

use Classes\Cdcl\Db\Tache;

$conf = Config::getInstance();


if(!empty($_SESSION)){

    if($_POST['tsk_type_id']){
        $listTasks = Tache::getTacheByTypeTache($_POST['tsk_type_id']);
    }

    if($_POST['tsk_type_id'] && $_POST['chantierId']){
        $listTasks = Tache::getTacheByTypeTacheBySite($_POST['tsk_type_id'], $_POST['chantierId']);
    }
    //var_dump($listTasks);
// exit;
    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'getTache.php';
    if($_POST['tsk_type_id'] ){
        include $conf->getViewsDir().'footer.php';
    }
    if($_POST['tsk_type_id'] && $_POST['chantierId']){
        include $conf->getViewsDir().'footerTskSite.php';
    }
}else{
    header('Location: index.php');
}