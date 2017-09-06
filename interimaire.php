<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
 */

spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use \Classes\Cdcl\Db\Interimaire;

use Classes\Cdcl\Db\Metier;

use Classes\Cdcl\Db\Agence;

use Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $interimaireId = isset($_GET['id'])? $_GET['id'] : '';

    //var_dump($interimaireId);

    // exit;

    $interimaireObject = new Interimaire();

    $interimaireList = Interimaire::getAllForSelect();

    $metierList = Metier::getAllForSelect();

    $agenceList = Agence::getAllForSelect();

    $chantierList = Chantier::getAllForSelect();

    //var_dump($agenceList);
    //exit;


    if ($interimaireId > 0)
    {
        $interimaireObject = Interimaire::get($interimaireId);
        //    print_r($interimaireObject);
    }

    // var_dump($interimaireObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Interimaire::deleteById(intval($_GET['delete']))) {
            header('Location: interimaire.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        // exit;
        $interimaireId = isset($_POST['interimaire_id']) ? $_POST['interimaire_id'] : '';
        $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
        $matricule_cns = isset($_POST['matricule_cns']) ? $_POST['matricule_cns'] : '';
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $actif = isset($_POST['actif']) ?  1 : 0;
        $taux = isset($_POST['taux']) ? $_POST['taux'] : '';
        $evaluateur = isset($_POST['evaluateur']) ? $_POST['evaluateur'] : '';
        $evaluation = isset($_POST['evaluation']) ? $_POST['evaluation'] : '';
        $chantier_id = isset($_POST['chantier_id']) ? $_POST['chantier_id'] : '';
        $charte_securite = isset($_POST['charte_securite']) ?  1 : 0;
        $date_evaluation = isset($_POST['date_evaluation']) ? date('Y-m-d',strtotime($_POST['date_evaluation'])) : '';
        $date_vm = isset($_POST['date_vm']) ? date('Y-m-d',strtotime($_POST['date_vm'])): '';
        $date_prem_cont = isset($_POST['date_prem_cont']) ? date('Y-m-d', strtotime($_POST['date_prem_cont'])) : '';
        $date_cont_rec = isset($_POST['date_cont_rec']) ? date('Y-m-d', strtotime($_POST['date_cont_rec'])) : '';
        $date_deb = isset($_POST['date_deb']) ? date('Y-m-d', strtotime($_POST['date_deb'])) : '';
        $date_fin = isset($_POST['date_fin']) ? date('Y-m-d', strtotime($_POST['date_fin'])) : '';
        $worker_status = isset($_POST['worker_status']) ? $_POST['worker_status'] : '';
        $rem_med = isset($_POST['rem_med']) ? $_POST['rem_med'] : '';
        $remarques = isset($_POST['remarques']) ? $_POST['remarques'] : '';
        $old_metier_denomination = isset($_POST['old_metier_denomination']) ? $_POST['old_metier_denomination'] : '';
        $metier_id = isset($_POST['metier_id']) ? $_POST['metier_id'] : '';
        $agence_id = isset($_POST['agence_id']) ? $_POST['agence_id'] : '';

        $formOk = true;



        /*foreach ($_POST['duallistbox_demo1'] as $chantier_id) {
            var_dump($chantier_id);
        }
        */

        //exit;



        if (empty($_POST['firstname'])) {
            $conf->addError('Veuillez renseigner le prénom.');
            $formOk = false;
        }
        //var_dump($formOk);

        if (empty($_POST['lastname'])) {
            $conf->addError('Veuillez renseigner le nom.');
            $formOk = false;
        }


        if ($formOk) {
            // Je remplis l'objet User avec les valeurs récupérées en POST
            $interimaireObject = new Interimaire
            ($interimaireId,
            $matricule,
            $matricule_cns,
            $firstname,
            $lastname,
            $actif,
            $taux,
            $evaluation,
            $evaluateur,
            new Chantier($chantier_id),
            $charte_securite,
            $date_evaluation,
            $date_vm,
            $date_prem_cont,
            $date_cont_rec,
            $date_deb,
            $date_fin,
            $worker_status,
            $rem_med,
            $remarques,
            $old_metier_denomination,
            new Metier($metier_id),
            new Agence($agence_id)
            );
            /*$data['id'],
                $data['matricule'],
                $data['matricule_cns'],
                $data['firstname'],
                $data['lastname'],
                $data['actif'],
                $data['taux'],
                $data['taux_horaire'],
                $data['evaluation'],
                $data['evaluateur'],
                new Chantier($data['evaluation_chantier_id']),
                $data['charte_securite'],
                $data['date_evaluation'],
                $data['date_vm'],
                $data['date_prem_cont'],
                $data['date_cont_rec'],
                $data['date_deb'],
                $data['date_fin'],
                $data['worker_status'],
                $data['rem_med'],
                $data['remarques'],
                $data['old_metier_denomination'],
                new Metier($data['metier_id']),
                new Agence($data['agence_id']),
                $data['created']
                */
            $interimaireObject->saveDB();

            header('Location: user.php?success='.urlencode('Ajout/Modification effectuée').'&user_id='.$userObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectInterimaire = new SelectHelper($interimaireList, $interimaireId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'form-control',
    ));

    $selectMetier = new SelectHelper($metierList, $interimaireObject->getMetierId()->getId(), array(
        'name' => 'metier_id',
        'id' => 'id',
        'class' => 'form-control',
    ));

    $selectChantier = new SelectHelper($chantierList, $interimaireObject->getChantierId()->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'form-control',
    ));

    $selectAgence = new SelectHelper($agenceList, $interimaireObject->getAgenceId()->getId(), array(
        'name' => 'post_id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'interimaire.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}
