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

use Classes\Cdcl\Db\Metier;


if(!empty($_SESSION)){

    $metierId = isset($_GET['id'])? $_GET['id'] : '';

    $metierObject = new Metier();

    // var_dump($metierObject);

    $metierList = Metier::getAllForSelect();



    if ($metierId > 0) {
        $metierObject = Metier::get($metierId);
        //print_r($metierObject);
    }

    // var_dump($metierObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Metier::deleteById(intval($_GET['delete']))) {
            header('Location: metier.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        //var_dump($_POST);

        $metierId = isset($_POST['metier_id']) ? $_POST['metier_id'] : '';
        $metierCodeMetier = isset($_POST['code_metier']) ? $_POST['code_metier'] : '';
        $metierNomMetier = isset($_POST['nom_metier']) ? $_POST['nom_metier'] : '';
        $formOk = true;

        // exit;

        /*
        Code metier n'est plus obligatoire proposition par Laurent
        if (empty($_POST['code_metier'])) {
            $conf->addError('Veuillez définir le code du métier.');
            $formOk = false;
        }*/
        //var_dump($formOk);


        if (empty($_POST['nom_metier'])) {
            $conf->addError('Veuillez renseigner le nom du métier.');
            $formOk = false;
        }
        //var_dump($formOk);



        if ($formOk) {
            // Je remplis l'objet Metier avec les valeurs récupérées en POST
            $metierObject = new Metier(
                $metierId,
                $metierCodeMetier,
                $metierNomMetier
            );
            //    var_dump($postObject);

            //var_dump($postId);

            //exit;

            $metierObject->saveDB();
            header('Location: metier.php?success='.urlencode('Ajout/Modification effectuée').'&metier_id='.$metierObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectMetier = new SelectHelper($metierList, $metierId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'metier.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}
