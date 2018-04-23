<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 10:57
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

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Config\Dsk;

use Classes\Cdcl\Db\Rapport;

$conf = Config::getInstance();

if(!empty($_SESSION)){


    // var_dump($_SESSION['post_id'] );

    // exit;
    //Gestion de la validation d'un rapport
    $_GET['val'] = isset($_GET['val'])? $_GET['val'] : '';
    if($_GET['val']=== 'true'){
      if(isset($_GET['isValid'])) {
          if($_SESSION['post_id']=== '1'){
              Rapport::submittRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
              $submitted= Rapport::checkAllRapportSubmitted($_GET['date_generation'], $_GET['chantier_id']);
              if($submitted === false){
                    Rapport::submittHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
              }
          }else{
              Rapport::submittRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
              Rapport::validateRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
              $submitted= Rapport::checkAllRapportSubmitted($_GET['date_generation'], $_GET['chantier_id']);
              $validated = Rapport::checkAllRapportValidated($_GET['date_generation'], $_GET['chantier_id']);
              if($submitted === false && $validated === false){
                  Rapport::submittHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
                  Rapport::validateHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
              }
          }

      }else{
          header('Location: erapportShow.php?rapport_id='.$_GET['rapport_id'].'&rapport_type='.$_GET['rapport_type'].'&chef_dequipe_id='.$_GET['chef_dequipe_id'].'&chef_dequipe_matricule='.$_GET['chef_dequipe_matricule'].'&date_generation='.$_GET['date_generation'].'&chantier_id='.$_GET['chantier_id'].'&chantier_code='.$_GET['chantier_code'].'&isValid=false');

        //  var_dump($conf);
          exit;
      }
    }

    //Gestion de l'invalidation d'un rapport
    $_GET['inval'] = isset($_GET['inval'])? $_GET['inval'] : '';
    if($_GET['inval']=== 'true'){
    //    var_dump($_GET);
        Rapport::inValidateRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        Rapport::unValidateHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);

    }


    //Gestion de la suppression d'un rapport
    $_GET['sup'] = isset($_GET['sup'])? $_GET['sup'] : '';
    if($_GET['sup']=== 'true'){

        Rapport::deleteRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        Rapport::deleteRapportAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule']);
        //    exit;

        $deleted = Rapport::checkAllRapportDeleted($_GET['date_generation'], $_GET['chantier_id']);


        if($deleted === true){
            Rapport::deleteRapportHorsNoyau($_GET['date_generation'], $_GET['chantier_id']);
        }

    //    var_dump($deleted);
    //    exit;
    }


    // var_dump($_SESSION);
   // Pourra servir pour repérer le rôle de l'utilisateur connecté
    $chantierId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $chefDEquipeList[$_SESSION['id']] =  '';

   // var_dump($chantierId);

    $chantierObject = new Chantier();

    // var_dump($chantierObject);

    $chantierList = Chantier::getAllForSelect();


    // Nombre de chefs d'équipe affectés sur ce chantier pour la gestion de la génération des rapports
    $teamLeaderAffectedOnSite = isset($teamLeaderAffectedOnSite)? $teamLeaderAffectedOnSite : '';

    if($_SESSION['post_id'] === '1'){

        $chefDEquipeList[$_SESSION['id']] =  $_SESSION['username'].' '.$_SESSION['firstname'].' '.$_SESSION['lastname'];
    }else{
        if(!empty($chantierId)){

            // Liste des chantiers affectés à un chef d'équipe dépendament qu'il soit présent ou non
            $chefDEquipeList = User::getAllForSelectChefDEquipebyChantier($chantierId);
            $teamLeaderAffectedOnSite = count($chefDEquipeList);
        }
    }


    //var_dump($teamLeaderAffectedOnSite);
    //exit;


    if ($chantierId > 0) {
        $chantierObject = Chantier::get($chantierId);
    //    print_r($chantierObject);
    }

    // var_dump($chantierId);

    $chantierList = User::listChantierByUserForSelect($_SESSION['id']);

    $nbChantierUserAffected = (count($chantierList));

    // var_dump($nbChantierUserAffected);

    $chefDEquipeObject = new User();



//
//    var_dump($res);

//    var_dump(Rapport::getRapportGeneratedForConducteur($chant));

