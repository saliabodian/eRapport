<?php
// spl_autoload_register();

//die(phpinfo());

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

use \Classes\Cdcl\Db\User ;

unset($_SESSION);

$conf = Config::getInstance();

// print_r($_POST);
// Gestion de la connexion
$user = new User();

$res = $user->loginPost();

$logout = isset($_GET['logout'])? $_GET['logout']: '';

//Gestion de la déconnexion
if($logout){
    unset($_SESSION);
    session_destroy();
    header('Location: index.php');
}

//print_r($res);
include $conf->getViewsDir().'login.php';

