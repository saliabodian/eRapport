<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 08.12.2017
 * Time: 15:46
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

use \Classes\Cdcl\Db\TypeTache;

use \Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\Rapport;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Db\CSV;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    // var_dump($_SESSION['id']);

    // exit;

    $user = new User();

    $list = $user->listChantierByUserForSelect($_SESSION['id']);

    // var_dump($list);



//    exit;

    $listTypeTache = TypeTache::getAll();

    $chantier = new Chantier();

//    var_dump($listTypeTache);
//    $listTache= Tache::getAll();

//exit;
    $selectChantier = new SelectHelper($list, $chantier->getId(), array(
        'name' => 'chantier_id',
        'id' => 'id',
        'class' => 'select2-container',
    ));



    if(!empty($_POST)){

    //    var_dump($_POST);

    //    exit;
        /*
         * ["chantier_id"]=> string(3) "247"
         * ["type_task"]=> string(1) "3"
         * ["tasks"]=> string(2) "24"
         * ["date_deb"]=> string(10) "11-12-2017"
         * ["date_fin"]=> string(10) "12-12-2017" */
        $condenseTaskDoneOnSite = isset($condenseTaskDoneOnSite)? $condenseTaskDoneOnSite : '';
        $chantierId = isset($_POST['chantier_id'])? $_POST['chantier_id'] : '';
        $dateDeb = isset($_POST['date_deb']) ? date('Y-m-d', strtotime($_POST['date_deb'])) : '';
        $dateFin = isset($_POST['date_fin'])? date('Y-m-d', strtotime($_POST['date_fin'])) : '';
        $formOk = true;

    //    var_dump($chantierId);
    //    var_dump($dateDeb);
    //    var_dump($dateFin);

    //    exit;


        if(empty($chantierId)){
            $conf->addError('Veuillez définir le chantier !');
            $formOk = false;
        }
        if((empty($dateDeb)) || ($dateDeb === "1970-01-01")) {
            $conf->addError('Veuillez définir la date de début !');
            $formOk = false;
        }
        if((empty($dateFin)) || ($dateFin === "1970-01-01")){
            $conf->addError('Veuillez définir la date de fin !');
            $formOk = false;
        }


        //    var_dump($chantierId);
        //    var_dump($dateDeb);
        //    var_dump($dateFin);

        //     var_dump($_POST);

        if($formOk){
            $condenseTaskDoneOnSite = Rapport::condenseTaskDoneOnSite($chantierId, $dateDeb, $dateFin);

            if(empty($condenseTaskDoneOnSite)){
                $conf->addError('Aucun résulatat pour cette demande.');
            }
            //    var_dump($condenseTaskDoneOnSite);
            //    exit;
        }else{
            $conf->addError('Veuillez redéfinir vos critères de recherche !');
        }



        //    var_dump($tasksHoursDonebySite);
        //    var_dump($tasksHoursDonebySiteHeader);
        //    EXIT;
    }



    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'condenseTaskDoneOnSite.php';
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