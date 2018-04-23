<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 09.03.2018
 * Time: 11:46
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

use Classes\Cdcl\Db\Interimaire;

use Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();


if(!empty($_SESSION)){

    $interimaires = Interimaire::getAllIntActifs();

    $chantiers = Chantier::getAllActifSites();


    // var_dump($interimaires);
    // var_dump($chantiers);

//    var_dump($_POST);

    if(!empty($_POST)){
    /*
        array(4) {
            ["date_deb"]=>
  string(10) "07-03-2018"
            ["date_fin"]=>
  string(10) "11-03-2018"
            ["chantier_id"]=>
  string(3) "247"
            ["duallistbox_demo1"]=>
  array(5) {
                [0]=>
    string(3) "316"
                [1]=>
    string(4) "1132"
                [2]=>
    string(4) "1389"
                [3]=>
    string(3) "582"
                [4]=>
    string(3) "312"
  }
}
*/
        $interimaires = Interimaire::getAllIntActifs();
    $_POST['date_deb'] = isset($_POST['date_deb'])? $_POST['date_deb'] : '';
    $_POST['date_fin'] = isset($_POST['date_fin'])? $_POST['date_fin'] : '';
    $_POST['date_fin'] = isset($_POST['date_fin'])? $_POST['date_fin'] : '';
    $_POST['chantier_id'] = isset($_POST['chantier_id'])? $_POST['chantier_id'] : '';
    $interimaires = isset($_POST['duallistbox_demo1'])? $_POST['duallistbox_demo1'] : '';
    $formOk = true;

        if(empty($_POST['date_deb'])){
            $conf->addError('Veuiller saisir la date de début d\'affectation temporaire');
            $interimaires = Interimaire::getAllIntActifs();
            $formOk = false;
        }else{
            if(empty($_POST['date_fin'])){
                $conf->addError('Veuiller saisir la date de fin d\'affectation temporaire');
                $interimaires = Interimaire::getAllIntActifs();
                $formOk = false;
            }else{
                $date_deb = new DateTime($_POST['date_deb']);
                $date_fin = new DateTime($_POST['date_fin']);

                if( $date_deb > $date_fin){
                    $conf->addError('La date de fin d\'affectation ne doit pas être inférieure à date du début.');
                    $interimaires = Interimaire::getAllIntActifs();
                    $formOk = false;
                }
            }
        }

        if(empty($_POST['chantier_id'])){
            $conf->addError('Veuiller sélectionner un chantier d\'affectation');
            $interimaires = Interimaire::getAllIntActifs();
            $formOk = false;
        }

        if(empty($interimaires)){
            $conf->addError('Veuiller sélectionner au moins un intérimaire');
            $interimaires = Interimaire::getAllIntActifs();
            $formOk = false;
        }

        if($formOk === true){
        //    var_dump($interimaires);
            $dateInterval = $date_fin->diff($date_deb);
            $nbDaysDateInterval = $dateInterval->days;
            $week = intval($date_deb->format('W'));
            $year = intval($date_deb->format('Y'));
        //    var_dump($_POST);
        //    var_dump($interimaires);

            foreach($interimaires as $interimaire){
                $affectaionExist = Interimaire::checkInterimaireAffectation($_POST['chantier_id'], $week, $year, intval($interimaire));
                $affectationTemporaire = Interimaire::checkInterimaireAffectationTemporaire($_POST['chantier_id'], $week, $year, intval($interimaire));
            //    var_dump($affectationTemporaire);
            //    var_dump($affectaionExist);
                if($affectationTemporaire<1 && $affectaionExist<1){
                    Interimaire::affectationInterimaireMobilite($date_deb, $date_fin, $nbDaysDateInterval, $_POST['chantier_id'], intval($interimaire));
                }else{
                    $interimaires = Interimaire::getAllIntActifs();
                }
            }
            header('Location: mobilite.php?success='.urlencode('Affectation des intérimaires effectuée avec succés'));
            exit;
        }else{
            $conf->addError('Problème lors de l\'affectation temporaire des intérimaires.');
            $interimaires = Interimaire::getAllIntActifs();
            $formOk = false;
        }

    }

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'mobilite.php';
    include $conf->getViewsDir().'footer.php';

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
