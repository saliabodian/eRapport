<?php

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

use Classes\Cdcl\Db\Chantier ;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    if($_POST)
    {

        $dateDeb = date('Y-m-d', strtotime($_POST['dateDeb']));
        $dateFin = date('Y-m-d', strtotime($_POST['dateFin']));
        $listTache = Chantier::getSiteTache($_POST['chantier_id'],$dateDeb,$dateFin);

        //    var_dump($listOuvrier);
    }


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'getSiteTache.php';
    include $conf->getViewsDir().'footer.php';
}else {
    header('Location: index.php');
}
