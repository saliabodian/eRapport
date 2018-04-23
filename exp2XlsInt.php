<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 02.03.2018
 * Time: 14:05
 */

spl_autoload_register(/**
 * @param $pClassName
 */
    function ($pClassName) {
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
use \Classes\Cdcl\Db\CSV;

$conf = Config::getInstance();


if(!empty($_SESSION)){
    $rslt = Interimaire::getAllIntActifs();

    CSV::exportCsv($rslt, 'Liste des intérimaires');


}

/*else{
    header('Location: index.php');
}*/