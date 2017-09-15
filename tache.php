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

use \Classes\Cdcl\Db\Tache;

use \Classes\Cdcl\Db\TypeTache;

$conf = Config::getInstance();



if(!empty($_SESSION)){

    $tacheId = isset($_GET['id'])? $_GET['id'] : '';

    // var_dump($tacheId);

    // exit;

    $tacheObject = new Tache();

    $tacheList = Tache::getAllForSelect();

    $typeTacheList = TypeTache::getAllForSelect();



    if ($tacheId > 0)
    {
        $tacheObject = Tache::get($tacheId);
    //    print_r($tacheObject);
    }

    // var_dump($tacheObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Tache::deleteById(intval($_GET['delete']))) {
            header('Location: tache.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
    //    var_dump($_POST);
    //    exit;
        $tacheId = isset($_POST['tache_id']) ? $_POST['tache_id'] : '';
        $tacheCode = isset($_POST['code']) ? $_POST['code'] : '';
        $tacheNom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $typeTacheId = isset($_POST['type_tache_id']) ? $_POST['type_tache_id'] : '';
        $formOk = true;

        // exit;

        if (empty($_POST['nom'])) {
            $conf->addError('Veuillez renseigner le nom de la tâche.');
            $formOk = false;
        }
        //var_dump($formOk);


        if (empty($_POST['code'])) {
            $conf->addError('Veuillez définir un code.');
            $formOk = false;
        }
        //var_dump($formOk);
        if (empty($_POST['type_tache_id'])) {
            $conf->addError('Veuillez le type de tâche.');
            $formOk = false;
        }


        if ($formOk) {
            // Je remplis l'objet Tache avec les valeurs récupérées en POST
            $tacheObject = new Tache(
                $tacheId,
                $tacheCode,
                $tacheNom,
                new TypeTache($typeTacheId)
            );
            //    var_dump($tacheObject);

        //    exit;

            //var_dump($tacheId);

            //exit;

            $tacheObject->saveDB();
            header('Location: tache.php?success='.urlencode('Ajout/Modification effectuée').'&tache_id='.$tacheObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectTache = new SelectHelper($tacheList, $tacheId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'form-control',
    ));

    $selectTypeTache = new SelectHelper($typeTacheList, $tacheObject->getTypeTache()->getId(), array(
        'name' => 'type_tache_id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'tache.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}
