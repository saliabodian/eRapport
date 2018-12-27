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

use Classes\Cdcl\Db\Batiment ;

use Classes\Cdcl\Db\TypeTache ;

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

    // Gestion de l^'ajout de batiment
    $_GET['addBuilding'] = isset($_GET['addBuilding']) ? $_GET['addBuilding'] : '';
    $_GET['batiment_id'] = isset($_GET['batiment_id']) ? $_GET['batiment_id'] : '';
    $batimentObject = new Batiment();
    if(!empty($_GET['batiment_id'])){
        $batimentObject=Batiment::get($_GET['batiment_id']);
    }

    if($_GET['addBuilding']){
        $_GET['submit_form'] = isset($_GET['submit_form']) ? $_GET['submit_form'] : '';

        if($_GET['submit_form']){

            $batiment = isset($_GET['nom']) ? $_GET['nom'] : '';
            $formBuilding = true ;
            $_GET['submit_form'] = isset($_GET['submit_form']) ? $_GET['submit_form'] : '';

        //    var_dump($formBuilding);

            if(empty($batiment)){
                $conf->addError('Veuillez saisir le nom du bâtiment !');
                $formBuilding = false ;
            }else{
                if(!empty($batimentList)){
                    foreach($batimentList as $bat){
                        if($batiment === $bat['nom']){
                            $conf->addError('Ce nom est déjà utilisé !');
                            $formBuilding = false ;
                        }
                    }
                }
            }

            if($formBuilding){

                $batimentObject = new Batiment(
                    $batimentObject->getId(),
                    $batiment,
                    new Chantier($_GET['id'])
                );
                    $batimentObject->saveDB();
                $_GET['addBuilding'] = '';
            }
        }

    }


    // Suppression d'un bâtiment déjà créé pour un chantier
    $_GET['bat_delete'] = isset($_GET['bat_delete']) ? $_GET['bat_delete'] :'';
    if($_GET['bat_delete']){
        Batiment::deleteById(intval($_GET['bat_id']));
        header('Location: chantier.php?success='.urlencode('Suppression du bâtiment effectuée').'&id='.$_GET['id']);
        exit;
    }

    // Rattachement des tâches par chantier

    $_GET['addTask'] = isset($_GET['addTask'])? $_GET['addTask'] : '';
    if($_GET['addTask']){
        $TypeTaches = TypeTache::getAll();
        $_GET['submit_form'] = isset($_GET['submit_form']) ? $_GET['submit_form'] : '';

        if($_GET['submit_form']){

            $_GET['type_task'] = isset($_GET['type_task']) ? $_GET['type_task'] : '';
            $_GET['id'] = isset($_GET['id']) ? $_GET['id'] : '';
            $_GET['tasks'] = isset($_GET['tasks']) ? $_GET['tasks'] : [] ;
            $formTask = true ;
            $_GET['submit_form'] = isset($_GET['submit_form']) ? $_GET['submit_form'] : '';

            if(empty($_GET['type_task'])){
                $conf->addError('Veuillez choisir un type de tâche !');
                $formTask = false ;
            }else{
                if(empty($_GET['tasks']) || $_GET['tasks']=== 'Tâche'){
                    $conf->addError('Veuillez choisir au moins une tâche !');
                    $formTask = false ;
                }
            }

        //    var_dump($_GET['tasks']);

        //    exit;
        //    var_dump($formTask);
        //    echo "OK"; die;


            if($formTask){
                for ($i = 0; $i < sizeof($_GET['tasks']); $i++){
                    Chantier::insertTaskBySite($_GET['id'], $_GET['tasks'][$i], $_GET['type_task'] );
                }
                header('Location: chantier.php?success='.urlencode('Rattachement effectué avec succés').'&id='.$_GET['id']);
                exit;
            }
        }
    }

    // Suppression d'une tâche rattachée
    $_GET['tsk_delete'] = isset($_GET['tsk_delete']) ? $_GET['tsk_delete'] :'';
    if($_GET['tsk_delete']){
        Chantier::deleteByTaskBySite(intval($_GET['id_ref']));
        header('Location: chantier.php?success='.urlencode('Suppression de la tâche rattachée effectuée avec succés').'&id='.$_GET['id']);
        exit;
    }

    // Gestion de la liste des bâtiments à afficher
    if ($chantierId > 0) {
        $batimentList = Chantier::chantierBatimentList($chantierId);
        //print_r($chantierObject);
    }

    // Gestion de l'affichage la liste des tâches
    if ($chantierId > 0) {
        $taskList = Chantier::getAllTasksBySyte($chantierId);

    //    var_dump($taskList);

    //    exit;
        $taskTypeList = Chantier::taskTypeBySite($chantierId);
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
