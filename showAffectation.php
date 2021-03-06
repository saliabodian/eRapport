<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 10/09/2017
 * Time: 19:25
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

use Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();

if(!empty($_SESSION)) {

    $chantier_id = new Chantier();
// Liste des chantiers actifs
    $listChantierActifs = Chantier::getAllForSelectActif();

    $interimaireObject = new Interimaire();

// Liste des intérimaires actifs
    $interimaireActifs = Interimaire::getAllForSelectActif();

    $chantierChoisi = new Chantier();

    $_GET['chantier_id'] = isset($_GET['chantier_id'])? $_GET['chantier_id'] : '';
    $chantierChoisiValues = !empty($chantierChoisi->get($_GET['chantier_id'])) ? $chantierChoisi->get($_GET['chantier_id']) : "";

    $nomChantierChoisi = $chantierChoisiValues->getNom();



    // Date du jour sélectionné
    //$_GET['date_deb'] = timestamp
    if(!empty($_GET)){
        $_GET['date_deb'] = isset($_GET['date_deb'])?$_GET['date_deb'] : '';
        $_GET['chantier_id'] = isset($_GET['chantier_id'])? $_GET['chantier_id'] :'';
        $selectedDay = !empty(date('Y-m-d', strtotime($_GET['date_deb']))) ? date('Y-m-d', strtotime($_GET['date_deb'])) : "";
        $selectedWeek = date('W', strtotime($selectedDay));
        $listInterimaires = Interimaire::getInterimaireAffected($selectedWeek, $_GET['chantier_id']);

    }

    if(!empty($_POST)){
        $_POST['date_deb'] = isset($_POST['date_deb'])?$_POST['date_deb'] : '';
        $_POST['chantier_id'] = isset($_POST['chantier_id'])? $_POST['chantier_id'] :'';
        $selectedDay = !empty(date('Y-m-d', strtotime($_POST['date_deb']))) ? date('Y-m-d', strtotime($_POST['date_deb'])) : "";

        $listInterimaires = Interimaire::getInterimaireAffectedDay($selectedDay, $_POST['chantier_id']);
    }

    // var_dump($_GET['date_deb']);

 //   exit;

    // Semanine  correspondant au jour sélectionné
    ;


    $selectChantier = new SelectHelper($listChantierActifs, $chantier_id->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $_GET['day'] = isset($_GET['day'])? $_GET['day'] : '';
    if($_GET['day']===true){
        $listInterimaires = Interimaire::getInterimaireAffected($selectedDay, $_GET['chantier_id']);
    }



    include $conf->getViewsDir() . "header.php";
    include $conf->getViewsDir() . "sidebar.php";
    include $conf->getViewsDir() . "showAffectation.php";
    include $conf->getViewsDir() . "footer.php";

    /**
     *
     *
     * Gestion de la durée pendant laquelle un User peut être
     * sans activité avant que le système ne le déconncete
     * Cette durée a été mis à 15mn soit 900s
     *
     *
     */

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