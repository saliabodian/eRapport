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

use \Classes\Cdcl\Db\Batiment;

use \Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();



if(!empty($_SESSION)){

    $batimentId = isset($_GET['id'])? $_GET['id'] : '';

    // var_dump($tacheId);

    // exit;

    $batimentObject = new Batiment();

    $batimentList = Batiment::getAllForSelect();

    $chantierList = Chantier::getAllForSelect();



    if ($batimentId > 0)
    {
        $batimentObject = Batiment::get($batimentId);
    }


    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Batiment::deleteById(intval($_GET['delete']))) {
            header('Location: batiment.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        //    var_dump($_POST);
        //    exit;
        $batimentId = isset($_POST['batiment_id']) ? $_POST['batiment_id'] : '';
        $batimentNom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $chantierId = isset($_POST['chantier_id']) ? $_POST['chantier_id'] : '';
        $formOk = true;

        // exit;

        if (empty($_POST['nom'])) {
            $conf->addError('Veuillez renseigner le nom du bâtiment.');
            $formOk = false;
        }
        //var_dump($formOk);
        if (empty($_POST['chantier_id'])) {
            $conf->addError('Veuillez renseigner le chantier.');
            $formOk = false;
        }


        if ($formOk) {
            // Je remplis l'objet avec les valeurs récupérées en POST
            $batimentObject = new Batiment(
                $batimentId,
                $batimentNom,
                new Chantier($chantierId)
            );

            //    exit;



        //    exit;

            $batimentObject->saveDB();
            header('Location: batiment.php?success='.urlencode('Ajout/Modification effectué(e)').'&batiment_id='.$batimentObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectBatiment = new SelectHelper($batimentList, $batimentId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    $selectChantier = new SelectHelper($chantierList, $batimentObject->getChantierId()->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'batiment.php';
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
