<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 15/09/2017
 * Time: 17:20
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

use Classes\Cdcl\Db\Departement;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $dptId = isset($_GET['id'])? $_GET['id'] : '';

    // exit;

    $dptObject = new Departement();

    $dptList = Departement::getAllForSelect();





    if ($dptId > 0)
    {
        $dptObject = Departement::get($dptId);
    }

    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Departement::deleteById(intval($_GET['delete']))) {
            header('Location: departement.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        // exit;
        $dptId = isset($_POST['dpt_id']) ? $_POST['dpt_id'] : '';
        $nomDpt = isset($_POST['nom_dpt']) ? $_POST['nom_dpt'] : '';
        $codeDpt = isset($_POST['code_dpt']) ? $_POST['code_dpt'] : '';

        $formOk = true;


        if (empty($codeDpt)) {
            $conf->addError('Veuillez renseigner le champ code Département.');
            $formOk = false;
        }


        if (empty($nomDpt)) {
            $conf->addError('Veuillez renseigner le champ nom Département.');
            $formOk = false;
        }

        //var_dump($formOk);

        if ($formOk) {
            // Je remplis l'objet Interimaire avec les valeurs récupérées en POST
            $dptObject = new Departement
            ($dptId,
            $codeDpt,
            $nomDpt
            );


            $dptObject->saveDB();

            header('Location: departement.php?success='.urlencode('Ajout/Modification effectuée').'&departement_id='.$dptObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectDpt = new SelectHelper($dptList, $dptId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'departement.php';
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
            // session timed out, last request is longer than 15 minutes ago
            $_SESSION = array();
            session_destroy();
        }
    }
    $_SESSION['LAST_REQUEST_TIME'] = time();

}else{
    header('Location: index.php');
}
