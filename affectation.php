<?php

/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 07/09/2017
 * Time: 15:51
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

    $today = new DateTime();

    /// var_dump($today);


    $_GET['chantier_id'] = isset($_GET['chantier_id'])? $_GET['chantier_id']:'';
    $_GET['date_deb'] = isset($_GET['date_deb'])? $_GET['date_deb']:'' ;
    $_GET['affectation'] = isset($_GET['affectation'])? $_GET['affectation'] : '';
    $_GET['nextweekaffectation'] = isset($_GET['nextweekaffectation'])? $_GET['nextweekaffectation'] : '';

    $date_courante = new \DateTime();
    $semaine_courante = $date_courante->format('W');

    if($_GET['nextweekaffectation']){
        Interimaire::affectationInterimaireNextWeek();

    }
    if($_GET['affectation']){
    //   var_dump($_GET['date_affectation']);
        $_GET['date_affectation'] = isset($_GET['date_affectation'])? $_GET['date_affectation'] : '';
        if(empty($_GET['date_affectation'])){
            $conf->addError('Veuillez saisir une date !');
        }else{
            Interimaire::affectationInterimaire($_GET['date_affectation']);
        }
    }

   // exit;
    /**
        ************************************************************************
        *********************Gestion du duplicat d'une semaine******************
        *********************Gestion du duplicat d'une semaine******************
        ************************************************************************

        $_GET['reaffect'] = isset($_GET['reaffect'])? $_GET['reaffect']:'';
        $_GET['chantier_id'] = isset($_GET['chantier_id'])? $_GET['chantier_id']:'';
        $_GET['date_deb'] = isset($_GET['date_deb'])? $_GET['date_deb']:'' ;
        if($_GET['reaffect']=== "true"){

        //    var_dump($_GET['weekToDuplicate'] );
        //    var_dump($_GET['weekToAffect']);

        exit;

        //var_dump(time());
        //var_dump(date('W',time()));
        //var_dump(date('W',time() - (7 * 24 * 60 * 60)));


        //$weekToDuplicate =$_GET['weekToDuplicate'] ;
        //$weekToAffect =$_GET['weekToAffect'] ;
        //var_dump($weekToDuplicate);
        //var_dump($weekToAffect);
        // exit;
        $formOk = true;
        if($weekToAffect <= $weekToDuplicate){
        $conf->addError(' Le numéro de la semaine d\'affection doit être supérieure à celui de la semaine dupliquer ');
        $form = false;
        }
        if($formOk){
        Interimaire::duplicateAffectation($weekToDuplicate, $weekToAffect);

        // NB: Si les RH veulent les réaffectations avant la semaine courante
        // c'est à dire à week-1 par exemple la condition sera de la sorte
        // $weekToAffect===date('W',time())+1

        if($weekToAffect === date('W',time())){
        Interimaire::updateDateDebutDateFinInterimaire($weekToAffect);
        }
        header('Location: affectation.php?success='.urlencode('Affectation des intérimaires effectuée avec succés'));
        exit;
        }else{
        $conf->addError('Erreur : lors de la ré-affectation');
        }
        }
     */


    $chantier_id = new Chantier();
// Liste des chantiers actifs
    $listChantierActifs = Chantier::getAllForSelectActif();

    $interimaireObject = new Interimaire();

// Liste des intérimaires actifs
    $interimaireActifs = Interimaire::getAllForSelectActif();

    $chantierChoisi = new Chantier();


    $chantierChoisiValues = !empty($chantierChoisi->get($_GET['chantier_id'])) ? $chantierChoisi->get($_GET['chantier_id']) : "";

    $nomChantierChoisi = $chantierChoisiValues->getNom();

    // Gestion de l'affectation des intérimaires supprimés pour prendre l'affectation direct
    // à la création d'un intérimaire

    // Date du jour sélectionné
    //$_GET['date_deb'] = timestamp
    $selectedDay = !empty(date('Y-m-d', strtotime($_GET['date_deb']))) ? date('Y-m-d', strtotime($_GET['date_deb'])) : "";


    // Semanine  correspondant au jour sélectionné
    $selectedWeek = date('W', strtotime($selectedDay));

   // var_dump($nomChantierChoisi);

   // Calcul de l'écart entre le jour de $day et le lundi (=1)
    $rel = 1 - date('N', strtotime($selectedDay));

