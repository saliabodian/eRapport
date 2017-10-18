<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 27/09/2017
 * Time: 13:27
 */

spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Config\Dsk;

use Classes\Cdcl\Db\Rapport;

$conf = Config::getInstance();



if(!empty($_SESSION)){
    //var_dump($_GET);
    //var_dump($_POST);

   // {
   // $_GET["chef_dequipe_id"]=> string(2) "67"
   // $_GET["chef_dequipe_matricule"]=> string(2) "38"
   // $_GET["date_generation"]=> string(10) "2017-10-02"
   // $_GET["chantier_id"]=> string(6) "205"
   // $_GET["chantier_code"]=> string(6) "156100"
   // }
    $allPointage = Dsk::getCalculTotalHoraire($_GET["date_generation"], $_GET["chantier_code"]);

    //var_dump($pointage);

    //exit;

    $rapportJournalier = Rapport::get($_GET["rapport_id"]);
    // var_dump($rapportJournalier);
    $chefDequipeMatricule = $rapportJournalier->getChefDEquipeMatricule();
    $rapportJournalierDate = $rapportJournalier->getDate();

    $noyau = Rapport::getRapportNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $noyauAbsent = Rapport::getRapportAbsentNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $horsNoyau = Rapport::getRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);

    //var_dump($noyau);

    //exit;
    if(!empty($allPointage)){
        foreach($allPointage as $pointage){
            foreach($noyau as $rapport){
                if($rapport['ouvrier_id'] === $pointage['matricule']){
                    //    var_dump($pointage['hpoint']);
                    //    var_dump($rapport['id']);
                    Rapport::setWorkerHourCalculated($pointage['hpoint'], $rapport['id']);
                }
            }
        }

        //exit;

        foreach($allPointage as $pointage){
            foreach($noyauAbsent as $rapport){
                if($rapport['ouvrier_id']=== $pointage['matricule']){
                    Rapport::setWorkerHourCalculated($pointage['hpoint'], $rapport['id']);
                }
            }
        }

        foreach($allPointage as $pointage){
            foreach($horsNoyau as $rapport){
                if($rapport['ouvrier_id']=== $pointage['matricule']){
                    Rapport::setWorkerHourCalculated($pointage['hpoint'], $rapport['id']);
                }
            }
        }
    }


//    exit;

    $rapportNoyau = Rapport::getRapportNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $rapportNoyauAbsent = Rapport::getRapportAbsentNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $rapportHorsNoyau = Rapport::getRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);

    // var_dump($rapportNoyauAbsent);
    // var_dump($rapportHorsNoyau);
    // exit;
    if($_GET['erreur']){
        $conf->addError('Veuillez sélectionner au moins un Ouvrier / Intérimaire avant de remplir les tâches');
    }
    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'erapportShow.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}