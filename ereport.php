<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 10:57
 */

spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use \Classes\Cdcl\Db\Interimaire;

use Classes\Cdcl\Db\Metier;

use Classes\Cdcl\Db\Agence;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Db\Qualification;

use Classes\Cdcl\Db\Departement;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Config\Dsk;

$conf = Config::getInstance();

if(!empty($_SESSION)){
    // var_dump($_SESSION['post_id']===7);


    //$chantierList = 156100;
    //$date ='2017-09-25';

    //

    // Dsk::getChefDEquipeOnsiteByDay($chantierList, $date);

    // exit;

    $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
/*
    $sql = "
        SELECT Booking.NoPers, Pers.FULLNAME, ACCOUNT.CUSTOM  FROM BOOKING
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

      INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SITE) AND (ACCOUNT.CUSTOM =".$chantierList.") )
      WHERE THEDATE ='".$date."'
      AND PERSHISTORY.CUSTOM1 LIKE 'Chef d''%quipe'
    ";

    $sth = ibase_query($dbh, $sql);

    */

    //$row = ibase_fetch_object($sth);

    $i=0;

    while($row = ibase_fetch_object($sth)) {

        $chef_dequipe_onsite[$i]["NoPers"] = $row->NOPERS;

        $chef_dequipe_onsite[$i]["FULLNAME"] = $row->FULLNAME;

        $chef_dequipe_onsite[$i]["CUSTOM"] = $row->CUSTOM;

        $i++;
    }

    var_dump($chef_dequipe_onsite);




    //   include $conf->getViewsDir().'header.php';
 //   include $conf->getViewsDir().'sidebar.php';
 //   include $conf->getViewsDir().'ereport.php';
 //   include $conf->getViewsDir().'footer.php';

}else{
    header('Location: index.php');
}