//    exit;

 //   $chantierGen = Rapport::getRapportGeneratedForConducteur($chantierListId);
    /*var_dump($chantierListId);
    //var_dump($chantierGen);
        foreach($chantierListId as $chantier) {
            $chantierGenerated[] = Rapport::getRapportGeneratedForConducteur($chantier['chantier_id']);
        }
    var_dump($chantierGenerated);
    exit;
*/
    if(!empty($_POST)){
    //    var_dump($_POST);
    //    exit;
        $chantierId = isset($_POST['chantier_id'])? $_POST['chantier_id']: 0;
        $chefDEquipeId = isset($_POST['user_id'])? $_POST['user_id'] : 0;
        $dateRapport = isset($_POST['date_gen'])? date('Y-m-d',strtotime($_POST['date_gen'])) : 0;
        $today = date('Y-m-d', time());
        $teamLeaderMissing = isset($_POST['missing'])? $_POST['missing'] : "";
        $form = true;



        // var_dump($chantierId);
        // exit;
        if(empty($_POST['chantier_id'])){
            $conf->addError('Merci de renseigner le chantier.');
            $form = false;
        }

        if(empty($_POST['user_id'])){
            $conf->addError('Merci de choisir le chef d\'équipe pour lequel vous voulez générer.');
            $form = false;
        }

        if(empty($_POST['date_gen'])){
            $conf->addError('Merci de définir la date de génération du rapport.');
            $form = false;
        }

        if($dateRapport > $today){
            $conf->addError(' Aucun rapport ne peut être généré pour cette date');
            $form=false;
        }


        $chantier = Chantier::get($chantierId);

        $chefDequipeConnected = User::get($chefDEquipeId);
        $chantierCode = $chantier->getCode();
        $matricule = $chefDequipeConnected->getUsername();

        // je récupére tous les chefs d'équipe du jour sur site indépendemment qu'il(s) ait(ent) badgé(s) ou pas
        if(!empty($chantierCode) && !empty($dateRapport)){
            $teamLeaderOnsite = Dsk::getChefDEquipeOnsiteByDay($chantierCode, $dateRapport);
        }

    //    var_dump($teamLeaderOnsite);



        // Je récupére le noyau du chef d'équipe pour lequel nous voulons générer le rapport
        if(!empty($teamLeaderOnsite)){
            foreach($teamLeaderOnsite as $teamLeader){
                if (in_array($matricule,$teamLeader)){
                    $noyau = $teamLeader['noyau'];
                }
            }
        }

    //    var_dump($noyau);



        // Vérification de l'existence des différents rapports

        $rjNoyauExist = Rapport::checkChefDEquipeRapportExist($dateRapport, $chantierId, $matricule);

        $rjAbsentNoyauExist = Rapport::checkRapportAbsentExist($dateRapport, $chantierId, $matricule);

    //    var_dump($rjNoyauExist);
    //    var_dump($rjAbsentNoyauExist);




        if($rjAbsentNoyauExist===true || $rjNoyauExist === true){
            $conf->addError('Le rapport a déjà été généré.');
            $form = false;
        }
    //    var_dump($form);
    //    exit;

        /////////////////////////////////////////////////////////////////////////////
        //Génération du rapport journalier si le chef d'équipe est présent///////////
        /////////////////////////////////////////////////////////////////////////////
        if($form && empty($teamLeaderMissing)){

            $rapportId = isset($rapportId)? $rapportId : "";
            $terminal = isset($terminal)? $terminal : "";
            $rapportType = isset($rapportType)? $rapportType : "";
            $preremp = isset($preremp)? $preremp : "";
            $submitted = isset($submitted)? $submitted : "";
            $validated = isset($validated)? $validated : "";
            $deleted = isset($deleted)? $deleted : "";

            //    echo "je suis la";

            //    exit;

            // var_dump(new User($chefDEquipeId));


            // exit;
            $noyauObject = new Rapport(
                $rapportId,
                $dateRapport,
                $terminal,
                new Chantier($chantierId),
                new User($chefDEquipeId),
                $matricule,
                $rapportType,
                $preremp,
                $submitted,
                $validated,
                $deleted
            );

            // var_dump($noyauObject);
            // Génération du rapport du NOYAU pour le chef d'équipe connecté ou pour celui qu'on a choisi (si on est admin ou RH)

            // Génération d'un rapport pour les ouvriers absents appartenant au chef d'équipe connecté

            $absentList = Dsk::getAllNoyauAbsence($matricule, $dateRapport);
        //    var_dump($absentList);
            if(!empty($absentList)){
                $noyauObject->saveDBAbsentDuNoyau();
                $rapportJournalierAbsent = Rapport::saveRapportDetailAbsent($dateRapport, $chantierId, $matricule, $absentList);
            }

            $noyauList = Dsk::getTeamPointing($matricule, $chantierCode, $dateRapport);
            $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($dateRapport, $chefDEquipeId, $chantierId);


            // Même si le chef d'équipe il n'existe pas de membre de son équipe (ouvrier + interimaire)
            // Je génére une ligne pour le chef d'équipe connecté ou celui pour lequel on veut générer le rapport
            // pour pouvoir lui rattacher au moins les hors noyaux

            $noyauObject->saveDB();

            // On génére pour le chef d'équipe en question les détails respectifs si ils existent

            if(!empty($noyauList)){
                $rapportJournalierNoyau = Rapport::saveRapportDetail($dateRapport, $chantierId, $matricule, $noyauList);
            }

            if(!empty($interimaireList)){
                $rapportJournalierInterimaire = Rapport::saveRapportDetailInterimaire($dateRapport, $chantierId, $matricule, $interimaireList);
            }

            // Génération des rapports HORSNOYAU et ABSENTHORSNOYAU pour tous les chefs d'équipe.
            // NB : ce rapport n'est généré qu'une seule fois quelque soit le chef d'équipe
            // C'est le premier chef d'équipe ou celui pour lequel on génére un rapport
            // Qui entraine la génération du HORS NOYAU
            // Cependant Avant de générer le hors noyau on s'assure qu'il n'a pas déjà été généré

            $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);

            if($rjHorsNoyauExist === false){
                $horsNoyauList = Dsk::getTeamLess($dateRapport, $chantierCode);
                if(!empty($horsNoyauList)){
                    $noyauObject->saveDBHorsNoyau();
                    $rapportJournalierHorsNoyau = Rapport::saveRapportDetailHorsNoyau($dateRapport, $chantierId, $horsNoyauList);
                }
                $interimaireMobileList = Rapport::getInterimaireMobileByTeamSiteAndDate($dateRapport, $chantierId);
                if(!empty($interimaireMobileList)){
                    $rapportJournalierInterimnaireMobile = Rapport::saveRapportDetailInterimaireMobile($dateRapport, $chantierId, $interimaireMobileList);
                }
            }

            $rjAbsentHorsNoyauExist = Rapport::checkrapportAbsentHorsNoyauExist($dateRapport, $chantierId, $matricule);

            //    var_dump($rjAbsentHorsNoyauExist);

            //    exit;
            // problème
            if($rjAbsentHorsNoyauExist === false){
                $absentHorsNoyauList = Dsk::getAllHorsNoyauAbsence($matricule,$dateRapport, $chantierCode);
                //  var_dump($absentHorsNoyauList);
                //  exit;
                if(!empty($absentHorsNoyauList)){
                    $noyauObject->saveDBAbsentHorsNoyau();
                    $rapportJournalierAbsentHorsNoyau = Rapport::saveRapportDetailAbsentHorsNoyau($dateRapport, $chantierId, $absentHorsNoyauList, $matricule);
                }
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////
        ////////      Génération du rapport journalier si le chef d'équipe est abssent ///////
        ////////     AVEC UN SEUL CHEF D'EQUIPE SUR CHANTIER                            ///////
        /////////////////////////////////////////////////////////////////////////////////////

        if(!empty($teamLeaderMissing) && ($teamLeaderAffectedOnSite<= 1) && $form){


            $rapportId = isset($rapportId)? $rapportId : "";
            $terminal = isset($terminal)? $terminal : "";
            $rapportType = isset($rapportType)? $rapportType : "";
            $preremp = isset($preremp)? $preremp : "";
            $submitted = isset($submitted)? $submitted : "";
            $validated = isset($validated)? $validated : "";
            $deleted = isset($deleted)? $deleted : "";

            // exit;
            $noyauObject = new Rapport(
                $rapportId,
                $dateRapport,
                $terminal,
                new Chantier($chantierId),
                new User($chefDEquipeId),
                $matricule,
                $rapportType,
                $preremp,
                $submitted,
                $validated,
                $deleted
            );

            // var_dump($noyauObject);
            // Génération du rapport du NOYAU pour le chef d'équipe connecté ou pour celui qu'on a choisi (si on est admin ou RH)

            //Génération d'un rapport pour les ouvriers absents appartenant au chef d'équipe connecté



        //    $noyauList = Dsk::getTeamPointing($matricule, $chantierCode, $dateRapport);
            $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($dateRapport, $chefDEquipeId, $chantierId);


            // Même si le chef d'équipe il n'existe pas de membre de son équipe (ouvrier + interimaire)
            // Je génére une ligne pour le chef d'équipe connecté ou celui pour lequel on veut générer le rapport
            // pour pouvoir lui rattacher au moins les hors noyaux



            $noyauObject->saveDB();


            // On génére pour le chef d'équipe en question les détails respectifs si ils existent
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //    if(!empty($noyauList)){                                                                                           //////////////
        //        $rapportJournalierNoyau = Rapport::saveRapportDetail($dateRapport, $chantierId, $matricule, $noyauList);      //////////////
        //    }                                                                                                                 //////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

           if(!empty($interimaireList)){
                $rapportJournalierInterimaire = Rapport::saveRapportDetailInterimaire($dateRapport, $chantierId, $matricule, $interimaireList);
            }

            // Génération des rapports HORSNOYAU et ABSENTHORSNOYAU pour tous les chefs d'équipe.
            // NB : ce rapport n'est généré qu'une seule fois quelque soit le chef d'équipe
            // C'est le premier chef d'équipe ou celui pour lequel on génére un rapport
            // Qui entraine la génération du HORS NOYAU
            // Cependant Avant de générer le hors noyau on s'assure qu'il n'a pas déjà été généré

            $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);


            if($rjHorsNoyauExist === false){
            //    echo "je suis la 2";
            //    exit;
            $noyauObject->saveDBHorsNoyau();

                $horsNoyauList = Dsk::getTeamLess($dateRapport, $chantierCode);
                $interimaireMobileList = Rapport::getInterimaireMobileByTeamSiteAndDate($dateRapport, $chantierId);

                //var_dump($interimaireMobileList);

                //exit;



                if(!empty($horsNoyauList)){
                    $rapportJournalierHorsNoyau = Rapport::saveRapportDetailHorsNoyau($dateRapport, $chantierId, $horsNoyauList);
                }
            //    var_dump($rapportJournalierHorsNoyau);
            //    exit;
                if(!empty($interimaireMobileList)){
                    $rapportJournalierInterimnaireMobile = Rapport::saveRapportDetailInterimaireMobile($dateRapport, $chantierId, $interimaireMobileList);
                }
            }


        //    exit;

            $absentList = Dsk::getAllNoyauAbsence($matricule, $dateRapport);

            if(!empty($absentList)){
                $noyauObject->saveDBAbsentDuNoyau();
                $rapportJournalierAbsent = Rapport::saveRapportDetailAbsent($dateRapport, $chantierId, $matricule, $absentList);
            }


            $rjAbsentHorsNoyauExist = Rapport::checkrapportAbsentHorsNoyauExist($dateRapport, $chantierId, $matricule);

            //    var_dump($rjAbsentHorsNoyauExist);

            //    exit;
            // problème
            if($rjAbsentHorsNoyauExist === false){
                $absentHorsNoyauList = Dsk::getAllHorsNoyauAbsence($matricule,$dateRapport, $chantierCode);
                //    var_dump($absentHorsNoyauList);
                //  exit;
                if(!empty($absentHorsNoyauList)){
                    $noyauObject->saveDBAbsentHorsNoyau();
                    $rapportJournalierAbsentHorsNoyau = Rapport::saveRapportDetailAbsentHorsNoyau($dateRapport, $chantierId, $absentHorsNoyauList, $matricule);
                }
            }
        }
         //////////////////////////////////////////////////////////////////////////////////////////////
        /////////   Génération du rapport journalier si le chef d'équipe est abssent  /////////////////
        /////////    MAIS QU'IL Y PLUSIEURS CHEFS D'EQUIPE SUR CHANTIER               /////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////
        if(!empty($teamLeaderMissing) && ($teamLeaderAffectedOnSite > 1 ) && $form){



            $rapportId = isset($rapportId)? $rapportId : "";
            $terminal = isset($terminal)? $terminal : "";
            $rapportType = isset($rapportType)? $rapportType : "";
            $preremp = isset($preremp)? $preremp : "";
            $submitted = isset($submitted)? $submitted : "";
            $validated = isset($validated)? $validated : "";
            $deleted = isset($deleted)? $deleted : "";

            //    echo "je suis la";

            //    exit;

            //var_dump(new User($chefDEquipeId));


            // exit;
            $noyauObject = new Rapport(
                $rapportId,
                $dateRapport,
                $terminal,
                new Chantier($chantierId),
                new User($chefDEquipeId),
                $matricule,
                $rapportType,
                $preremp,
                $submitted,
                $validated,
                $deleted
                );

            // var_dump($noyauObject);
            // Génération du rapport du NOYAU pour le chef d'équipe connecté ou pour celui qu'on a choisi (si on est admin ou RH)

            // Génération d'un rapport pour les ouvriers absents appartenant au chef d'équipe connecté

            $absentList = Dsk::getAllNoyauAbsence($matricule, $dateRapport);

            if(!empty($absentList)){
                $noyauObject->saveDBAbsentDuNoyau();
                $rapportJournalierAbsent = Rapport::saveRapportDetailAbsent($dateRapport, $chantierId, $matricule, $absentList);
            }

        //    $noyauList = Dsk::getTeamPointing($matricule, $chantierCode, $dateRapport);
            $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($dateRapport, $chefDEquipeId, $chantierId);

        //    var_dump($interimaireList);

        //    exit;


            // Même si le chef d'équipe il n'existe pas de membre de son équipe (ouvrier + interimaire)
            // Je génére une ligne pour le chef d'équipe connecté ou celui pour lequel on veut générer le rapport
            // pour pouvoir lui rattacher au moins les hors noyaux

            $noyauObject->saveDB();

            // On génére pour le chef d'équipe en question les détails respectifs si ils existent
            /****************************************************************************************************************************/
            /*    if(!empty($noyauList)){                                                                                               */
                    /*        $rapportJournalierNoyau = Rapport::saveRapportDetail($dateRapport, $chantierId, $matricule, $noyauList);  */
            /*    }                                                                                                                     */
            /****************************************************************************************************************************/

            if(!empty($interimaireList)){
                $rapportJournalierInterimaire = Rapport::saveRapportDetailInterimaire($dateRapport, $chantierId, $matricule, $interimaireList);
            }

            // Génération des rapports HORSNOYAU et ABSENTHORSNOYAU pour tous les chefs d'équipe.
            // NB : ce rapport n'est généré qu'une seule fois quelque soit le chef d'équipe
            // C'est le premier chef d'équipe ou celui pour lequel on génére un rapport
            // Qui entraine la génération du HORS NOYAU
            // Cependant Avant de générer le hors noyau on s'assure qu'il n'a pas déjà été généré

            $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);

            if($rjHorsNoyauExist === false){
                $horsNoyauList = Dsk::getTeamLess($dateRapport, $chantierCode);
                $interimaireMobileList = Rapport::getInterimaireMobileByTeamSiteAndDate($dateRapport, $chantierId);
                if(!empty($horsNoyauList)){
                    $noyauObject->saveDBHorsNoyau();
                    $rapportJournalierHorsNoyau = Rapport::saveRapportDetailHorsNoyau($dateRapport, $chantierId, $horsNoyauList);
                }
                if(!empty($interimaireMobileList)){
                    $rapportJournalierInterimnaireMobile = Rapport::saveRapportDetailInterimaireMobile($dateRapport, $chantierId, $interimaireMobileList);
                }
            }

            $rjAbsentHorsNoyauExist = Rapport::checkrapportAbsentHorsNoyauExist($dateRapport, $chantierId, $matricule);

            //    var_dump($rjAbsentHorsNoyauExist);

            //    exit;
            // problème
            if($rjAbsentHorsNoyauExist === false){
                $absentHorsNoyauList = Dsk::getAllHorsNoyauAbsence($matricule,$dateRapport, $chantierCode);
                if(!empty($absentHorsNoyauList)){
                    $noyauObject->saveDBAbsentHorsNoyau();
                    $rapportJournalierAbsentHorsNoyau = Rapport::saveRapportDetailAbsentHorsNoyau($dateRapport, $chantierId, $absentHorsNoyauList, $matricule);
                }
            }
        }
    }



    if($_SESSION['post_id'] === "3"){

        $rapportGeneratedList = Rapport::getRapportGeneratedForConducteur($_SESSION['id']);
        $rapportSubmittedList = Rapport::getRapportSubmittedForConducteur($_SESSION['id']);
        $rapportValidatedList = Rapport::getRapportValidatedForConducteur($_SESSION['id']);
    }else if($_SESSION['post_id']=== "1"){
        $rapportGeneratedList = Rapport::getRapportGeneratedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportSubmittedList = Rapport::getRapportSubmittedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportValidatedList = Rapport::getRapportValidatedForChefDEquipe($_SESSION['id'], $_SESSION['username']);

        //var_dump($rapportValidatedList);
    }else{
        $rapportGeneratedList = Rapport::getRapportGenerated();
        $rapportSubmittedList = Rapport::getRapportSubmitted();
        $rapportValidatedList = Rapport::getRapportValidated();
    }

    $chefDequipe = new User();
    $chantierSelected = $chantierObject->get($chantierId);
    if(!empty($chefDEquipeId)){
        $chefDequipeSelected = $chefDequipe->get($chefDEquipeId);
    }


    $selectChantier = new SelectHelper($chantierList, $chantierId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    $selectChefDEquipe = new SelectHelper($chefDEquipeList, $chefDEquipeObject->getUsername(), array(
        'name' => 'user_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'erapport.php';
    include $conf->getViewsDir().'footer.php';

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