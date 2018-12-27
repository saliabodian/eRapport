
<?php

// header('Content-Type: text/csv;');
// header('Content-Disposition: attachment; filename="Résumé des tâches par chantier.csv"');
// $i=0;

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

$sql='SELECT interimaire.id,
                    interimaire.matricule,
                    interimaire.matricule_cns,
                    interimaire.firstname,
                    interimaire.lastname,
                    interimaire.actif,
                    interimaire.taux,
                    interimaire.taux_horaire,
                    interimaire.evaluateur,
                    interimaire.evaluation,
                    interimaire.evaluation_chantier_id,
                    interimaire.charte_securite,
                    interimaire.date_evaluation,
                    interimaire.date_vm,
                    interimaire.date_prem_cont,
                    interimaire.date_cont_rec,
                    interimaire.date_deb,
                    interimaire.date_fin,
                    interimaire.worker_status,
                    interimaire.rem_med,
                    interimaire.remarques,
                    metier.nom_metier,
                    agence.nom,
                    qualification.nom_qualif,
                    departement.nom_dpt,
                    CONCAT(user.username," - ",user.firstname," ", user.firstname) as chef_equipe,
                    CONCAT(chantier.code," - ", chantier.nom) as chantier_de_base
                FROM
                    interimaire
                        LEFT OUTER JOIN
                    `metier` ON `interimaire`.`metier_id` = `metier`.`id`
                        LEFT OUTER JOIN
                    `agence` ON `interimaire`.`agence_id` = `agence`.`id`
                        LEFT OUTER JOIN
                    `qualification` ON `interimaire`.`qualif_id` = `qualification`.`id`
                        LEFT OUTER JOIN
                    `departement` ON `interimaire`.`dpt_id` = `departement`.`id`
                        LEFT OUTER JOIN
                    `user` ON `interimaire`.`user_id` = `user`.`id`
                     LEFT OUTER JOIN
                    `chantier` ON `interimaire`.`evaluation_chantier_id` = `chantier`.`id`
                WHERE
                    interimaire.actif = 1
                ORDER BY interimaire.lastname';
$pdoStmt = $pdo->prepare($sql);
if ($pdoStmt->execute() === false) {
    print_r($pdoStmt->errorInfo());
}
else {
    $allInterimaires = mb_convert_encoding($pdoStmt->fetchAll(\PDO::FETCH_ASSOC), "UTF-8", "Windows-1252");;
    foreach ($allInterimaires as $row) {
        $interimList[$row['id']]['id'] = $row['id'];
        $interimList[$row['id']]['matricule'] = $row['matricule'];
        $interimList[$row['id']]['matricule_cns'] = $row['matricule_cns'];
        $interimList[$row['id']]['firstname'] = $row['firstname'];
        $interimList[$row['id']]['lastname'] = $row['lastname'];
        $interimList[$row['id']]['actif'] = $row['actif'];
        $interimList[$row['id']]['taux'] = $row['taux'];
        $interimList[$row['id']]['taux_horaire'] = $row['taux_horaire'];
        $interimList[$row['id']]['evaluateur'] = $row['evaluateur'];
        $interimList[$row['id']]['evaluation'] = $row['evaluation'];
        $interimList[$row['id']]['evaluation_chantier_id'] = $row['evaluation_chantier_id'];
        $interimList[$row['id']]['charte_securite'] = $row['charte_securite'];
        $interimList[$row['id']]['date_evaluation'] = $row['date_evaluation'];
        $interimList[$row['id']]['date_vm'] = $row['date_vm'];
        $interimList[$row['id']]['date_prem_cont'] = $row['date_prem_cont'];
        $interimList[$row['id']]['date_cont_rec'] = $row['date_cont_rec'];
        $interimList[$row['id']]['date_deb'] = $row['date_deb'];
        $interimList[$row['id']]['date_fin'] = $row['date_fin'];
        $interimList[$row['id']]['worker_status'] = $row['worker_status'];
        $interimList[$row['id']]['rem_med'] = $row['rem_med'];
        $interimList[$row['id']]['remarques'] = $row['remarques'];
        $interimList[$row['id']]['nom_agence'] = $row['nom'];
        $interimList[$row['id']]['nom_metier'] = $row['nom_metier'];
        $interimList[$row['id']]['nom_qualif'] = $row['nom_qualif'];
        $interimList[$row['id']]['nom_dpt'] = $row['nom_dpt'];
        $interimList[$row['id']]['chef_equipe'] = $row['chef_equipe'];
        $interimList[$row['id']]['chantier_de_base'] = $row['chantier_de_base'];
        $interimList[$row['id']]['mobil'] = 'Pas de chantier(s) secondaire(s)';
    }
}

$sql = "SELECT
                    interimaire.matricule, interimaire.id as interimaire_id, chantier.id as chantier_id, CONCAT(chantier.code,' - ', chantier.nom) as chantier
                FROM
                    interimaire_has_chantier,
                    interimaire,
                    chantier
                WHERE
                    interimaire.id = interimaire_has_chantier.interimaire_id
                    AND chantier.id = interimaire_has_chantier.chantier_id
                        AND interimaire.actif = 1
                        AND interimaire_has_chantier.ismobile = 1
                GROUP BY interimaire.id, chantier.id
                ORDER BY interimaire.id, chantier.id";

$stmt = $pdo->prepare($sql);

if($stmt->execute() === false){
    print_r($stmt->errorInfo());
}else{
    $mobilityList = mb_convert_encoding($stmt->fetchAll(\PDO::FETCH_ASSOC), "UTF-8", "Windows-1252");
}
//
$interimaireId = [];

foreach($interimList as $interiamire){
    $interimaireId [] = $interiamire['id'];
}

foreach($interimList as $interim){
    foreach($mobilityList as $intMobile) {
        if(array_search($intMobile['interimaire_id'], $interimaireId) && $intMobile['interimaire_id'] === $interim['id']){
            $interim['mobil'] = $intMobile['chantier']."; " ;
        }else{
            "pas de mobilté";
        }
    }
}

var_dump($interimList);

exit;

?>

    <table class="table table-bordered headerTable">
        <thead>
        <tr>
            <th>Agence</th>
            <th>Intérimaire</th>
            <th>Métier / Qualif</th>
            <th>Département</th>
            <th>Chef d'équipe</th>
            <th>Chantier d'affectation</th>
            <th>Mobilité</th>
        </tr>
        </thead>
        <tbody id="">
        <?php foreach ($interimList as $interimaire) : ?>
            <tr>
                <td><?= $interimaire['nom_agence']?></td>
                <td><?= $interimaire['matricule']." - ".$interimaire['firstname']." ".$interimaire['lastname'] ?></td>
                <td><?= $interimaire['nom_metier']." / ".$interimaire['nom_qualif'] ?></td>
                <td><?= $interimaire['nom_dpt'] ?></td>
                <td><?= $interimaire['chef_equipe']?></td>
                <td><?= $interimaire['chantier_de_base']?></td>
                <td>
                    <?php
                    foreach($mobilityList as $intMobile) {
                        if(array_search($intMobile['interimaire_id'], $interimaireId) && $intMobile['interimaire_id'] === $interimaire['id']){
                            echo $intMobile['chantier']."; " ;
                        }else{
                            "pas de mobilté";
                        }
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>