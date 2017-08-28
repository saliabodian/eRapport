
<?php
spl_autoload_register();
use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Db\User ;

$conf = Config::getInstance();

// print_r($_POST);

    $user = new User();

    $res = $user->loginPost();

//print_r($res);
include '\views\login.php';

