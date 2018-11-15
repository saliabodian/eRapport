<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 27.03.2018
 * Time: 16:24
 */


header('Content-Type: text/csv;');
header('Content-Disposition: attachment; filename="test.csv');
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

var_dump($_GET);

exit;

$sql ='select code, nom from tache';

$stmt = $pdo->prepare($sql);

If($stmt->execute()===false){
    print_r($stmt->errorInfo());
}else{
    $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
}
foreach($data as $v){




    if($i==0){
        echo '"'.implode('";"',array_keys($v)).'"'."\n";
    }
    echo '"'.implode('";"',$v).'"'."\n";
    $i++;
}