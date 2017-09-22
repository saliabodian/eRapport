<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 10/09/2017
 * Time: 19:25
 */

spl_autoload_register();

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


    $chantierChoisiValues = !empty($chantierChoisi->get($_GET['chantier_id'])) ? $chantierChoisi->get($_GET['chantier_id']) : "";

    $nomChantierChoisi = $chantierChoisiValues->getNom();



    // Date du jour sélectionné
    //$_GET['date_deb'] = timestamp
    if(!empty($_GET)){

        $selectedDay = !empty(date('Y-m-d', strtotime($_GET['date_deb']))) ? date('Y-m-d', strtotime($_GET['date_deb'])) : "";
        $selectedWeek = date('W', strtotime($selectedDay));
        $listInterimaires = Interimaire::getInterimaireAffected($selectedWeek, $_GET['chantier_id']);

    }

    if(!empty($_POST)){

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

    if($_GET['day']===true){
        $listInterimaires = Interimaire::getInterimaireAffected($selectedDay, $_GET['chantier_id']);
    }



    include $conf->getViewsDir() . "header.php";
    include $conf->getViewsDir() . "sidebar.php";
    include $conf->getViewsDir() . "showAffectation.php";
    include $conf->getViewsDir() . "footer.php";
}else{
    header('Location: index.php');
}