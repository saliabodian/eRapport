<pre>
<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 12/09/2017
 * Time: 10:49
 */

// phpinfo();
/*
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'salihin_cdcl');
define('DB_DATABASE', 'cdcl_test');

// définition DSN
$dsn = 'mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';charset=UTF8';

// Instanciation de PDO
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
}
catch (Exception $e) {
    echo $e->getMessage();
}


$sql= "select * from interimaire where evaluation='rien à signaler' and firstname='Rui José'";

$stmt = $pdo->prepare($sql);
$stmt->execute();

var_dump($stmt->fetchAll());

exit;

*/

/*

$dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");




/** 1. Liste des chantiers des chefs d'équipe sur la journée sélectionnée.*/
/** Ce sont tous les chantiers sur lesquels les chefs d’équipe ont fait au moins 1 pointage :*/

/*
echo "1. Liste des chantiers des chefs d'équipe sur la journée sélectionnée.<br><br>";
echo "Ce sont tous les chantiers sur lesquels les chefs d’équipe ont fait au moins 1 pointage :<br><br>";


$sql = "
SELECT Booking.NoPers, Pers.FULLNAME, ACCOUNT.CUSTOM, PERSHISTORY.CUSTOM3  FROM BOOKING
INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
INNER JOIN PERSHISTORY ON
((PERSHISTORY.NOPERS=BOOKING.NOPERS)
    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE)))
LEFT JOIN TERMS ON (
    (
    TERMS.GIDDID = BOOKING.BKT1
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT2
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT3
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT4
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT5
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT6
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT7
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT8
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT9
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT10
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT11
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT12
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT13
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT14
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT15
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT16
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT17
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT18
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT19
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT20
    )
)
  INNER JOIN
  TERMSHISTORY
  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
      AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
      AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

 INNER JOIN account on Account.NoAccount=TERMSHISTORY.SITE

 WHERE THEDATE='2017-10-05'

AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
"
;

// $sql = addslashes(utf8_decode($sql));

// var_dump($sql);

//  exit;

$sth = ibase_query($dbh, $sql);

$i=0;

while($row = ibase_fetch_object($sth)){

$all_chef_dequipe_of_the_day[$i]["NoPers"] = $row->NOPERS;

$all_chef_dequipe_of_the_day[$i]["FULLNAME"] = $row->FULLNAME;

//$pointeuse[$i]["hpoint"] = $row->MINTOH;

$all_chef_dequipe_of_the_day[$i]["CUSTOM"] = $row->CUSTOM;
$all_chef_dequipe_of_the_day[$i]["Noyau"] = $row->CUSTOM3;


$i++;

}

var_dump($all_chef_dequipe_of_the_day);


/*2. Liste des chefs d'équipe sur un chantier et une date donnée :*/
/*
echo "2. Liste des chefs d'équipe sur un chantier et une date donnée :<br><br>";

$sql = "
        SELECT Booking.NoPers, Pers.FULLNAME, ACCOUNT.CUSTOM, PERSHISTORY.CUSTOM3  FROM BOOKING
INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
INNER JOIN PERSHISTORY ON
 ((PERSHISTORY.NOPERS=BOOKING.NOPERS)
 AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
 AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE)))
LEFT JOIN TERMS ON (
  (
  TERMS.GIDDID = BOOKING.BKT1
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT2
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT3
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT4
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT5
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT6
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT7
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT8
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT9
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT10
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT11
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT12
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT13
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT14
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT15
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT16
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT17
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT18
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT19
  ) OR
  (
  TERMS.GIDDID = BOOKING.BKT20
  )
  )
  INNER JOIN
  TERMSHISTORY
  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
  AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
  AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SITE) AND (ACCOUNT.CUSTOM = 156100) )
 WHERE THEDATE = '2017-10-05'

AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
";



$sth = ibase_query($dbh, $sql);

//$row = ibase_fetch_object($sth);

$i=0;

while($row = ibase_fetch_object($sth)) {

    $chef_dequipe_onsite[$i]["NoPers"] = $row->NOPERS;

    $chef_dequipe_onsite[$i]["FULLNAME"] = $row->FULLNAME;

//$pointeuse[$i]["hpoint"] = $row->MINTOH;

    $chef_dequipe_onsite[$i]["CUSTOM"] = $row->CUSTOM;
    $chef_dequipe_onsite[$i]["CUSTOM3"] = $row->CUSTOM3;


    $i++;
}

var_dump($chef_dequipe_onsite);



### 3. Liste des personnes ayant pointé sur ce chantier pour ce chef d'équipe :

echo "<br>3. Liste des personnes ayant pointé sur ce chantier pour ce chef d'équipe :<br><br>";

$sql = "
SELECT Booking.NoPers, Pers.FULLNAME, ACCOUNT.CUSTOM,PERSHISTORY.CUSTOM3  FROM BOOKING
INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
INNER JOIN PERSHISTORY ON
((PERSHISTORY.NOPERS=BOOKING.NOPERS)
    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE))
    AND (PERSHISTORY.CUSTOM3= '177')
)
LEFT JOIN TERMS ON (
    (
    TERMS.GIDDID = BOOKING.BKT1
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT2
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT3
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT4
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT5
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT6
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT7
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT8
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT9
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT10
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT11
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT12
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT13
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT14
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT15
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT16
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT17
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT18
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT19
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT20
    )
)
  INNER JOIN
  TERMSHISTORY
  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
      AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
      AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

 INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SITE) AND (ACCOUNT.CUSTOM = 156100) )

 WHERE THEDATE='2017-10-05'
 ";

$sth = ibase_query($dbh, $sql);

// $row = ibase_fetch_object($sth);

$i=0;

while($row = ibase_fetch_object($sth)) {

    $noyau[$i]["NoPers"] = $row->NOPERS;

    $noyau[$i]["FULLNAME"] = $row->FULLNAME;

//$pointeuse[$i]["hpoint"] = $row->MINTOH;

    $noyau[$i]["CUSTOM"] = $row->CUSTOM;
    $noyau[$i]["CUSTOM3"] = $row->CUSTOM3;


    $i++;
}

var_dump($noyau);

###   4. Liste détaillée des absences pour la personne et la date :

echo "<br>4. Liste détaillée des absences pour la personne et la date :<br><br>";

$sql = "
    SELECT PERS.NOPERS, PERS.FULLNAME, ABSENCE.THEDATE, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 FROM ABSENCE
    INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
    INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT
    WHERE THEDATE='2017-10-05'
    AND PERS.NOPERS= 386
  ";

/**
 * EN ENLEVANT LA CLAUSE AND PER.NOPERS = 386, nous pouvons récupérer toutes les absences quotidiennes quelque
 * soit l'ouvrier
 */

