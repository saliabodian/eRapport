<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 03/11/2017
 * Time: 15:05
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

require __DIR__ . '/vendor/autoload.php';

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Config\Dsk;

use Classes\Cdcl\Db\Rapport;

$conf = Config::getInstance();

require __DIR__ . '/vendor/autoload.php';



if(!empty($_SESSION)){

    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4-L',
    ]);

    ob_start();
    //var_dump($_GET);
    //var_dump($_POST);

    // {
    // $_GET["chef_dequipe_id"]=> string(2) "67"
    // $_GET["chef_dequipe_matricule"]=> string(2) "38"
    // $_GET["date_generation"]=> string(10) "2017-10-02"
    // $_GET["chantier_id"]=> string(6) "205"
    // $_GET["chantier_code"]=> string(6) "156100"
    // }

    $_GET['validated']=isset($_GET['validated'])? $_GET['validated'] : '';

    $_GET['submitted']=isset($_GET['submitted'])? $_GET['submitted'] : '';

    $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($_GET["date_generation"], $_GET["chef_dequipe_id"], $_GET["chantier_id"]);

    $interimaireMobileList = Rapport::getInterimaireMobileByTeamSiteAndDate($_GET["date_generation"],$_GET["chantier_id"]);

    $rapportInt = Rapport::getRapportInterimaire($_GET["chef_dequipe_id"],$_GET["date_generation"] , $_GET["chantier_id"]);

    $rapportIntMob = Rapport::getRapportInterimaireMobile($_GET["date_generation"] , $_GET["chantier_id"]);

    $allAbsence = Dsk::getAllAbsence($_GET["date_generation"]);

    //  var_dump($allAbsence);

    //  exit;


    //  var_dump($interimaireList);
    //  var_dump($rapportInt);

    $siteWithItp = Chantier::getChantierActifWithItp();
    if(!empty($siteWithItp)){
        foreach($siteWithItp as $site){
            $siteWithItpId[] = $site['id'];
        }
    }
    if(!empty($siteWithItpId)){
        if (in_array($_GET['chantier_id'], $siteWithItpId)) {
            $itpActive = true;
        }else{
            $itpActive = false;
        }
    }

    $newArray = array();
    // Mise à jour du champ htot pour les intérimaires

    if(!empty($interimaireList)){
        foreach($interimaireList as $interimaire){
            foreach($rapportInt as $rapportDetailInt){
                if(($rapportDetailInt['interimaire_id']=== $interimaire['matricule']) && (($rapportDetailInt['ht1']+$rapportDetailInt['ht2']+$rapportDetailInt['ht3']+$rapportDetailInt['ht4']+$rapportDetailInt['ht5']+$rapportDetailInt['ht6']) != 0)){
                    //    var_dump($interimaire['matricule']) ;
                    Rapport::updateHtotInterimaire($interimaire['matricule']);
                }
            }
        }
    }

    if(!empty($interimaireMobileList)){
        foreach($interimaireMobileList as $interimaire){
            foreach($rapportIntMob as $rapportDetailInt){
                if(($rapportDetailInt['interimaire_id']=== $interimaire['matricule']) && (($rapportDetailInt['ht1']+$rapportDetailInt['ht2']+$rapportDetailInt['ht3']+$rapportDetailInt['ht4']+$rapportDetailInt['ht5']+$rapportDetailInt['ht6']) != 0)){
                    //    var_dump($interimaire['matricule']) ;
                    Rapport::updateHtotInterimaire($interimaire['matricule']);
                }
            }
        }
    }

    //    var_dump($interimaireList);
    //    var_dump($interimaireMobileList);

    //    exit;


    //    var_dump(strtotime($_GET["date_generation"]));

    //    var_dump(strtotime(date('Y/m/d', time())));
    //    exit;

    if($itpActive === false){
        if(strtotime($_GET["date_generation"]) != strtotime(date('Y/m/d', time()))){
            $allPointage = Dsk::getCalculTotalHoraire($_GET["date_generation"], $_GET["chantier_code"]) ;
        }
    }


    //$allPointage = Dsk::getCalculTotalHoraire($_GET["date_generation"], $_GET["chantier_code"]) ;

    //var_dump($pointage);

    //exit;

    $rapportJournalier = Rapport::get($_GET["rapport_id"]);
    //var_dump($rapportJournalier);

    // exit;
    $chefDequipeMatricule = $rapportJournalier->getChefDEquipeMatricule();
    $rapportJournalierDate = date('d-m-Y',strtotime($rapportJournalier->getDate()));

    //var_dump(date('d-m-Y',strtotime($rapportJournalierDate)));

    //exit;



    // Gestion de la regénération
    $_GET['reg'] = isset($_GET['reg'])? $_GET['reg'] : '';
    if($_GET['reg'] === "true"){

        //     var_dump($_GET);

        //    echo "je suis là";
        // Je récupére tous les éléments de manière rammassée pour refaire par la suite un check de ceux qui n'ont pas de détails

        $noyauDetails = Rapport::getRapportNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        $noyauAbsentDetails = Rapport::getRapportAbsentNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        $horsNoyauDetails = Rapport::getRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
        $absentHorsNoyauDetails = Rapport::getRapportAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule']);

        $noyauList = Dsk::getTeamPointing($_GET["chef_dequipe_matricule"], $_GET["chantier_code"], $_GET["date_generation"]);
        $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($_GET["date_generation"], $_GET["chef_dequipe_id"], $_GET["chantier_id"]);
        $interimaireMobileList = Rapport::getInterimaireMobileByTeamSiteAndDate($_GET["date_generation"],$_GET["chantier_id"]);
        $horsNoyauList = Dsk::getTeamLess($_GET["date_generation"], $_GET["chantier_code"]);
        $absentHorsNoyauList = Dsk::getAllHorsNoyauAbsence($_GET["chef_dequipe_matricule"], $_GET["date_generation"], $_GET["chantier_code"]);
        $absentList = Dsk::getAllNoyauAbsence($_GET["chef_dequipe_matricule"], $_GET["date_generation"]);

        // Créer un tableau à une dimension avec les matricules des ouvriers et interimaires
        // comparer les valeurs et voir si elles existent dans la liste détails ou l'inverse
        // cf. rapportDetail


        //var_dump($noyauAbsentDetails);
        //var_dump($horsNoyauDetails);
        // var_dump($noyauList);
        //var_dump($interimaireList);
        //var_dump($horsNoyauList);
        //var_dump($absentList);
        $newNoyauList = array();
        $oldNoyauList = array();
        $newInterimaireList = array();
        $newInterimaireMobileList = array();
        $oldInterimaireList = array();
        $oldInterimaireMobileList = array();
        $newAbsentList = array();
        $oldAbsentList = array();
        $newHorsNoyauList = array();
        $oldHorsNoyauList = array();
        $newAbsentHorsNoyauList = array();
        $oldAbsentHorsNoyauList = array();

        if(!empty($noyauList)){
            foreach($noyauList as $list){
                $newNoyauList[] = $list["matricule"];
            }
        }

        if(!empty($noyauDetails)){
            foreach($noyauDetails as $details){
                if(!empty($details['ouvrier_id'])){
                    $oldNoyauList[]=$details['ouvrier_id'];
                }
            }
        }

        $newNoyauList = array_diff($newNoyauList, $oldNoyauList);

        if(!empty($noyauList)){
            foreach($noyauList as $noyau){
                if(in_array($noyau['matricule'], $newNoyauList)){
                    $newNoyauListToAdd[$noyau['id']]['id']= $noyau['id'];
                    $newNoyauListToAdd[$noyau['id']]['matricule']= $noyau['matricule'];
                    $newNoyauListToAdd[$noyau['id']]['fullname']= $noyau['fullname'];
                    $newNoyauListToAdd[$noyau['id']]['chantier']= $noyau['chantier'];
                    $newNoyauListToAdd[$noyau['id']]['noyau']= $noyau['noyau'];
                }
            }
        }

        if(!empty($interimaireList)){
            foreach($interimaireList as $list){
                $newInterimaireList[] = $list["matricule"];
            }
        }

        if(!empty($noyauDetails)){
            foreach($noyauDetails as $details){
                if(!empty($details['interimaire_id'])){
                    $oldInterimaireList[]=$details['interimaire_id'];
                }
            }
        }

        $newIntermaireList = array_diff($newInterimaireList, $oldInterimaireList);

        //var_dump($noyauList);
        //    var_dump($newIntermaireListToAdd);
        if(!empty($interimaireList)){
            foreach($interimaireList as $interimaire){
                if(in_array($interimaire['matricule'], $newIntermaireList)){
                    $newIntermaireListToAdd[$interimaire['id']]['id'] = $interimaire['id'];
                    $newIntermaireListToAdd[$interimaire['id']]['interimaire_id'] = $interimaire['interimaire_id'];
                    $newIntermaireListToAdd[$interimaire['id']]['chantier_id'] =$interimaire['chantier_id'] ;
                    $newIntermaireListToAdd[$interimaire['id']]['user_id'] = $interimaire['user_id'];
                    $newIntermaireListToAdd[$interimaire['id']]['doy'] = $interimaire['doy'];
                    $newIntermaireListToAdd[$interimaire['id']]['woy'] = $interimaire['woy'];
                    $newIntermaireListToAdd[$interimaire['id']]['matricule'] = $interimaire['matricule'];
                    $newIntermaireListToAdd[$interimaire['id']]['lastname'] = $interimaire['lastname'];
                    $newIntermaireListToAdd[$interimaire['id']]['firstname'] = $interimaire['firstname'];
                }
            }
        }

        //Regénaration pour les intérimaires mobiles

        if(!empty($interimaireMobileList)){
            foreach($interimaireMobileList as $list){
                $newInterimaireMobileList[] = $list["matricule"];
            }
        }

        if(!empty($horsNoyauDetails)){
            foreach($horsNoyauDetails as $details){
                if(!empty($details['interimaire_id'])){
                    $oldInterimaireMobileList[]=$details['interimaire_id'];
                }
            }
        }

        //    var_dump($oldInterimaireMobileList);
        //    var_dump($newInterimaireMobileList);



        $newInterimaireMobileList = array_diff($newInterimaireMobileList, $oldInterimaireMobileList);

        //    var_dump($newInterimaireMobileList);

        //    exit;

        if(!empty($interimaireMobileList)){
            foreach($interimaireMobileList as $interimaire){
                if(in_array($interimaire['matricule'], $newInterimaireMobileList)){
                    $newIntermaireMobileListToAdd[$interimaire['id']]['id'] = $interimaire['id'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['interimaire_id'] = $interimaire['interimaire_id'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['chantier_id'] =$interimaire['chantier_id'] ;
                    $newIntermaireMobileListToAdd[$interimaire['id']]['doy'] = $interimaire['doy'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['woy'] = $interimaire['woy'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['matricule'] = $interimaire['matricule'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['lastname'] = $interimaire['lastname'];
                    $newIntermaireMobileListToAdd[$interimaire['id']]['firstname'] = $interimaire['firstname'];
                }
            }
        }



        //    var_dump($newIntermaireListToAdd);

        //  var_dump($newNoyauList);
        //    var_dump($oldNoyauList);
        if(!empty($absentList)){
            foreach($absentList as $list){
                $newAbsentList[] = $list["matricule"];
            }
        }

        if(!empty($noyauAbsentDetails)){
            foreach($noyauAbsentDetails as $details){
                $oldAbsentList[]=$details['ouvrier_id'];
            }
        }


        $newAbsentList = array_diff($newAbsentList, $oldAbsentList);

        if(!empty($newAbsentList)){
            foreach($newAbsentList as $absent){
                if(in_array($absent['matricule'], $newNoyauList)){
                    $newAbsentListToAdd[$absent['matricule']]['matricule']= $absent['matricule'];
                    $newAbsentListToAdd[$absent['matricule']]['fullname']= $absent['fullname'];
                    $newAbsentListToAdd[$absent['matricule']]['date']= $absent['date'];
                    $newAbsentListToAdd[$absent['matricule']]['timemin']= $absent['timemin'];
                    $newAbsentListToAdd[$absent['matricule']]['motif']= $absent['motif'];
                }
            }
        }

        //var_dump($newAbsentListToAdd);
        if(!empty($horsNoyauList)){
            foreach($horsNoyauList as $list){
                $newHorsNoyauList[] = $list["matricule"];
            }
        }

        if(!empty($horsNoyauDetails)){
            foreach($horsNoyauDetails as $details){
                $oldHorsNoyauList[]=$details['ouvrier_id'];
            }
        }


        $newHorsNoyauList = array_diff($newHorsNoyauList, $oldHorsNoyauList);
        if(!empty($horsNoyauList)){
            foreach($horsNoyauList as $horsNoyau){
                if(in_array($horsNoyau['matricule'], $newHorsNoyauList)){
                    $newHorsNoyauListToAdd[$horsNoyau['id']]['id']= $horsNoyau['id'];
                    $newHorsNoyauListToAdd[$horsNoyau['id']]['matricule']= $horsNoyau['matricule'];
                    $newHorsNoyauListToAdd[$horsNoyau['id']]['fullname']= $horsNoyau['fullname'];
                    $newHorsNoyauListToAdd[$horsNoyau['id']]['']= $horsNoyau['chantier'];
                    $newHorsNoyauListToAdd[$horsNoyau['id']]['noyau']= $horsNoyau['noyau'];
                }
            }
        }

        // $newAbsentHorsNoyauList
        // $oldAbsentHorsNoyauList
        //$absentHorsNoyauDetails
        //$absentHorsNoyauList

        if(!empty($absentHorsNoyauList)){
            foreach($absentHorsNoyauList as $list){
                $newAbsentHorsNoyauList[] = $list["matricule"];
            }
        }

        if(!empty($absentHorsNoyauDetails)){
            foreach($absentHorsNoyauDetails as $details){
                $oldAbsentHorsNoyauList[]=$details['ouvrier_id'];
            }
        }


        $newAbsentHorsNoyauList = array_diff($newAbsentHorsNoyauList, $oldAbsentHorsNoyauList);
        if(!empty($absentHorsNoyauList)){
            foreach($absentHorsNoyauList as $horsNoyau){
                if(in_array($horsNoyau['matricule'], $newAbsentHorsNoyauList)){
                    $newAbsentHorsNoyauListToAdd[$horsNoyau['id']]['id']= $horsNoyau['id'];
                    $newAbsentHorsNoyauListToAdd[$horsNoyau['id']]['matricule']= $horsNoyau['matricule'];
                    $newAbsentHorsNoyauListToAdd[$horsNoyau['id']]['fullname']= $horsNoyau['fullname'];
                    $newAbsentHorsNoyauListToAdd[$horsNoyau['id']]['chantier']= $horsNoyau['chantier'];
                    $newAbsentHorsNoyauListToAdd[$horsNoyau['id']]['noyau']= $horsNoyau['noyau'];
                }
            }
        }

        //    var_dump($newNoyauListToAdd);
        //    var_dump($newIntermaireListToAdd);
        //    var_dump($newAbsentListToAdd);
        //    var_dump($newHorsNoyauListToAdd);

        if(!empty($newNoyauListToAdd)){
            Rapport::saveRapportDetail($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule'], $newNoyauListToAdd);
        }

        if(!empty($newIntermaireListToAdd)){
            Rapport::saveRapportDetailInterimaire($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule'], $newIntermaireListToAdd);
        }
        if(!empty($newAbsentListToAdd)){
            Rapport::saveRapportDetailAbsent($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule'], $newAbsentListToAdd);
        }

        if(!empty($newHorsNoyauListToAdd)){
            Rapport::saveRapportDetailHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $newHorsNoyauListToAdd);
        }

        if(!empty($newAbsentHorsNoyauListToAdd)){
            Rapport::saveRapportDetailAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $newAbsentHorsNoyauListToAdd, $_GET['chef_dequipe_matricule']);
        }
        if(!empty($newIntermaireMobileListToAdd)){
            Rapport::saveRapportDetailInterimaireMobile($_GET['date_generation'], $_GET['chantier_id'],$newIntermaireMobileListToAdd);
        }
    }


    //    exit;


    $noyau = Rapport::getRapportNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $noyauAbsent = Rapport::getRapportAbsentNoyau($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    $horsNoyau = Rapport::getRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
    $absentHorsNoyau = Rapport::getRapportAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule']);
    //var_dump($horsNoyau);
    //exit;

    if($itpActive === false){
        if(!empty($absentHorsNoyau)){
            if(!empty($allAbsence)){
                foreach($allAbsence as $pointage){
                    foreach($absentHorsNoyau as $rapport){
                        if($rapport['ouvrier_id']=== $pointage['matricule']){
                            Rapport::setHorsNoyauHourCalculated($pointage['timemin']/60, $rapport['id']);
                        }
                    }
                }
            }
        }
    }




    // Mise à jour des heures pointées au niveau des différentes matrices générées
    if($itpActive === false){
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
            /****
            Plus besoin de mettre à jour le htot des absents du noyau car cette valeur est retournée par la fonction établie sous la requête de DSK
            foreach($allPointage as $pointage){
            foreach($noyauAbsent as $rapport){
            if($rapport['ouvrier_id']=== $pointage['matricule']){
            Rapport::setWorkerHourCalculated($pointage['hpoint'], $rapport['id']);
            }
            }
            }
             ****/
            /*
            foreach($allPointage as $pointage){
                foreach($absentHorsNoyau as $rapport){
                    if($rapport['ouvrier_id']=== $pointage['matricule']){
                        Rapport::setHorsNoyauHourCalculated($pointage['timemin'], $rapport['id']);
                    }
                }
            }
            */

            foreach($allPointage as $pointage){
                foreach($horsNoyau as $rapport){
                    if($rapport['ouvrier_id'] === $pointage['matricule']){
                        Rapport::setWorkerHourCalculated($pointage['hpoint'], $rapport['id']);
                    }
                }
            }
        }
    }


    // Récupération des ids des différents rapports générés absents à savoir ceux du noyau, les absents et les hors noyaux

    //    $i = 0;

    for($i=0; $i<1; $i++){
        if(!empty($noyau)){
            $idRapportNoyau = $noyau[$i]['rapport_id'];
        }
        if(!empty($noyauAbsent)){
            $idRapportAbsentNoyau = $noyauAbsent[$i]['rapport_id'];
        }
        if(!empty($horsNoyau)){
            $idRapportHorsNoyau = $horsNoyau[$i]['rapport_id'];
        }
        if(!empty($absentHorsNoyau)){
            $idRapportAbsentHorsNoyau = $absentHorsNoyau[$i]['rapport_id'];
        }
    }

    //var_dump($idRapportNoyau);
    //var_dump($idRapportAbsentNoyau);
    //var_dump($idRapportHorsNoyau);

    //exit;

    if(!empty($idRapportNoyau)){
        $noyauHeader = Rapport::getRapportNoyauHeader($idRapportNoyau, $_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    }

    if(!empty($idRapportAbsentNoyau)){
        $noyauAbsentHeader = Rapport::getRapportAbsentNoyauHeader($idRapportAbsentNoyau,$_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    }

    if(!empty($idRapportHorsNoyau)){
        $horsNoyauHeader = Rapport::getRapportHorsNoyauHeader($idRapportHorsNoyau, $_GET['date_generation'], $_GET['chantier_id']);
    }

    if(!empty($idRapportAbsentHorsNoyau)){
        $absentHorsNoyauHeader = Rapport::getRapportAbsentHorsNoyauHeader($idRapportAbsentHorsNoyau, $_GET['date_generation'], $_GET['chantier_id']);
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

    foreach($absentHorsNoyau as $horsNoyauDetail){
        $absentHorsNoyauTask[$horsNoyauDetail['id']] = Rapport::getWorkerTask($horsNoyauDetail['id']);
        $absentHorsNoyauTaskDetail[$horsNoyauDetail['id']] = Rapport::getWorkerTaskDetail($horsNoyauDetail['id']);
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
    $rapportAbsentHorsNoyau = Rapport::getRapportAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule']);

    //    var_dump($rapportHorsNoyau);

    //    exit;

    $noyauHourGlobal = 0;
    $horsNoyauHourGlobal = 0;
    $absentHourGlobal = 0;
    $absentHorsNoyauHourGlobal = 0;


    $noyauHourAbsencesGlobal = 0;
    $horsNoyauHourAbsencesGlobal = 0;
    $absentHourAbsencesGlobal = 0;
    $absentHorsNoyauHourAbsencesGlobal = 0;

    $noyauHourPenibleGlobal = 0;
    $horsNoyauHourPenibleGlobal = 0;
    $absentHourPenibleGlobal = 0;
    $absentHorsNoyauHourPenibleGlobal = 0;

    $noyauKmGlobal = 0;
    $horsNoyauKmGlobal = 0;
    $absentKmGlobal = 0;
    $absentHorsNoyauKmGlobal = 0;

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

    foreach($rapportAbsentHorsNoyau as $noyau){
        $absentHorsNoyauHourGlobal = $absentHorsNoyauHourGlobal + $noyau['htot'];
        $absentHorsNoyauHourAbsencesGlobal = $absentHorsNoyauHourAbsencesGlobal + $noyau['habs'];
        $absentHorsNoyauHourPenibleGlobal = $absentHorsNoyauHourPenibleGlobal + $noyau['hins'];
        $absentHorsNoyauKmGlobal = $absentHorsNoyauKmGlobal + $noyau['km'];
    }

    // var_dump($rapportHorsNoyau);
    // var_dump($rapportNoyauAbsent);
    // var_dump($rapportHorsNoyau);
    // exit;
    $_GET['erreur'] = isset($_GET['erreur'])? $_GET['erreur'] : '';
    if($_GET['erreur']){
        $conf->addError('Veuillez sélectionner au moins un Ouvrier / Intérimaire avant de remplir les tâches');
    }

    $_GET['isValid'] = isset($_GET['isValid'])? $_GET['isValid'] : '';
    if($_GET['isValid']==='false'){
        $conf->addError('Merci de confirmer la validité des informations.');
    }


    include $conf->getViewsDir().'eRapportShowPrint.php';
//    include $conf->getViewsDir().'footer.php';



    $html = ob_get_contents();

    ob_end_clean();




// $html = file_get_contents($conf->getViewsDir().'eRapportShowPrint.php');

    $mpdf->WriteHTML($html);
    $mpdf->Output('E-Rapport_du_'.$rapportJournalierDate.'_noyau_'.$chefDequipeMatricule.'_chantier_'.$_GET['chantier_code'].'.pdf',\Mpdf\Output\Destination::DOWNLOAD);

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