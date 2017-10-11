<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 10/10/2017
 * Time: 16:14
 */
spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\Tache;

use Classes\Cdcl\Db\TypeTache;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    if($_POST['tsk_type_id'])
    {
        $listTasks = Tache::getTacheByTypeTache($_POST['tsk_type_id']);

    //    var_dump($listTasks);
    }
    //var_dump($listTasks);
// exit;
    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'getTache.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}