//calcul du premier jour de la semaine sélectionnée
    // $firstDaySelectedWeek est une la valeur de la date au format 2017-09-18"
    // strtotime($firstDaySelectedWeek) renvoie le timestamp de la valeur $firstDaySelectedWeek
    $firstDaySelectedWeek = date('Y-m-d', strtotime("$rel days", strtotime($selectedDay)));


    // Exemple de calcul du jour suivant
    //$jourSuivant = mktime(0,0,0, date('m', strtotime($firstDaySelectedWeek)), date('d', strtotime($firstDaySelectedWeek))+1, date('Y', strtotime($firstDaySelectedWeek)));
    //var_dump(date('Y-m-d', mktime(0,0,0, date('m', strtotime($firstDaySelectedWeek)), date('d', strtotime($firstDaySelectedWeek))+1, date('Y', strtotime($firstDaySelectedWeek)))));


    $selected = Interimaire::getInterimaireAffected($selectedWeek, $_GET['chantier_id']);

    //var_dump($selected);

    // transformation du tableau à deux dimensions $selected en tableau à une dimension $interimaireSelectedLight
    if(!empty($selected)){
        foreach($selected as $interimaireSelected){
        //    var_dump($interimaireSelected);
            $interimaireSelectedLight[]=$interimaireSelected['interimaire_id'];
        }




        // Dans le cas d'une modification les chantiers qui n'ont pas encore été choisi

        foreach ($interimaireActifs as $id => $isActve){
            if ( in_array( $id, $interimaireSelectedLight ) ) {
                $isSelected[$id]= $isActve;
            }
        }

        // Dans le cas d'une modification les chantiers les chantiers déjà choisis

        foreach ($interimaireActifs as $id => $isActve){
            if ( !in_array( $id, $interimaireSelectedLight ) ) {
                $isNotSelected[$id]=$isActve;
            }
        }
    }else{
        $isNotSelected = $interimaireActifs;
    }

    // var_dump($isSelected);


    $selectChantier = new SelectHelper($listChantierActifs, $chantier_id->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


// exit;
    if(!empty($_POST)) {
    //   var_dump($_POST);
        $chantier_id = isset($_POST['chantier_id_to_treat']) ? $_POST['chantier_id_to_treat'] : "";
        $week = isset($_POST['week']) ? $_POST['week'] : "";
        $listInterimaires = isset($_POST['duallistbox_demo1'])? $_POST['duallistbox_demo1'] : "";
        $form=true;

        //$chantier_id = new Chantier();

        if(empty($chantier_id)){
            $conf->addError('Veuillez choisir un chantier');
            $form=false;
        }
        if(empty($week)){
            $conf->addError('Veuillez définir une date');
            $form=false;
        }

        if(empty($listInterimaires)){
            $conf->addError('Veuillez choisir des intérimaires');
            $form=false;
        }

        $affectationExists = Interimaire::checkAffectation($_POST['chantier_id_to_treat'],$_POST['week'],$_POST['duallistbox_demo1']);
        // var_dump($affectationExists);

        // exit;
        if ($affectationExists>=1){
            $conf->addError("Des intérimaires ont déjà été affecté pour ce chantier et pour cette date");
            $form=false;
        }

        if($form){
            $affectation = Interimaire::affectationSaved($_POST['chantier_id_to_treat'], $_POST['week'],$_POST['duallistbox_demo1'], $firstDaySelectedWeek);
            header('Location: affectation.php?success='.urlencode('Affectation des intérimaires effectuée avec succés'));
            exit;
        }else{
            $conf->addError('Erreur lors l\'affectation des intérimaires');
        }

    }







    include $conf->getViewsDir() . "header.php";
    include $conf->getViewsDir() . "sidebar.php";
    include $conf->getViewsDir() . "affectation.php";
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