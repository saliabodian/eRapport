<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
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

use \Classes\Cdcl\Helpers\SelectHelper;

use \Classes\Cdcl\Db\Interimaire;

use Classes\Cdcl\Db\Metier;

use Classes\Cdcl\Db\Agence;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\Qualification;

use Classes\Cdcl\Db\Departement;

use Classes\Cdcl\Db\User;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $interimaireId = isset($_GET['id'])? $_GET['id'] : '';

    //var_dump($interimaireId);

    //exit;

    $interimaireObject = new Interimaire();
    if(!empty($_GET['search'])){
        $interimaireList = Interimaire::getAllForSelectFilter($_GET['search']);
    }else{
        $interimaireList = Interimaire::getAllForSelect();
    }

    // var_dump($interimaireList);
    // exit;

    $metierList = Metier::getAllForSelect();

    $agenceList = Agence::getAllForSelectActif();

    $qualifList = Qualification::getAllForSelect();

    $dptList = Departement::getAllForSelect();

    $userList = User::getAllForSelectChefDEquipe();

    $chantierList = Chantier::getAllForSelectActif();




    if ($interimaireId > 0)
    {
        $interimaireObject = Interimaire::get($interimaireId);
    }


    $idAgence = $interimaireObject->getAgenceId()->getId();

    $theAgence = Agence::get($idAgence);

    //var_dump($theAgence);

    $theAgenceName = $theAgence->getNom();

    // var_dump($theAgenceName);

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Interimaire::deleteById(intval($_GET['delete']))) {
            header('Location: interimaire.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        //var_dump($_POST);
        //exit;
        $interimaireId = isset($_POST['interimaire_id']) ? $_POST['interimaire_id'] : '';

        //var_dump($matricule);
        //exit;
        $matricule_cns = isset($_POST['matricule_cns']) ? $_POST['matricule_cns'] : '';
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $actif = isset($_POST['actif']) ?  1 : 0;
        $taux = isset($_POST['taux']) ? $_POST['taux'] : '';
        $taux_horaire = isset($_POST['$taux_horaire']) ? $_POST['$taux_horaire'] : '';
        $evaluateur = isset($_POST['evaluateur']) ? $_POST['evaluateur'] : '';
        $evaluation = isset($_POST['evaluation']) ? $_POST['evaluation'] : '';
        $chantier_id = isset($_POST['chantier_id']) ? $_POST['chantier_id'] : 0;
        //var_dump($chantier_id);
        //exit;
        $charte_securite = isset($_POST['charte_securite']) ?  1 : 0;
        //$date_evaluation = isset($_POST['date_evaluation']) ? date('Y-m-d',strtotime($_POST['date_evaluation'])) : '';
        $date_evaluation = isset($_POST['date_evaluation']) ? new \DateTime($_POST['date_evaluation']) : new \DateTime('0000-00-00');
        //$date_vm = isset($_POST['date_vm']) ? date('Y-m-d',strtotime($_POST['date_vm'])): '';
        $date_vm = isset($_POST['date_vm']) ? new \DateTime($_POST['date_vm']): new \DateTime('0000-00-00');
        //$date_prem_cont = isset($_POST['date_prem_cont']) ? date('Y-m-d', strtotime($_POST['date_prem_cont'])) : '';
        $date_prem_cont = isset($_POST['date_prem_cont']) ? new \DateTime($_POST['date_prem_cont']) : new \DateTime('0000-00-00');
        //$date_cont_rec = isset($_POST['date_cont_rec']) ? date('Y-m-d', strtotime($_POST['date_cont_rec'])) : '';
        $date_cont_rec = isset($_POST['date_cont_rec']) ? new \DateTime($_POST['date_cont_rec']) : new \DateTime('0000-00-00');
        // $date_deb = isset($_POST['date_deb']) ? date('Y-m-d', strtotime($_POST['date_deb'])) : '';
        $date_deb = isset($_POST['date_deb']) ? new \DateTime($_POST['date_deb']) : new \DateTime('0000-00-00');
        //$date_fin = isset($_POST['date_fin']) ? date('Y-m-d', strtotime($_POST['date_fin'])) : '';
        //$date_fin = isset($_POST['date_fin']) ? new DateTime($_POST['date_fin']) : '';
        $worker_status = isset($_POST['worker_status']) ? $_POST['worker_status'] : '';
        $rem_med = isset($_POST['rem_med']) ? $_POST['rem_med'] : '';
        $remarques = isset($_POST['remarques']) ? $_POST['remarques'] : '';
        $old_metier_denomination = isset($_POST['old_metier_denomination']) ? $_POST['old_metier_denomination'] : '';
        $metier_id = isset($_POST['metier_id']) ? $_POST['metier_id'] : 0;
        $agence_id = isset($_POST['agence_id']) ? $_POST['agence_id'] : 0;
        $qualif_id = isset($_POST['qualif_id']) ? $_POST['qualif_id'] : 0;
        $dpt_id = isset($_POST['dpt_id']) ? $_POST['dpt_id'] : 0;
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;





        $formOk = true;



        /*foreach ($_POST['duallistbox_demo1'] as $chantier_id) {
            var_dump($chantier_id);
        }
        */




        if (empty($_POST['firstname'])) {
            $conf->addError('Veuillez renseigner le prénom.');
            $formOk = false;
        }
        //var_dump($formOk);

        if (empty($_POST['lastname'])) {
            $conf->addError('Veuillez renseigner le nom.');
            $formOk = false;
        }

        if (empty($_POST['agence_id'])) {
            $conf->addError('Veuillez renseigner l\'agence.');
            $formOk = false;
        }


        // Génération automatique des matricules à partir du choîx de l'agence et des valeurs premiers matricules et dernier matricules définis
        // pour l'agence correspondante

        if($_POST['interimaire_id'] != 0){
        //  Cas de Mise à jour d'un intérimaire
        //  var_dump($_POST['interimaire_id']);
            $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
            // echo "Le matricule exist<br>";
            // var_dump($matricule );
            // exit;
        }else{
        //    echo "Nouvel Intérimaire<br>";
            $matricule=Interimaire::getLastMatricule($agence_id);

            if(empty($matricule)){
                $agence=Agence::get($agence_id);
                $matricule=$agence->getFirstMatricule()+1;
                // echo "aucun matricule<br>";
                // var_dump($matricule );
                // exit;
            }else{
                $matricule=Interimaire::getLastMatricule($agence_id)+1;
            }

            $conf->addError('Le matricule n\'a pas pu être généré.');
        }


        // Affectation automatique d'un intérimaire si ce dernier est actif, et en fonction de sa date de début de mission (semaine correspondante)
        // et du chantier qu'il lui est affecté

        if($actif === 1){
            if (empty($_POST['chantier_id'])) {
                $conf->addError('Veuillez l\'affecter à un chantier.');
                $formOk = false;
            }

            if (empty($_POST['user_id'])) {
                $conf->addError('Veuillez lui rattacher un chef d\'équipe.');
                $formOk = false;
            }

            if(empty($date_deb)){
                $conf->addError('Veuillez renseigner une date de début de mission valide.');
                $formOk = false;
            }


            // Date du jour sélectionné
            //$_GET['date_deb'] = timestamp
            $selectedDay = !empty($date_deb) ? intval($date_deb->format('N')) : "";
            // var_dump($selectedDay);
            // echo "<br>";

            // Semanine  correspondant au jour sélectionné
            $selectedWeek = !empty($date_deb) ? intval($date_deb->format('W')) : "";
            // var_dump($selectedWeek);
            // echo "<br>";

            // Année  correspondante au jour sélectionné
            $selectedYear = !empty($date_deb) ? intval($date_deb->format('Y')) : "";
            // var_dump($selectedWeek);
            // echo "<br>";


            // Calcul de l'écart entre le jour de $day et le lundi (=1)
            $rel = 7 - $selectedDay;

            $date_fin = new DateTime($date_deb->format('Y-m-d').' +'.$rel .'day');

        //    var_dump($date_deb);


            //calcul du premier jour de la semaine sélectionnée
            // $firstDaySelectedWeek est une la valeur de la date au format 2017-09-18"
            // strtotime($firstDaySelectedWeek) renvoie le timestamp de la valeur $firstDaySelectedWeek
            //$firstDaySelectedWeek = date('Y-m-d', strtotime("$rel days", strtotime($selectedDay)));

        //    var_dump($_POST['interimaire_id']);
        //    exit;
            if(intval($_POST['interimaire_id']) != 0){
                $affectationExists = Interimaire::checkInterimaireAffectation($_POST['chantier_id'],$selectedWeek,$selectedYear,$_POST['interimaire_id']);
            //    var_dump($affectationExists);
            //    exit;
            //    if ($affectationExists >= 1){
            //        $conf->addError("Cet intérimaire a déjà été affecté pour ce chantier et cette date");
            //       $formOk = false;
            //   }
            }
        }else{
            if(empty($date_deb)){
                $conf->addError('Veuillez renseigner une date de début de mission valide.');
                $formOk = false;
            }


            // Date du jour sélectionné
            //$_GET['date_deb'] = timestamp
            $selectedDay = !empty($date_deb) ? intval($date_deb->format('N')) : "";
            // var_dump($selectedDay);
            // echo "<br>";

            // Semanine  correspondant au jour sélectionné
            $selectedWeek = !empty($date_deb) ? intval($date_deb->format('W')) : "";
            // var_dump($selectedWeek);
            // echo "<br>";

            // Année  correspondante au jour sélectionné
            $selectedYear = !empty($date_deb) ? intval($date_deb->format('Y')) : "";
            // var_dump($selectedWeek);
            // echo "<br>";


            // Calcul de l'écart entre le jour de $day et le lundi (=1)
            $rel = 7 - $selectedDay;

            $date_fin = new DateTime($date_deb->format('Y-m-d').' +'.$rel .'day');

            if(intval($_POST['interimaire_id']) != 0){
                $affectationExists = Interimaire::checkInterimaireAffectation($_POST['chantier_id'],$selectedWeek,$selectedYear,$_POST['interimaire_id']);
                //    var_dump($affectationExists);
                //    exit;
                //    if ($affectationExists >= 1){
                //        $conf->addError("Cet intérimaire a déjà été affecté pour ce chantier et cette date");
                //       $formOk = false;
                //   }
            }
        }

        if ($formOk) {

            // Je remplis l'objet Interimaire avec les valeurs récupérées en POST
            $interimaireObject = new Interimaire
            ($interimaireId,
            $matricule,
            $matricule_cns,
            $firstname,
            $lastname,
            $actif,
            $taux,
            $taux_horaire,
            $evaluation,
            $evaluateur,
            new Chantier($chantier_id),
            $charte_securite,
            $date_evaluation->format('Y-m-d'),
            $date_vm->format('Y-m-d'),
            $date_prem_cont->format('Y-m-d'),
            $date_cont_rec->format('Y-m-d'),
            $date_deb->format('Y-m-d'),
            $date_fin->format('Y-m-d'),
            $worker_status,
            $rem_med,
            $remarques,
            $old_metier_denomination,
            new Metier($metier_id),
            new Agence($agence_id),
            new Qualification($qualif_id),
            new Departement($dpt_id),
            new User($user_id)
            );

            // var_dump($interimaireObject);

            // exit;
            $interimaireObject->saveDB();

        //    var_dump($interimaireObject);

        //    exit;

            if($affectationExists < 1){
                if($_POST['interimaire_id'] != 0){
                    $affectation = Interimaire::affectationInterimaireSaved($chantier_id, $selectedWeek, $_POST['interimaire_id'], $date_deb);
                }else{
                    $id = Interimaire::getLastId($agence_id, $matricule);
                    $affectation = Interimaire::affectationInterimaireSaved($chantier_id, $selectedWeek, $id, $date_deb);
                }
            }

            header('Location: interimaire.php?success='.urlencode('Ajout/Modification effectuée').'&interimaire_id='.$interimaireObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectInterimaire = new SelectHelper($interimaireList, $interimaireId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectMetier = new SelectHelper($metierList, $interimaireObject->getMetierId()->getId(), array(
        'name' => 'metier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectChantier = new SelectHelper($chantierList, $interimaireObject->getChantierId()->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectAgence = new SelectHelper($agenceList, $interimaireObject->getAgenceId()->getId(), array(
        'name' => 'agence_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectQualif = new SelectHelper($qualifList, $interimaireObject->getQualifId()->getId(), array(
        'name' => 'qualif_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectDpt = new SelectHelper($dptList, $interimaireObject->getDptId()->getId(), array(
        'name' => 'dpt_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectUser = new SelectHelper($userList, $interimaireObject->getUserId()->getId(), array(
        'name' => 'user_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    // var_dump($selectChantier);
    // echo "<br>";
    // var_dump($selectAgence)
    // exit;
    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'interimaire.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}
