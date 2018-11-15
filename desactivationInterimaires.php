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

use Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $interimaire = new Interimaire();

    $interimaires = $interimaire->getAllIntActifs();

    if(!empty($_POST)){

        $interimairesList = $_POST["interimaire_id"];

        $interimairesListLength = sizeof($interimairesList);

    //    var_dump($interimairesList);

    //    exit;

        for($i=0; $i<$interimairesListLength; $i++){
            $interimaire->interimaireDesactivation($interimairesList[$i]);
        }
    }

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'desactivationInterimaires.php';
    include $conf->getViewsDir().'footer.php';

    if (isset($_SESSION['LAST_REQUEST_TIME'])) {
        if (time() - $_SESSION['LAST_REQUEST_TIME'] > 900) {
            // session timed out, last request is longer than 3 minutes ago
            $_SESSION = array();
            session_destroy();
        }
    }
    $_SESSION['LAST_REQUEST_TIME'] = time();

}else{
    header('Location: index.php');
}