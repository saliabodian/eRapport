<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 08.12.2017
 * Time: 15:46
 */

// spl_autoload_register();
/*
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

use Classes\Cdcl\Db\Rapport;


use Classes\Cdcl\Db\CSV;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    // var_dump($_SESSION['id']);

   // exit;
    if(!empty($_GET)){
    //    var_dump($_GET);
    //    exit;
        $xls = Rapport::tasksHoursDoneBySiteExcel($_GET['chantier_id'], $_GET['date_deb'], $_GET['date_fin'], $_GET['tasks']);
        CSV::exportCsv($xls, 'Nombre d\'heures effectuées sur une tâche par chantier');
    }

/*

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'index.php';
    include $conf->getViewsDir().'footer.php';
*/
    /**
     *
     *
     * Gestion de la durée pendant laquelle un User peut être
     * sans activité avant que le système ne le déconncete
     * Cette durée a été mis à 15mn soit 900s
     *
     *
     */
/*
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

*/

header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename="Récap des tâches effectuées par ouvrier par chantier.csv"');
$i=0;

$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = 'salihin_cdcl';
$dbDatabase = 'cdcl_test';


$dsn = 'mysql:dbname='.$dbDatabase.';host='.$dbHost.';charset=UTF8';
try {
    $pdo = new \PDO($dsn, $dbUser, $dbPassword);
}
catch(Exception $e) {
    echo 'Config :: Can\'t connect ['.$e->getMessage().']';
    exit;
}

// var_dump($_GET);

// exit;

// $_GET['chantier_id'], $_GET['date_deb'], $_GET['date_fin'], $_GET['tasks']

$chantier = isset($_GET['chantier_id'])? $_GET['chantier_id'] : '';
$dateDebut = isset($_GET['date_deb'])? $_GET['date_deb'] : '';
$dateFin = isset($_GET['date_fin'])? $_GET['date_fin'] : '';
$tache = isset($_GET['tasks'])? $_GET['tasks'] : '';


$sql ="SELECT
            chantier.code,
            chantier.nom,
            rapport.date,
            rapport_detail.ouvrier_id,
            rapport_detail.interimaire_id,
            rapport_detail.fullname,
            tache.code as code_tache,
            tache.nom as nom_tache,
            type_tache.code_type_tache,
            type_tache.nom_type_tache,
            rapport_detail_has_tache.batiment,
            rapport_detail_has_tache.etage,
            rapport_detail_has_tache.axe,
            SUM(rapport_detail_has_tache.heures) as task_hours
        FROM
            type_tache,
            tache,
            rapport_detail,
            rapport,
            chantier,
            rapport_detail_has_tache
        WHERE
            rapport.id = rapport_detail.rapport_id
            AND chantier.id = rapport.chantier
            AND rapport_detail_has_tache.type_tache_id = type_tache.id
            AND rapport_detail_has_tache.tache_id = tache.id
            AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
            AND chantier.id LIKE :chantier
            AND tache.id like :tache
            AND rapport.date BETWEEN :date_debut AND :date_fin
            AND rapport.submitted = 1
            AND rapport.validated = 1
            AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
        GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
        ORDER BY chantier.id";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(':chantier', $chantier);
$stmt->bindValue(':date_debut', $dateDebut);
$stmt->bindValue(':date_fin', $dateFin);
$stmt->bindValue(':tache', $tache);

if($stmt->execute()=== false){
    print_r($stmt->errorInfo());
}else{
    $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

foreach($data as $v){


    if($i==0){
        echo '"'.implode('";"',array_keys($v)).'"'."\n";
    }
    echo '"'.implode('";"',$v).'"'."\n";
    $i++;
}
