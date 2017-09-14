<pre>
<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 12/09/2017
 * Time: 10:49
 */

// $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey","UTF8");

$str_conn = "31.204.90.68:C:\DSK\Data\dsk2.fdb";

// $dbh = new PDO($str_conn, "SYSDBA", "masterkey");

try {
    $pdo = new PDO($str_conn, "SYSDBA", "masterkey");
}
catch (Exception $e) {
    echo $e->getMessage();
}



/** 1. Liste des chantiers des chefs d'équipe sur la journée sélectionnée.*/
/** Ce sont tous les chantiers sur lesquels les chefs d’équipe ont fait au moins 1 pointage :*/


$sql = "SELECT Booking.NoPers, Pers.FULLNAME, ACCOUNT.CUSTOM  FROM BOOKING
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

 INNER JOIN account on Account.NoAccount=TERMSHISTORY.SIte

 WHERE THEDATE=:THEDATE

AND PERSHISTORY.CUSTOM1='Chef d''équipe'"
;

$stmt = $pdo->prepare($sql);

if ($stmt->execute() === false) {
    print_r($pdo->errorInfo());
}
else {
    $result = $stmt->fetchAll();
}

var_dump($result);

?>

</pre>