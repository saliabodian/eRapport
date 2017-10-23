<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 10:57
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

    //var_dump($_SESSION);
    //Gestion de la validation d'un rapport
    if($_GET['val']=== 'true'){
    //    var_dump($_GET);
        Rapport::validateRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
    //    exit;
    }

    //Gestion de l'invalidation d'un rapport
    if($_GET['inval']=== 'true'){
        //    var_dump($_GET);
        Rapport::inValidateRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        //    exit;
    }

    //Gestion de la suppression d'un rapport
    if($_GET['sup']=== 'true'){
        //    var_dump($_GET);
        Rapport::deleteRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        //    exit;
    }


    // var_dump($_SESSION);
   // Pourra servir pour repérer le rôle de l'utilisateur connecté
    $chantierId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $chantierObject = new Chantier();

    // var_dump($chantierObject);

    $chantierList = Chantier::getAllForSelect();

    if($_SESSION['post_id'] === '1'){
        $chefDEquipeList[] =  $_SESSION['username'].' '.$_SESSION['firstname'].' '.$_SESSION['lastname'];
    }else{
        $chefDEquipeList = User::getAllForSelectChefDEquipebyChantier($chantierId);
    }



    if ($chantierId > 0) {
        $chantierObject = Chantier::get($chantierId);
    //    print_r($chantierObject);
    }

    // var_dump($chantierId);

    $chantierList = User::listChantierByUserForSelect($_SESSION['id']);

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
        //var_dump($_POST);

        $chantierId = isset($_POST['chantier_id'])? $_POST['chantier_id']: 0;
        $chefDEquipeId = isset($_POST['user_id'])? $_POST['user_id'] : 0;
        $dateRapport = isset($_POST['date_gen'])? date('Y-m-d',strtotime($_POST['date_gen'])) : 0;
        $today = date('Y-m-d', time());
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

    //    var_dump($chefDEquipeList);
    //    exit;

     //   var_dump($teamLeaderOnsite);

        // je récupére tous les chefs d'équipe du jour sur site
        $teamLeaderOnsite = Dsk::getChefDEquipeOnsiteByDay($chantierCode, $dateRapport);

     //   var_dump($teamLeaderOnsite);
     //   exit;


        // Je récupére le noyau du chef d'équipe pour lequel nous voulons générer le rapport
        if(!empty($teamLeaderOnsite)){
            foreach($teamLeaderOnsite as $teamLeader){
                if (in_array($matricule,$teamLeader)){
                    $noyau = $teamLeader['noyau'];
                }
            }
        }


        // Vérification de l'existence des différents rapports

        $rjNoyauExist = Rapport::checkChefDEquipeRapportExist($dateRapport, $chantierId, $noyau);

        $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);

        $rjAbsentNoyauExist = Rapport::checkRapportAbsentExist($dateRapport, $chantierId, $noyau);

        if($rjAbsentNoyauExist===true || $rjNoyauExist === true){
            $conf->addError('Le rapport a déjà été généré.');
            $form = false;
        }


        if($form){
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

            $noyauList = Dsk::getTeamPointing($matricule, $chantierCode, $dateRapport);
            $interimaireList = Rapport::getInterimaireByTeamSiteAndDate($dateRapport, $chefDEquipeId, $chantierId);

            // var_dump($interimaireList);

            // exit;

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

            // Génération du rapport HORS NOYAU pour tous les chefs d'équipe.
            // NB : ce rapport n'est généré qu'une seule fois quelque soit le chef d'équipe
            // C'est le premier chef d'équipe ou celui pour lequel on génére un rapport
            // Qui entraine la génération du HORS NOYAU
            // Cependant Avant de générer le hors noyau on s'assure qu'il n'a pas déjà été généré

            if($rjHorsNoyauExist === false){
                $horsNoyauList = Dsk::getTeamLess($dateRapport, $chantierCode);
                if(!empty($horsNoyauList)){
                    $noyauObject->saveDBHorsNoyau();
                    $rapportJournalierHorsNoyau = Rapport::saveRapportDetailHorsNoyau($dateRapport, $chantierId, $horsNoyauList);
                }
            }


            // Génération d'un rapport pour les ouvriers absents appartenant au chef d'équipe connecté

            $absentList = Dsk::getAllNoyauAbsence($matricule, $dateRapport);
            if(!empty($absentList)){
                $noyauObject->saveDBAbsentDuNoyau();
                $rapportJournalierAbsent = Rapport::saveRapportDetailAbsent($dateRapport, $chantierId, $matricule, $absentList);
            }

        }
    }



    if($_SESSION['post_id'] === "5"){

        $rapportGeneratedList = Rapport::getRapportGeneratedForConducteur($_SESSION['id']);
        $rapportSubmittedList = Rapport::getRapportSubmittedForConducteur($_SESSION['id']);
        $rapportValidatedList = Rapport::getRapportValidatedForConducteur($_SESSION['id']);
    }else if($_SESSION['post_id']=== "1"){
        $rapportGeneratedList = Rapport::getRapportGeneratedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportSubmittedList = Rapport::getRapportSubmittedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportValidatedList = Rapport::getRapportValidatedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
    }else{
        $rapportGeneratedList = Rapport::getRapportGenerated();
        $rapportSubmittedList = Rapport::getRapportSubmitted();
        $rapportValidatedList = Rapport::getRapportValidated();
    }

    $chefDequipe = new User();
    $chantierSelected = $chantierObject->get($chantierId);
    $chefDequipeSelected = $chefDequipe->get($chefDEquipeId);

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

}else{
    header('Location: index.php');
}