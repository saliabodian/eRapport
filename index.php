<?php
spl_autoload_register();
use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Db\User ;

$conf = Config::getInstance();

// print_r($_POST);
// Gestion de la connexion
$user = new User();

$res = $user->loginPost();

//Gestion de la déconnexion
if($_GET['logout']){
    session_unset();
}

//print_r($res);
include $conf->getViewsDir().'login.php';

