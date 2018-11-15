<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 26.09.2018
 * Time: 10:27
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

use Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();

if(!empty($_SESSION)) {

    if( isset ($_POST['siteToSet'])){
        $sites = $_POST['siteToSet'];

        foreach($sites as $site){
            Chantier::setIntemperie($site);
        //    $chantierWithoutItp = $chantierWithoutItp->getChantierActifWithoutItp();

        }
    //    sleep(2);
    }

    if( isset ($_POST['siteToUnset'])){
        $sites = $_POST['siteToUnset'];
        foreach($sites as $site){
            Chantier::unsetIntemperie($site);

        }

    //    sleep(2);
    }

    $chantierWithItp = new Chantier();

    $chantierWithItp = $chantierWithItp->getChantierActifWithItp();

    //var_dump($chantierWithItp);

    $chantierWithoutItp = new Chantier();

    $chantierWithoutItp = $chantierWithoutItp->getChantierActifWithoutItp();


    include $conf->getViewsDir() . "header.php";
    include $conf->getViewsDir() . "sidebar.php";
    include $conf->getViewsDir() . "chantierEnIntemperie.php";
    include $conf->getViewsDir() . "footer.php";

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