<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 27.11.2017
 * Time: 10:02
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

$conf = Config::getInstance();

// var_dump($_SESSION);

if(!empty($_SESSION)){

   // Script à éxécuter

   include 'sendConducEmail.php';
   include 'sendEmailToRh.php';

    if ($_SESSION['post_id']=== "4" || $_SESSION['post_id']=== "7"){
        header('Location: home.php');
    }
    if ($_SESSION['post_id']==="1" || $_SESSION['post_id']==="2" || $_SESSION['post_id']==="3" || $_SESSION['post_id']==="5"){
        header('Location: erapport.php');
    }

    if ( $_SESSION['post_id']==="12" ){
        header('Location: tache.php');
    }

}else{
    header('Location: index.php');
}