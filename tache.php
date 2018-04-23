<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
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
        'class' => 'select2-container',
    ));

    $selectTypeTache = new SelectHelper($typeTacheList, $tacheObject->getTypeTache()->getId(), array(
        'name' => 'type_tache_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'tache.php';
    include $conf->getViewsDir().'footer.php';

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
