<?php
spl_autoload_register();

use \Classes\Cdcl\Config\Config;

$conf = Config::getInstance();

// var_dump($_SESSION);

if(!empty($_SESSION)){
    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}