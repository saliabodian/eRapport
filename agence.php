<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
 */
spl_autoload_register();
use Classes\Cdcl\Config\Config;
use \Classes\Cdcl\Helpers\SelectHelper;
$conf = Config::getInstance();

use Classes\Cdcl\Db\Agence;

if(!empty($_SESSION)) {

    $agenceId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $agenceObject = new Agence();

    $agenceList = Agence::getAllForSelect();

    if ($agenceId > 0) {
        $agenceObject = Agence::get($agenceId);
        //print_r($agenceObject);
    }

    // var_dump($agenceObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Agence::deleteById(intval($_GET['delete']))) {
            header('Location: agence.php?success=' . urlencode('Suppression effectuée'));
            exit;
        }
    }


    if (!empty($_POST)) {
        //    var_dump($_POST);
        //    exit;
        $agenceId = isset($_POST['agence_id']) ? $_POST['agence_id'] : '';
        $agenceName = isset($_POST['agence']) ? $_POST['agence'] : '';
        $indicatif = isset($_POST['indicatif']) ? $_POST['indicatif'] : '';
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
        $code_postal = isset($_POST['code_postal']) ? $_POST['code_postal'] : '';
        $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
        $pays = isset($_POST['pays']) ? $_POST['pays'] : '';
        $actif = isset($_POST['actif']) ? 1 : 0;
        $formOk = true;

        if (empty($_POST['agence'])) {
            $conf->addError('Veuillez renseigner le nom de l\'Agence');
            $formOk = false;
        }
        var_dump(strlen($indicatif));

        //exit;

        if (!empty($indicatif)) {
            if(strlen($indicatif)>5){
                $conf->addError('L\'indicatif ne doit pas dépasser 5 chiffres');
                $formOk = false;
            }
        }


        if (!empty($telephone)) {
            if(strlen($telephone)>10){
                $conf->addError('Le numéro de téléphone ne doit pas dépasser 10 chiffres');
                $formOk = false;
            }
        }

        // var_dump($telephone);
        // var_dump($formOk);



        if ($formOk) {
            // Je remplis l'objet Agence avec les valeurs récupérées en POST
            $agenceObject = new Agence(
                $agenceId,
                $agenceName,
                $indicatif,
                $telephone,
                $adresse,
                $code_postal,
                $ville,
                $pays,
                $actif
            );
             var_dump($agenceObject);

            // exit;

            //var_dump($formOk);

            $agenceObject->saveDB();
            header('Location: agence.php?success=' . urlencode('Ajout/Modification effectuée') . '&agence_id=' . $agenceObject->getId());
            exit;

        } else {
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectAgence = new SelectHelper($agenceList, $agenceId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    include $conf->getViewsDir() . 'header.php';
    include $conf->getViewsDir() . 'sidebar.php';
    include $conf->getViewsDir() . 'agence.php';
    include $conf->getViewsDir() . 'footer.php';
}else{
    header('Location: index.php');
}