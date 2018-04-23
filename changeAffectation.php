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

    //var_dump($listChantierActifs);

    $interimaireObject = new Interimaire();

// Liste des intérimaires actifs
    $interimaireActifs = Interimaire::getAllForSelectActif();

    $chantierChoisi = new Chantier();


    $chantierChoisiValues = !empty($chantierChoisi->get($_GET['chantier_id'])) ? $chantierChoisi->get($_GET['chantier_id']) : "";

    $nomChantierChoisi = $chantierChoisiValues->getNom();

    $chantierHasUser = Chantier::getChantierHasUser();


    //var_dump($chantierHasUser);
    //exit;

    // Date du jour sélectionné
    //$_GET['date_deb'] = timestamp
    if(isset($_GET['date_deb'])){
        $selectedDay = !empty(date('Y-m-d', strtotime($_GET['date_deb']))) ? date('Y-m-d', strtotime($_GET['date_deb'])) : "";


        // Semanine  correspondant au jour sélectionné
        $selectedWeek = date('W', strtotime($selectedDay));
    }



    $selectChantier = new SelectHelper($listChantierActifs, $chantier_id->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    $interimaireSelected = Interimaire::interimaireSelected($_GET['row_id']);
    //var_dump($_GET);
    //var_dump('<br>');
    //var_dump($interimaireSelected);

    //exit;

    // Suppression d'une affectation
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Interimaire::deleteInterimaireAffectation(intval($_GET['delete']))) {
            header('Location: showAffectation.php?success=' .urlencode('Suppression effectuée').'&date_deb='.$_GET['date_deb'].'&chantier_id='.$_GET['chantier_id']);
            exit;
        }
    }



    if(!empty($_POST)){

         // var_dump(date('Y-m-d', strtotime($_POST['doy'])));

        // exit;
        $date_debut = isset($_POST['debut'])? $_POST['debut'] : "";
        $date_fin = isset($_POST['fin'])? $_POST['fin'] : "";
        $row_id = isset($_POST['int_has_cht_id'])? $_POST['int_has_cht_id'] : "";
        $ChantierHasUserId = isset($_POST['chantier_user'])? $_POST['chantier_user'] : "";
        $newDate = isset($_POST['doy']) ? date('Y-m-d', strtotime($_POST['doy'])) : '';
        $interimaireId = isset($_POST['interimaire_id']) ? $_POST['interimaire_id'] : '';
        $chantierAndUserId = Chantier::getChantierHasUserId($ChantierHasUserId);

    //    var_dump($chantierAndUserId);
        $form = true;

        //var_dump($newDate);

        if(empty($newDate)){
            $conf->addError("Veuillez choisir une date");
            $form = false;
        }

        $affectationExist = Interimaire::checkChantierAndDoyAffectation($newDate, $interimaireId, $chantierAndUserId['chantier_id'],  $chantierAndUserId['usr_id']);

        $dateIsOk = Interimaire::compareDateForChangeAffectation($newDate, $date_debut, $date_fin);
        if($dateIsOk>=1){
            if($affectationExist>=1){
                $conf->addError('Cet interimaire posséde déjà une affectation pour ce chantier et pour cette date');
                $form = false;
            }
        }else{
            $conf->addError('La date choisie n\'appartient pas à la semaine courantre');
            $form = false;
        }
    //    var_dump($_POST);
    //    exit;
        if($form){
            // var_dump($form);
            // var_dump($chantierAndUserId['usr_id']);
            // var_dump($chantierAndUserId['chantier_id']);
            // var_dump($row_id);
            // var_dump($newDate);
            // var_dump($form);

            // exit;

            Interimaire::changeChantierAffectation($newDate, $chantierAndUserId['chantier_id'],$chantierAndUserId['usr_id'], $row_id);
            header('Location: showAffectation.php?success=' .urlencode('Ajout/Modification effectuée').'&date_deb='.$date_debut.'&chantier_id='.$_GET['chantier_id']);
        //    header('Location: changeAffectation.php?success='.urlencode('Ajout/Modification effectuée').'&row_id='.$row_id.'&date_debut='.$date_debut.'&date_fin='.$date_fin.'&new_date='.$newDate);
            exit;
        }else{
            $conf->addError("La modification ne s'est pas bien déroulée");
        }
    }


    // $interiamireSelected=Interimaire::interimaireSelected($_POS['row_id']);

    // var_dump($interiamireSelected);



    include $conf->getViewsDir() . "header.php";
    include $conf->getViewsDir() . "sidebar.php";
    include $conf->getViewsDir() . "changeAffectation.php";
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