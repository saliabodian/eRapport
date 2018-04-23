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

use Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

$conf = Config::getInstance();

use Classes\Cdcl\Db\TypeTache;


if(!empty($_SESSION)){

    $typeTacheId = isset($_GET['id'])? $_GET['id'] : '';

    $typeTacheObject = new TypeTache();

    // var_dump($typeTacheObject);

    $typeTacheList = TypeTache::getAllForSelect();



    if ($typeTacheId > 0) {
        $typeTacheObject = TypeTache::get($typeTacheId);
        //print_r($typeTacheObject);
    }

    // var_dump($typeTacheObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (TypeTache::deleteById(intval($_GET['delete']))) {
            header('Location: typeTache.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        //var_dump($_POST);

        $typeTacheId = isset($_POST['type_tache_id']) ? $_POST['type_tache_id'] : '';
        $nomTypeTache = isset($_POST['nom_type_tache']) ? $_POST['nom_type_tache'] : '';
        $codeTypeTache = isset($_POST['code_type_tache']) ? $_POST['code_type_tache'] : '';
        $formOk = true;

        // exit;

        if (empty($_POST['nom_type_tache'])) {
            $conf->addError('Veuillez renseigner le nom de la tâche.');
            $formOk = false;
        }
        //var_dump($formOk);


        if (empty($_POST['code_type_tache'])) {
            $conf->addError('Veuillez définir un code.');
            $formOk = false;
        }
        //var_dump($formOk);



        if ($formOk) {
            // Je remplis l'objet TypeTache avec les valeurs récupérées en POST
            $typeTacheObject = new TypeTache(
                $typeTacheId,
                $nomTypeTache,
                $codeTypeTache
            );
            //    var_dump($typeTacheObject);

            //var_dump($typeTacheId);

            //exit;

            $typeTacheObject->saveDB();
            header('Location: typeTache.php?success='.urlencode('Ajout/Modification effectuée').'&type_tache_id='.$typeTacheObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectTypeTache = new SelectHelper($typeTacheList, $typeTacheId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'typeTache.php';
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