/*

$sth = ibase_query($dbh, $sql);

$i=0;

while($row = ibase_fetch_object($sth)) {

    $absence[$i]["NoPers"] = $row->NOPERS;

    $absence[$i]["FULLNAME"] = $row->FULLNAME;

//$pointeuse[$i]["hpoint"] = $row->MINTOH;

    $absence[$i]["FULLNAME"] = $row->FULLNAME;
    $absence[$i]["THEDATE"] = $row->THEDATE;
    $absence[$i]["TIMEMIN"] = $row->TIMEMIN;
    $absence[$i]["CUSTOM3"] = $row->CAPTION1;


    $i++;
}

var_dump($absence);


//   5. Liste des personnes ayant pointé sur le chantier sélectionné mais ne faisant pas parti d'un chef d'équipe sur ce chantier

echo "<br>5. Liste des personnes ayant pointé sur le chantier sélectionné mais ne faisant pas parti d'un chef d'équipe sur ce chantier<br><br>";

$sql= "SELECT PERSHISTORY.CUSTOM3, Booking.NoPers, Pers.FULLNAME, Pers.CODEPERS, ACCOUNT.CUSTOM  FROM BOOKING
INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
INNER JOIN PERSHISTORY ON
((PERSHISTORY.NOPERS=BOOKING.NOPERS)
    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE)))
LEFT JOIN TERMS ON (
    (
    TERMS.GIDDID = BOOKING.BKT1
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT2
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT3
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT4
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT5
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT6
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT7
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT8
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT9
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT10
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT11
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT12
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT13
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT14
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT15
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT16
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT17
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT18
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT19
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT20
    )
)
  INNER JOIN
  TERMSHISTORY
  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
      AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
      AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

 INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SIte and ACCOUNT.CUSTOM=156100)

 WHERE THEDATE='2017-10-05'

AND PERSHISTORY.CUSTOM3 NOT IN (SELECT PERSHISTORY.CUSTOM3  FROM BOOKING
INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
INNER JOIN PERSHISTORY ON
((PERSHISTORY.NOPERS=BOOKING.NOPERS)
    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE)))
LEFT JOIN TERMS ON (
    (
    TERMS.GIDDID = BOOKING.BKT1
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT2
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT3
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT4
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT5
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT6
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT7
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT8
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT9
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT10
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT11
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT12
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT13
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT14
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT15
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT16
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT17
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT18
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT19
    ) OR
    (
    TERMS.GIDDID = BOOKING.BKT20
    )
)
  INNER JOIN
  TERMSHISTORY
  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
      AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
      AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

 INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SITE and ACCOUNT.CUSTOM=156100)

 WHERE THEDATE='2017-10-05'



AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
)";

$sth = ibase_query($dbh, $sql);

$i=0;

while($row = ibase_fetch_object($sth)) {


    $horsNoyau[$i]["noyau"] = $row->CUSTOM3;
    $horsNoyau[$i]["id"] = $row->NOPERS;
    $horsNoyau[$i]["matricule"] = $row->CODEPERS;
    $horsNoyau[$i]["FULLNAME"] = $row->FULLNAME;
    $horsNoyau[$i]["CUSTOM"] = $row->CUSTOM;


    $i++;
}

var_dump($horsNoyau);

###   6. Durée cumulée des absences sur une journée pour une personne :

echo "<br>6. Durée cumulée des absences sur une journée pour une personne :<br><br>";

$sql = "SELECT PERS.FULLNAME, ABSENCE.THEDATE, SUM(ABSENCE.TIMEMIN) FROM ABSENCE
        INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
        INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT
        WHERE THEDATE='2017-10-05' AND PERS.NOPERS=386
        GROUP BY PERS.FULLNAME,ABSENCE.THEDATE "
;


    $sth = ibase_query($dbh, $sql);

$i=0;

while($row = ibase_fetch_object($sth)) {

    $absence_cumulee[$i]["FULLNAME"] = $row->FULLNAME;
    $absence_cumulee[$i]["THEDATE"] = $row->THEDATE;
    $absence_cumulee[$i]["ABSENCE"] = $row->ABSENCE;


    $i++;
}

var_dump($absence_cumulee);

//echo "<br>7. Liste des noyaux<br><br>";

    $sql="SELECT DISTINCT  CUSTOM3 FROM  PERSHISTORY WHERE CUSTOM3 IS NOT NULL ";


    $sth = ibase_query($dbh, $sql);

    $i=0;

    while($row = ibase_fetch_object($sth)) {

        $team[$i]["noyau"] = $row->CUSTOM3;

        $i++;
    }

//    var_dump($team);

echo "<br>Liste des absences d'un noyau<br><br>";

$sql="SELECT PERS.FULLNAME, PERS.CODEPERS, ABSENCE.THEDATE, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 , PERSHISTORY.CUSTOM3 FROM ABSENCE
                INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
                INNER JOIN PERSHISTORY ON (PERS.NOPERS = PERSHISTORY.NOPERS )
                INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT

                WHERE THEDATE='2017-10-05' AND
                (PERSHISTORY.STARTDATE<='2017-10-05'
                AND (PERSHISTORY.ENDDATE>='2017-10-05' OR PERSHISTORY.ENDDATE IS NULL) )

                AND PERSHISTORY.CUSTOM3= '177'
                ";

$sth = ibase_query($dbh, $sql);

$i=0;

while ($row = ibase_fetch_object($sth))
{
    $membreNoyauAbsence[$i]["matricule"] = trim($row->CODEPERS);
    $membreNoyauAbsence[$i]["fullname"] = $row->FULLNAME;
    $membreNoyauAbsence[$i]["date"] = $row->THEDATE;
    $membreNoyauAbsence[$i]["timemin"] = $row->TIMEMIN;
    $membreNoyauAbsence[$i]["motif"] = $row->CAPTION1;

    $i++;
}

var_dump($membreNoyauAbsence) ;

echo "<br>Autres méthodes de récupérer les noyaux<br>";

$sql="SELECT trim(PERS.CODEPERS) AS CODEPERS FROM PERS
INNER JOIN PERSHISTORY ON PERSHISTORY.NOPERS=PERS.NOPERS
WHERE PERSHISTORY.CUSTOM3=PERS.CODEPERS ORDER BY PERS.CODEPERS";

$sth = ibase_query($dbh, $sql);

$i=0;

while($row = ibase_fetch_object($sth)) {

    $noyau_new[$i]["noyau_new"] = $row->CODEPERS;

    $i++;
}

var_dump($noyau_new);


echo "<br>récupération des pointages<br>";

/*$sql = "Select Rvalue,fullname, codepers, nopers
                from listaccountdate('2017-10-16','2017-10-16') left join pers on pers.nopers = listaccountdate.rnopers where raccount in (156100)";

$rapport_annee = 2017;
$rapport_mois = 10;
$rapport_jour = 16;
    $chantier_int = 156100;

$sql = "Select Rvalue,fullname, codepers, nopers from listaccountdate('".$rapport_annee."-".$rapport_mois."-".$rapport_jour."','".$rapport_annee."-".$rapport_mois."-".$rapport_jour."') left join pers on pers.nopers = listaccountdate.rnopers where raccount in (".$chantier_int.")";
$sth = ibase_query($dbh, $sql);

$i = 0;

while ($row = ibase_fetch_object($sth))
{
    $pointeuse[$i]["matricule"] = trim($row->CODEPERS);
    $pointeuse[$i]["id"] = $row->NOPERS;
    $pointeuse[$i]["nom"] = $row->FULLNAME;
    $pointeuse[$i]["hpoint"] = $row->RVALUE;

    $i++;
}
var_dump($pointeuse) ;
*/

