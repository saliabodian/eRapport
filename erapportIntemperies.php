<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 26.04.2018
 * Time: 11:03
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

    //var_dump($_GET);


    $_GET['sup'] = isset($_GET['sup'])? $_GET['sup'] : '';
    if($_GET['sup']=== 'true'){

        Rapport::deleteRapport($_GET['chef_dequipe_id'], $_GET['date_generation'], $_GET['chantier_id']);
        Rapport::deleteRapportAbsentHorsNoyau($_GET['date_generation'], $_GET['chantier_id'], $_GET['chef_dequipe_matricule']);
        //    exit;

        $deleted = Rapport::checkAllRapportDeleted($_GET['date_generation'], $_GET['chantier_id']);

        //var_dump($deleted);

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
    //        var_dump($_POST);
    //        exit;
        $chantierId = isset($_POST['chantier_id'])? $_POST['chantier_id']: 0;
        $chefDEquipeId = isset($_POST['user_id'])? $_POST['user_id'] : 0;
        $dateRapport = isset($_POST['date_gen'])? date('Y-m-d',strtotime($_POST['date_gen'])) : 0;
        $today = date('Y-m-d', time());
        $teamLeaderMissing = isset($_POST['missing'])? $_POST['missing'] : "";
        $isIntemperie = isset($_POST['itp'])? $_POST['itp'] : "";
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
            $conf->addError(' Aucun rapport ne peut être généré pour cette date.');
            $form=false;
        }

        if(empty($isIntemperie)){
            $conf->addError(' Veuillez sélectionner le type d\'intempéries.');
            $form=false;
        }

    //    var_dump($conf);

    //    exit;
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
        //    var_dump($isIntemperie);


        /////////////////////////////////////////////////////////////////////////////
        //Génération du rapport journalier pour les intempéries///////////
        /////////////////////////////////////////////////////////////////////////////
        if($form && $isIntemperie==='itp'){

        //    echo 'En intempérie' ;
        //    exit;

            $rapportId = isset($rapportId)? $rapportId : "";
            $terminal = isset($terminal)? $terminal : "";
            $rapportType = isset($rapportType)? $rapportType : "";
            $preremp = isset($preremp)? $preremp : "";
            $submitted = isset($submitted)? $submitted : "";
            $validated = isset($validated)? $validated : "";
            $deleted = isset($deleted)? $deleted : "";

        //    var_dump($chantierId);
        //    var_dump($chefDEquipeId);
        //    var_dump($dateRapport);
        //    var_dump($today);
        //    var_dump($isIntemperie);
            //
            //    var_dump($lastRapportNoyau['date']);
            //    var_dump($lastRapportNoyau['terminal']);
            //    var_dump($lastRapportNoyau['chantier']);
            //    var_dump($lastRapportNoyau['equipe']);
            //    var_dump($lastRapportNoyau[''chef_dequipe_matricule]);
            //    var_dump($lastRapportNoyau['rapport_type']);
            //    var_dump($lastRapportNoyau['generated_by']);
            //    var_dump($lastRapportNoyau['preremp']);
            //    var_dump($lastRapportNoyau['submitted']);
            //    var_dump($lastRapportNoyau['validated']);
            //    var_dump($lastRapportNoyau['deleted']);
            //    var_dump($lastRapportNoyau['created']);


            // récupération du dernier pointage validé pour le chef d'équipe et le chantier sélectionné

            $lastRapportNoyau = Rapport::lastRapportNoyauValidated($chantierId, $chefDEquipeId);

        //    var_dump($lastRapportNoyau);

        //    exit;

            // Création du nouveau rapport noyau

            Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportNoyau['chef_dequipe_matricule'], $lastRapportNoyau['rapport_type'], $lastRapportNoyau['chef_dequipe_matricule'], $lastRapportNoyau['preremp']);

            // récuperation des valeurs du nouveau rapport créé

            $lastRapportNoyauCreated = Rapport::getLastRapportNoyauCreated($chantierId, $chefDEquipeId, $dateRapport);

        //    var_dump($lastRapportNoyauCreated);

            // récupération  des détails du dernier pointage validé pour le chef d'équipe et le chantier sélectionné ET création des nouveaux détails

            $newRapportNoyauDetail = Rapport::rapportDetailIntemperieSave($lastRapportNoyau['id'], $lastRapportNoyauCreated['id']);

            // récupération du rapport des absents du noyau

            $lastRapportAbsent = Rapport::lastRapportAbsentNoyauValidated( $chantierId, $chefDEquipeId, $lastRapportNoyau['date']);

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportAbsent['id'])){

                Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportAbsent['chef_dequipe_matricule'], $lastRapportAbsent['rapport_type'], $lastRapportAbsent['chef_dequipe_matricule'], $lastRapportAbsent['preremp']);

                // récupération du rapport des absents du noyau que l'on vient de générer

                $lastRapportAbsentCreated = Rapport::getLastRapportAbsentCreated($chantierId, $chefDEquipeId, $dateRapport);

                // Création des détails correspondants

                $newRapportNoyauAbsentDetail = Rapport::rapportDetailAbsentIntemperieSave($lastRapportAbsent['id'], $lastRapportAbsentCreated['id']);


            }


            // récupération du rapport des hors noyau

            $lastRapportHorsNoyau = Rapport::lastRapportHorsNoyauValidated( $chantierId, $lastRapportNoyau['date']);

        //    var_dump($lastRapportHorsNoyau);

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportHorsNoyau['id'])){

                $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);

                if($rjHorsNoyauExist === false){

                    Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportHorsNoyau['chef_dequipe_matricule'], $lastRapportHorsNoyau['rapport_type'], $lastRapportHorsNoyau['generated_by'], $lastRapportHorsNoyau['preremp']);

                    // récupération du rapport des absents du noyau que l'on vient de générer

                    $lastRapportHorsNoyauCreated = Rapport::getLastRapportHorsNoyauCreated($chantierId, $dateRapport);

                    // Création des détails correspondants

                    $newRapportHorsNoyauDetail = Rapport::rapportDetailIntemperieSave($lastRapportHorsNoyau['id'], $lastRapportHorsNoyauCreated['id']);

                }

            }

            // récupération du rapport des absents hors noyau

            $lastRapportAbsentHorsNoyau = Rapport::lastRapportAbsentHorsNoyauValidated( $chantierId, $lastRapportNoyau['date'], $lastRapportNoyau['generated_by']);

        //    var_dump($lastRapportAbsentHorsNoyau);

        //    exit;

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportAbsentHorsNoyau['id'])){

            //    var_dump($matricule);

            //    exit;

                $rjAbsentHorsNoyauExist = Rapport::checkrapportAbsentHorsNoyauExist($dateRapport, $chantierId, $matricule);

                if($rjAbsentHorsNoyauExist === false){

                    Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportAbsentHorsNoyau['chef_dequipe_matricule'], $lastRapportAbsentHorsNoyau['rapport_type'], $lastRapportAbsentHorsNoyau['generated_by'], $lastRapportAbsentHorsNoyau['preremp']);

                    // récupération du rapport des absents du noyau que l'on vient de générer

                    $lastRapportAbsentHorsNoyauCreated = Rapport::getLastRapportAbsentHorsNoyauCreated($chantierId, $dateRapport);

                    // Création des détails correspondants

                    $newRapportAbsentHorsNoyauDetail = Rapport::rapportDetailAbsentIntemperieSave($lastRapportAbsentHorsNoyau['id'], $lastRapportAbsentHorsNoyauCreated['id']);

                }
            }
        }


        /////////////////////////////////////////////////////////////////////////////
        //Génération du rapport journalier pour le premier jout d'intempéries///////////
        /////////////////////////////////////////////////////////////////////////////
        if($form && $isIntemperie==='fstitp'){

                echo 'premier jour d\'intempérie' ;
                exit;

            $rapportId = isset($rapportId)? $rapportId : "";
            $terminal = isset($terminal)? $terminal : "";
            $rapportType = isset($rapportType)? $rapportType : "";
            $preremp = isset($preremp)? $preremp : "";
            $submitted = isset($submitted)? $submitted : "";
            $validated = isset($validated)? $validated : "";
            $deleted = isset($deleted)? $deleted : "";

            //    var_dump($chantierId);
            //    var_dump($chefDEquipeId);
            //    var_dump($dateRapport);
            //    var_dump($today);
            //    var_dump($isIntemperie);
            //
            //    var_dump($lastRapportNoyau['date']);
            //    var_dump($lastRapportNoyau['terminal']);
            //    var_dump($lastRapportNoyau['chantier']);
            //    var_dump($lastRapportNoyau['equipe']);
            //    var_dump($lastRapportNoyau[''chef_dequipe_matricule]);
            //    var_dump($lastRapportNoyau['rapport_type']);
            //    var_dump($lastRapportNoyau['generated_by']);
            //    var_dump($lastRapportNoyau['preremp']);
            //    var_dump($lastRapportNoyau['submitted']);
            //    var_dump($lastRapportNoyau['validated']);
            //    var_dump($lastRapportNoyau['deleted']);
            //    var_dump($lastRapportNoyau['created']);


            // récupération du dernier pointage validé pour le chef d'équipe et le chantier sélectionné

            $lastRapportNoyau = Rapport::lastRapportNoyauValidated($chantierId, $chefDEquipeId);

            //    var_dump($lastRapportNoyau);

            //    exit;

            // Création du nouveau rapport noyau

            Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportNoyau['chef_dequipe_matricule'], $lastRapportNoyau['rapport_type'], $lastRapportNoyau['chef_dequipe_matricule'], $lastRapportNoyau['preremp']);

            // récuperation des valeurs du nouveau rapport créé

            $lastRapportNoyauCreated = Rapport::getLastRapportNoyauCreated($chantierId, $chefDEquipeId, $dateRapport);

            //    var_dump($lastRapportNoyauCreated);

            // récupération  des détails du dernier pointage validé pour le chef d'équipe et le chantier sélectionné ET création des nouveaux détails

            $newRapportNoyauDetail = Rapport::rapportDetailIntemperieSave($lastRapportNoyau['id'], $lastRapportNoyauCreated['id']);

            // récupération du rapport des absents du noyau

            $lastRapportAbsent = Rapport::lastRapportAbsentNoyauValidated( $chantierId, $chefDEquipeId, $lastRapportNoyau['date']);

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportAbsent['id'])){

                Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportAbsent['chef_dequipe_matricule'], $lastRapportAbsent['rapport_type'], $lastRapportAbsent['chef_dequipe_matricule'], $lastRapportAbsent['preremp']);

                // récupération du rapport des absents du noyau que l'on vient de générer

                $lastRapportAbsentCreated = Rapport::getLastRapportAbsentCreated($chantierId, $chefDEquipeId, $dateRapport);

                // Création des détails correspondants

                $newRapportNoyauAbsentDetail = Rapport::rapportDetailAbsentIntemperieSave($lastRapportAbsent['id'], $lastRapportAbsentCreated['id']);


            }


            // récupération du rapport des hors noyau

            $lastRapportHorsNoyau = Rapport::lastRapportHorsNoyauValidated( $chantierId, $lastRapportNoyau['date']);

            //    var_dump($lastRapportHorsNoyau);

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportHorsNoyau['id'])){

                $rjHorsNoyauExist = Rapport::checkChefDEquipeRapportHorsNoyauExist($dateRapport, $chantierId);

                if($rjHorsNoyauExist === false){

                    Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportHorsNoyau['chef_dequipe_matricule'], $lastRapportHorsNoyau['rapport_type'], $lastRapportHorsNoyau['generated_by'], $lastRapportHorsNoyau['preremp']);

                    // récupération du rapport des absents du noyau que l'on vient de générer

                    $lastRapportHorsNoyauCreated = Rapport::getLastRapportHorsNoyauCreated($chantierId, $dateRapport);

                    // Création des détails correspondants

                    $newRapportHorsNoyauDetail = Rapport::rapportDetailIntemperieSave($lastRapportHorsNoyau['id'], $lastRapportHorsNoyauCreated['id']);

                }

            }

            // récupération du rapport des absents hors noyau

            $lastRapportAbsentHorsNoyau = Rapport::lastRapportAbsentHorsNoyauValidated( $chantierId, $lastRapportNoyau['date'], $lastRapportNoyau['generated_by']);

            //    var_dump($lastRapportAbsentHorsNoyau);

            //    exit;

            // Création du nouveau rapport noyau absent

            if(isset($lastRapportAbsentHorsNoyau['id'])){

                //    var_dump($matricule);

                //    exit;

                $rjAbsentHorsNoyauExist = Rapport::checkrapportAbsentHorsNoyauExist($dateRapport, $chantierId, $matricule);

                if($rjAbsentHorsNoyauExist === false){

                    Rapport::rapportIntemperieSave($dateRapport, $chantierId, $chefDEquipeId, $lastRapportAbsentHorsNoyau['chef_dequipe_matricule'], $lastRapportAbsentHorsNoyau['rapport_type'], $lastRapportAbsentHorsNoyau['generated_by'], $lastRapportAbsentHorsNoyau['preremp']);

                    // récupération du rapport des absents du noyau que l'on vient de générer

                    $lastRapportAbsentHorsNoyauCreated = Rapport::getLastRapportAbsentHorsNoyauCreated($chantierId, $dateRapport);

                    // Création des détails correspondants

                    $newRapportAbsentHorsNoyauDetail = Rapport::rapportDetailAbsentIntemperieSave($lastRapportAbsentHorsNoyau['id'], $lastRapportAbsentHorsNoyauCreated['id']);

                }
            }
        }

    }



    if($_SESSION['post_id'] === "3"){

        $rapportGeneratedList = Rapport::getRapportIntemperieGeneratedForConducteur($_SESSION['id']);
        $rapportSubmittedList = Rapport::getRapportIntemperieSubmittedForConducteur($_SESSION['id']);
        $rapportValidatedList = Rapport::getRapportIntemperieValidatedForConducteur($_SESSION['id']);
    }else if($_SESSION['post_id']=== "1"){
        $rapportGeneratedList = Rapport::getRapportIntemperieGeneratedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportSubmittedList = Rapport::getRapportIntemperieSubmittedForChefDEquipe($_SESSION['id'], $_SESSION['username']);
        $rapportValidatedList = Rapport::getRapportIntemperieValidatedForChefDEquipe($_SESSION['id'], $_SESSION['username']);

        //var_dump($rapportValidatedList);
    }else{
        $rapportGeneratedList = Rapport::getRapportIntemperieGenerated();
        $rapportSubmittedList = Rapport::getRapportIntemperieSubmitted();
        $rapportValidatedList = Rapport::getRapportIntemperieValidated();
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
    include $conf->getViewsDir().'erapportIntemperies.php';
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