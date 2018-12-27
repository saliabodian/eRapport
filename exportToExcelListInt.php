<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 20.07.2018
 * Time: 13:55
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


use \Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();
if(!empty($_SESSION)){

    $interimaires = new Interimaire();

    $interiamireList = $interimaires->getAllIntActifs();

    // var_dump($interiamireList);

    // exit;

    $interimaireId = [];

    foreach($interiamireList as $interiamire){
        $interimaireId [] = $interiamire['id'];
    }
    $intMobiles= $interimaires->getIntWithMobility();


    include $conf->getViewsDir().'headerTableExport.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'exportToExcelListInt.php';
    include $conf->getViewsDir().'footer.php';
}else {
    header('Location: index.php');
}
