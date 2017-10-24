<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 24/10/2017
 * Time: 16:25
 */
spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\TypeTache;

use Classes\Cdcl\Db\Rapport;

use Classes\Cdcl\Db\Tache;

use Classes\Cdcl\Config\Dsk;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $hourAnomaly = Rapport::getRapportDetailWithHourAnomaly();

    //var_dump($hourAnomaly);

    $absenceList = Rapport::getRapportDetailWithAbsenceAnomaly();

    //var_dump($absenceList);



    //exit;

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'anomalieRh.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}