echo "<br>Liste des absents hors noyau<br>";

$dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
//    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

$sql = "
        SELECT PERS.CODEPERS, Absence.NoPers,Absence.Thedate, Pers.FULLNAME, ACCOUNT.CUSTOM, TERMS.GIDDID, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 FROM Absence
            INNER JOIN Pers on (Pers.NoPers=ABSENCE.NoPers)
            INNER JOIN PERSHISTORY ON
             ((PERSHISTORY.NOPERS=ABSENCE.NOPERS)
             AND (PERSHISTORY.STARTDATE<= ABSENCE.THEDATE)
             AND (PERS.CODECOSTCENTERREF NOT IN ('5470', '5420'))
             AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= ABSENCE.THEDATE))
            )
            INNER JOIN Booking ON
             ((Booking.NOPERS=Absence.NOPERS)
             AND (Booking.THEDATE=(SELECT MAX(THEDATE) from booking where (booking.NoPers = Pers.NoPers and (booking.BK1<>0 or booking.BK2<>0) and booking.THEDATE<='2018-01-31')))
            )

            LEFT JOIN TERMS ON (
              (
              TERMS.GIDDID = BOOKING.BKT1
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT2
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT3
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT4
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT5
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT6
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT7
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT8
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT9
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT10
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT11
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT12
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT13
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT14
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT15
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT16
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT17
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT18
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT19
              ) OR
              (
              TERMS.GIDDID = BOOKING.BKT20
              )
              )
              INNER JOIN
              TERMSHISTORY
              ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
              AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
              AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

            INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SIte) AND (ACCOUNT.CUSTOM = 163066) )

            WHERE Absence.THEDATE='2018-01-31'
            AND  PERSHISTORY.CUSTOM3 <> '646'
            AND (PERS.CODECOSTCENTERREF NOT IN ('5470', '5420'))
            ";

