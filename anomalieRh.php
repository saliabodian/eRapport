<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 24/10/2017
 * Time: 16:25
 */
//spl_autoload_register();

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

use Classes\Cdcl\Db\TypeTache;

use Classes\Cdcl\Db\Rapport;

use Classes\Cdcl\Db\Tache;

use Classes\Cdcl\Config\Dsk;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $absenceTraitement = isset($_GET['absence_traitement']) ? $_GET['absence_traitement'] : '';
    $hourTraitement = isset($_GET['hour_traitement']) ? $_GET['hour_traitement'] : '';

    if(!empty($absenceTraitement)){
        Rapport::absenceAnomalyTreatment($absenceTraitement);
    }

    if(!empty($hourTraitement)){
        Rapport::hourAnomalyTreatment($hourTraitement);
    }

    $hourAnomaly = Rapport::getRapportDetailWithHourAnomaly();

    //var_dump($hourAnomaly);

    $absenceList = Rapport::getRapportDetailWithAbsenceAnomaly();

    $today = new DateTime();

    $nbDaysBeforeFirstDayOfMonth = intval($today->format('d')) - 1;

    $firstDayofTheMonth = new DateTime($today->format('Y-m-d').' -'.$nbDaysBeforeFirstDayOfMonth .'day');

    //var_dump($firstDayofTheMonth);

    //exit;

    $_POST["month_anomaly_treatment"] = isset($_POST["month_anomaly_treatment"]) ? $_POST["month_anomaly_treatment"] : "";

    if($_POST["month_anomaly_treatment"] === "true"){
        foreach ($hourAnomaly as $anomaly){
            if($anomaly['date'] < $firstDayofTheMonth->format('Y-m-d')){
            //    var_dump($anomaly);
                Rapport::hourAnomalyTreatment($anomaly['id']);
            }
        }

        foreach ($absenceList as $anomaly){
            if($anomaly['date'] < $firstDayofTheMonth->format('Y-m-d')){
                Rapport::absenceAnomalyTreatment($anomaly['id']);
            }
        }
        header('Location: anomalieRh.php');
    }



    // var_dump($firstDayofTheMonth);
    // var_dump($_POST);

    // exit;



    //var_dump($absenceList);



    //exit;

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'anomalieRh.php';
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