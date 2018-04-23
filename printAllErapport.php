<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 29.03.2018
 * Time: 09:29
 */

spl_autoload_register(

 function ($pClassName) {
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

use Classes\Cdcl\Db\User;

$conf = Config::getInstance();

use Classes\Cdcl\Db\Rapport;

/**
 *      Calcul automatique du premier jour et du dernier
 *
 *         $date = new DateTime();
 *         $dateDeb = $date -> format('Y/m/01');
 *         $dateFin = $date -> format('Y/m/t');
 *
 */






if(!empty($_SESSION)){


    $user = new User();

    $listChantier = $user->listChantierByUser2($_SESSION['id']);




    $date = new DateTime();
    $firstOfTheMonth = $date -> format('Y-m-01');
    $lastOfTheMonth = $date -> format('Y-m-t');

    $dateDeb =  $firstOfTheMonth;
    $dateFin =  $lastOfTheMonth;

    //var_dump($firstOfTheMonth);
    //var_dump($lastOfTheMonth);

    //exit;
    // ;

    if(!empty($_POST)) {
        //print_r('ok');
        /*
         * array(4) {
         * ["chantier_id"]=> string(0) ""
         * ["chef_dequipe"]=> string(0) ""
         * ["date_deb"]=> string(0) ""
         * ["date_fin"]=> string(0) ""
         * }
         *
        */




        // date('Y-m-d', strtotime($_GET['date_deb']))
        $chantierId = $_POST['chantier_id']? $_POST['chantier_id']: '%';
        $chefDequipeId = $_POST['chef_dequipe']? $_POST['chef_dequipe']: '%';
        $dateDeb = isset($_POST['date_deb']) ?  date('Y-m-d', strtotime($_POST['date_deb'] ))  : $firstOfTheMonth;
        $dateFin = isset($_POST['date_fin']) ? date('Y-m-d', strtotime($_POST['date_fin']))  : $lastOfTheMonth;
    //    $dateDeb = $dateDeb->format('Y-m-d');
    //    $dateFin = $dateFin->format('Y-m-d');

    //    var_dump($_POST);

    //    exit;


        $formOk = true;

        //var_dump($formOk);

        if($dateFin < $dateDeb){
            $conf->addError('La date de fin ne peut pas être supérieure à la date de début');
            $formOk = false;
        }

        if($formOk){
            $rapportValidatedList = Rapport::getRapportValidatedFiltered($chantierId, $chefDequipeId, $dateDeb, $dateFin);
            //    var_dump($rapportValidatedList);
            //    exit;

            $idRapport = array();
            $date = array();
            $rapportType = array();
            $userId = array();
            $username = array();
            $firstname = array();
            $lastname = array();
            $chantierId = array();
            $code = array();
            $nom = array();
            $submitted = array();
            $validated = array();
            $generatedBy = array();

            foreach($rapportValidatedList as $rapport){
                $idRapport[] = $rapport['id_rapport'];
                $date[] = $rapport['date'];
                $rapportType[] = $rapport['rapport_type'];
                $userId[] = $rapport['user_id'];
                $username[] = $rapport['username'];
                $firstname[] = $rapport['firstname'];
                $lastname[] = $rapport['lastname'];
                $chantierId[] = $rapport['chantier_id'];
                $code[] = $rapport['code'];
                $nom[] = $rapport['nom'];
                $submitted[] = $rapport['submitted'];
                $validated[] = $rapport['validated'];
                $generatedBy[] = $rapport['generated_by'];
            }
            //    var_dump($idRapport);
            $nb= sizeof($idRapport);
        }else{
            $conf->addError('Incohérence dans vos critéres de recherche');
        }
    }


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'printAllErapport.php';
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
