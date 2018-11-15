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

use Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

$conf = Config::getInstance();

use Classes\Cdcl\Db\Chantier;

if(!empty($_SESSION)){

//    var_dump($_POST);

//    exit;

    $chantierId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $chantierObject = new Chantier();

    // var_dump($chantierObject);

    $chantierList = Chantier::getAllForSelect();

    $batimentList = isset($batimentList) ? $batimentList : '';

    if ($chantierId > 0) {
        $chantierObject = Chantier::get($chantierId);
        $batimentList = Chantier::chantierBatimentList($chantierId);
        //print_r($chantierObject);
    }



    // var_dump($chantierId);




    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {

        $batimentList = Chantier::chantierBatimentList(intval($_GET['delete']));

        if(!empty($batimentList)){
            foreach($batimentList as $batiment){
                \Classes\Cdcl\Db\Batiment::deleteById($batiment['id']);
            }
        }

        Chantier::deleteById(intval($_GET['delete']));
        header('Location: chantier.php?success='.urlencode('Suppression effectuée'));
        exit;
    }


    if(!empty($_POST)) {
    //    var_dump($_POST);
        $chantierId = isset($_POST['chantier_id']) ? $_POST['chantier_id'] : '';
        $chantierName = isset($_POST['nom']) ? $_POST['nom'] : '';
        $chantierCode = isset($_POST['code']) ? $_POST['code'] : '';
        $chantierAdresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
        $chantierAdresseFac = isset($_POST['adresse_fac']) ? $_POST['adresse_fac'] : '';
        $chantierDateExec = isset($_POST['date_exec']) ? date('Y-m-d', strtotime($_POST['date_exec'])) : '';
        $chantierActif = isset($_POST['actif']) ? 1 : 0;
        $chantierAscMtn = isset($_POST['asc_mtn']) ? 1 : 0;
        $formOk = true;

        //var_dump($chantierDateExec);
        //exit;

        // var_dump($chantierActif);
        // exit;

        if (empty($_POST['nom'])) {
            $conf->addError('Veuillez renseigner le nom du chantier');
            $formOk = false;
        }
        //var_dump($formOk);

        if (empty($_POST['code'])) {
            $conf->addError('Veuillez renseigner le numéro de chantier');
            $formOk = false;
        }

        if ($formOk) {
            // Je remplis l'objet Chantier avec les valeurs récupérées en POST
            $chantierObject = new Chantier(
                $chantierId,
                $chantierName,
                $chantierCode,
                $chantierAdresse,
                $chantierAdresseFac,
                $chantierDateExec,
                $chantierActif,
                $chantierAscMtn
            );
        //    var_dump($chantierObject);

            //var_dump($chantierId);

        //    exit;

            $chantierObject->saveDB();
            header('Location: chantier.php?success='.urlencode('Ajout/Modification effectuée').'&chantier_id='.$chantierObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectChantier = new SelectHelper($chantierList, $chantierId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'chantier.php';
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
