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

    $contenu = '';

    $date = time();

 //   var_dump($date);

    $contenu .= '';

    foreach($interiamireList as $interimaire){
        $contenu .= $interimaire['matricule']."\t".$interimaire['lastname']."\t".$interimaire['firstname']."\t".$interimaire['evaluation_chantier_id']."\t".$interimaire['date_deb']."\r\n";
    }
    $fichier = 'ExportTxt\fichier'.$date.'txt';

    $f = fopen($fichier, 'a');

    fwrite($f, $contenu);

    fclose($f);

    $dir = scandir('ExportTxt');

 //   var_dump($dir);

 //   exit;
    include $conf->getViewsDir().'headerTableExport.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'txtExpTest.php';
    include $conf->getViewsDir().'footerTableExport.php';
}else {
    header('Location: index.php');
}