$sth = ibase_query($dbh, $sql);

$i = 0;

while ($row = ibase_fetch_object($sth))
{
    $absenceHorsNoyau[$i]["matricule"] = trim($row->CODEPERS);
    $absenceHorsNoyau[$i]["fullname"] = $row->FULLNAME;
    $absenceHorsNoyau[$i]["date"] = $row->THEDATE;
    $absenceHorsNoyau[$i]["timemin"] = $row->TIMEMIN;
    $absenceHorsNoyau[$i]["motif"] = $row->CAPTION1;

    $i++;
}

var_dump($absenceHorsNoyau);

/**/
echo "<br><br>";
    echo "Les hors noyaux pour une date donnée";
echo "<br><br>";
    $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");



    $sql= "SELECT PERSHISTORY.CUSTOM3, Booking.NoPers, Pers.FULLNAME,PERS.CODEPERS, ACCOUNT.CUSTOM  FROM BOOKING
                INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
                INNER JOIN PERSHISTORY ON
                ((PERSHISTORY.NOPERS=BOOKING.NOPERS)
                    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
                    AND (PERS.CODECOSTCENTERREF NOT IN ('5470', '5420'))
                    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE))
                )
                LEFT JOIN TERMS ON (
                    (
                    TERMS.GIDDID = BOOKING.BKT1
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT2
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT3
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT4
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT5
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT6
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT7
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT8
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT9
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT10
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT11
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT12
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT13
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT14
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT15
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT16
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT17
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT18
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT19
                    ) OR
                    (
                    TERMS.GIDDID = BOOKING.BKT20
                    )
                )
                  INNER JOIN
                  TERMSHISTORY
                  ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
                      AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
                      AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

                 INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SIte and ACCOUNT.CUSTOM=163066)

                 WHERE THEDATE='2018-03-05'

                AND PERSHISTORY.CUSTOM3 NOT IN (SELECT PERSHISTORY.CUSTOM3  FROM BOOKING
                INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
                INNER JOIN PERSHISTORY ON
                ((PERSHISTORY.NOPERS=BOOKING.NOPERS)
                    AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
                    AND (PERS.CODECOSTCENTERREF NOT IN ('5470', '5420'))
                    AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE)))
                    LEFT JOIN TERMS ON (
                        (
                        TERMS.GIDDID = BOOKING.BKT1
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT2
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT3
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT4
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT5
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT6
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT7
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT8
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT9
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT10
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT11
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT12
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT13
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT14
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT15
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT16
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT17
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT18
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT19
                        ) OR
                        (
                        TERMS.GIDDID = BOOKING.BKT20
                        )
                    )
                    INNER JOIN
                        TERMSHISTORY
                    ON ((TERMSHISTORY.NOTERM = TERMS.NOTERM)
                    AND (TERMSHISTORY.STARTDATE<=BOOKING.THEDATE)
                    AND ((TERMSHISTORY.ENDDATE>=BOOKING.THEDATE) OR TERMSHISTORY.ENDDATE IS NULL))

                    INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SITE and ACCOUNT.CUSTOM=163066)

                    WHERE THEDATE='2018-03-05'

                    AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
                )";
    // AND ((PERSHISTORY.CODECOSTCENTER <> '5470') OR (PERSHISTORY.CODECOSTCENTER <> '5420'))
    $sth = ibase_query($dbh, $sql);

    //    var_dump($sql);

    //    exit;
    $i=0;

    while($row = ibase_fetch_object($sth)) {
        $horsNoyau[$i]["noyau"] = $row->CUSTOM3;
        $horsNoyau[$i]["id"] = $row->NOPERS;
        $horsNoyau[$i]["matricule"] = trim($row->CODEPERS);
        $horsNoyau[$i]["fullname"] = $row->FULLNAME;
        $horsNoyau[$i]["chantier"] = $row->CUSTOM;
        $i++;
    }

    $horsNoyau = isset($horsNoyau) ? $horsNoyau : '';

    var_dump($horsNoyau);


$dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
//    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");


$stmt = "select noaccount, caption1, custom, giddid
                from account
                left join termshistory on account.NOACCOUNT = termshistory.site left join terms on termshistory.NOTERM = terms.NOTERM
                where (noaccount > 20000) and (mod(noaccount,10) = 1) and (account.custom = 163066)";

$sth = ibase_query($dbh, $stmt);
$row = ibase_fetch_object($sth);
$chantier_id = $row->NOACCOUNT;

$sql = "
                Select Rvalue,fullname, codepers, nopers, raccount
                from listaccountdate('2018-03-05', '2018-03-05')
                left join pers on pers.nopers = listaccountdate.rnopers
                where raccount in (".$chantier_id.")
                ";

$sth = ibase_query($dbh, $sql);

$i = 0;

while ($row = ibase_fetch_object($sth))
{
    $pointeuse[$i]["matricule"] = trim($row->CODEPERS);
    $pointeuse[$i]["id"] = $row->NOPERS;
    $pointeuse[$i]["nom"] = $row->FULLNAME;
    $pointeuse[$i]["hpoint"] = $row->RVALUE/60;

    $i++;
}

var_dump($pointeuse);


//public static function getCalculTotalHoraire($date, $chantier){
        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");


        $stmt = "select noaccount, caption1, custom, giddid
                from account
                left join termshistory on account.NOACCOUNT = termshistory.site left join terms on termshistory.NOTERM = terms.NOTERM
                where (noaccount > 20000) and (mod(noaccount,10) = 1) and (account.custom = ".$chantier.")";

        $sth = ibase_query($dbh, $stmt);
        $row = ibase_fetch_object($sth);
        $chantier_id = $row->NOACCOUNT;

        $sql = "
                Select Rvalue,fullname, codepers, nopers, raccount
                from listaccountdate('".$date."', '".$date."')
                left join pers on pers.nopers = listaccountdate.rnopers
                where raccount in (".$chantier_id.")
                ";

        $sth = ibase_query($dbh, $sql);

        $i = 0;

        while ($row = ibase_fetch_object($sth))
        {
            $pointeuse[$i]["matricule"] = trim($row->CODEPERS);
            $pointeuse[$i]["id"] = $row->NOPERS;
            $pointeuse[$i]["nom"] = $row->FULLNAME;
            $pointeuse[$i]["hpoint"] = $row->RVALUE/60;

            $i++;
        }



?>
</pre>

