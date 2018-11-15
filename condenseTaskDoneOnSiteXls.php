<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 08.12.2017
 * Time: 15:46
 */

/*
 * spl_autoload_register();
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
        $xls = Rapport::condenseTaskDoneOnSite($_GET['chantier_id'], $_GET['date_deb'], $_GET['date_fin']);
        CSV::exportCsv($xls, 'Résumé du nombre d\'heures effectuées par tâche par chantier');
    }

 */
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
}
else{
    header('Location: index.php');
}*/

header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename="Résumé des tâches par chantier.csv"');
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


$chantier = isset($_GET['chantier_id'])? $_GET['chantier_id'] : '';
$dateDebut = isset($_GET['date_deb'])? $_GET['date_deb'] : '';
$dateFin = isset($_GET['date_fin'])? $_GET['date_fin'] : '';
$sql ='SELECT
            E.code as code_chantier, E.nom as nom_chantier, B.code as code_tache, B.nom as nom_tache, SUM(A.heures) heures
        FROM
            rapport_detail_has_tache AS A,
            tache AS B,
            rapport_detail AS C,
            rapport AS D,
            chantier AS E
        WHERE
            A.tache_id = B.id
                AND A.rapport_detail_id = C.id
                AND C.rapport_id = D.id
                AND D.chantier = E.id
                AND E.id =:chantier
                AND D.date BETWEEN :dateDebut AND :dateFin
        GROUP BY B.nom
        ORDER BY B.nom';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':chantier', $chantier);
$stmt->bindValue(':dateDebut', $dateDebut);
$stmt->bindValue(':dateFin', $dateFin);

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