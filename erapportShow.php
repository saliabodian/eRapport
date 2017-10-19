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

        //var_dump($horsNoyau);

        //exit;



        //var_dump($idRapportNoyau);
        //var_dump($idRapportAbsentNoyau);
        //var_dump($idRapportHorsNoyau);

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

        // Récupération des ids des différents rapports générés absents à savoir ceux du noyau, les absents et les hors noyaux

        $i = 0;

        for($i=0; $i<1; $i++){
            $idRapportNoyau = $noyau[$i]['rapport_id'];
            $idRapportAbsentNoyau = $noyauAbsent[$i]['rapport_id'];
            $idRapportHorsNoyau = $horsNoyau[$i]['rapport_id'];
        }
        if(!empty($idRapportNoyau)){
            $noyauHeader = Rapport::getRapportNoyauHeader($idRapportNoyau, $_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        }

        if(!empty($idRapportAbsentNoyau)){
            $noyauAbsentHeader = Rapport::getRapportAbsentNoyauHeader($idRapportAbsentNoyau,$_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        }

        if(!empty($idRapportHorsNoyau)){
            $horsNoyauHeader = Rapport::getRapportHorsNoyauHeader($idRapportHorsNoyau, $_GET['date_generation'], $_GET['chantier_id']);
        }

        foreach($noyau as $noyauDetail){

            $noyauWorkerTask[$noyauDetail['id']]  = Rapport::getWorkerTask($noyauDetail['id']);

            $noyauWorkerTaskDetail[$noyauDetail['id']] = Rapport::getWorkerTaskDetail($noyauDetail['id']);
        }

        /*foreach ($noyauWorkerTask[25] as $workerTsk){
            var_dump($workerTsk['code']);
        }
        */
        foreach($noyauAbsent as $noyauAbsentDetail){

            $noyauAbsentTask[$noyauAbsentDetail['id']] = Rapport::getWorkerTask($noyauAbsentDetail['id']);
            $noyauAbsentTaskDetail[$noyauAbsentDetail['id']] = Rapport::getWorkerTaskDetail($noyauAbsentDetail['id']);
        }

        foreach($horsNoyau as $horsNoyauDetail){

            $horsNoyauTask[$horsNoyauDetail['id']] = Rapport::getWorkerTask($horsNoyauDetail['id']);
            $horsNoyauTaskDetail[$horsNoyauDetail['id']] = Rapport::getWorkerTaskDetail($horsNoyauDetail['id']);
        }

        // var_dump($idRapportNoyau);
        // var_dump($_GET['chef_dequipe_id']);
        // var_dump( $_GET['date_generation']);
        // var_dump( $_GET['chantier_id']);
        // var_dump($noyauHeader);
        // var_dump($noyauAbsentHeader);
        // var_dump($horsNoyauHeader);
        // var_dump($noyau);
        // var_dump($horsNoyauTask);
        // var_dump($horsNoyauTaskDetail);
        // exit;

        $rapportNoyau = Rapport::getRapportNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        $rapportNoyauAbsent = Rapport::getRapportAbsentNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        $rapportHorsNoyau = Rapport::getRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);

        $noyauHourGlobal = 0;
        $horsNoyauHourGlobal = 0;
        $absentHourGlobal = 0;


        $noyauHourAbsencesGlobal = 0;
        $horsNoyauHourAbsencesGlobal = 0;
        $absentHourAbsencesGlobal = 0;

        $noyauHourPenibleGlobal = 0;
        $horsNoyauHourPenibleGlobal = 0;
        $absentHourPenibleGlobal = 0;

        $noyauKmGlobal = 0;
        $horsNoyauKmGlobal = 0;
        $absentKmGlobal = 0;

        foreach($rapportNoyau as $noyau){
            $noyauHourGlobal = $noyauHourGlobal + $noyau['htot'];
            $noyauHourAbsencesGlobal = $noyauHourAbsencesGlobal + $noyau['habs'];
            $noyauHourPenibleGlobal = $noyauHourPenibleGlobal + $noyau['hins'];
            $noyauKmGlobal = $noyauKmGlobal + $noyau['km'];
        }

        foreach($rapportNoyauAbsent as $noyau){
            $absentHourGlobal = $absentHourGlobal + $noyau['htot'];
            $absentHourAbsencesGlobal = $absentHourAbsencesGlobal + $noyau['habs'];
            $absentHourPenibleGlobal = $absentHourPenibleGlobal + $noyau['hins'];
            $absentKmGlobal = $absentKmGlobal + $noyau['km'];
        }

        foreach($rapportHorsNoyau as $noyau){
            $horsNoyauHourGlobal = $horsNoyauHourGlobal + $noyau['htot'];
            $horsNoyauHourAbsencesGlobal = $horsNoyauHourAbsencesGlobal + $noyau['habs'];
            $horsNoyauHourPenibleGlobal = $horsNoyauHourPenibleGlobal + $noyau['hins'];
            $horsNoyauKmGlobal = $horsNoyauKmGlobal + $noyau['km'];
        }

         // var_dump($rapportHorsNoyau);
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