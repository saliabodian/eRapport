<?php
spl_autoload_register();

use \Classes\Cdcl\Config\Config;

$conf = Config::getInstance();

// var_dump($_SESSION);

include $conf->getViewsDir().'header.php';
include $conf->getViewsDir().'sidebar.php';
include $conf->getViewsDir().'footer.php';