<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 14:36
 */

namespace Classes\Cdcl\Config;


class Dsk {

    /*
     * LISTE DES REQUETES ENVYOYES PAR DSK MISES DANS LA CLASSE Dsk sous forme de fonctions
     * */

    /** 1. Liste des chantiers des chefs d'équipe sur la journée sélectionnée.*/
    /** Ce sont tous les chantiers sur lesquels les chefs d’équipe ont fait au moins 1 pointage :*/

    public static function allChefDEquipeForDay($date){
    //    $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
        $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = "
        SELECT Booking.NoPers,Pers.CODEPERS, Pers.FULLNAME, ACCOUNT.CUSTOM  FROM BOOKING
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
            WHERE THEDATE='".$date."'

        AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS " ;

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)){
            $allChefDEquipeByDay[$i]["matricule"] = trim($row->CODEPERS);
            $allChefDEquipeByDay[$i]["fullname"] = $row->FULLNAME;
            $allChefDEquipeByDay[$i]["chantier"] = $row->CUSTOM;
            $i++;
        }
        return $allChefDEquipeByDay;
    }

    /*2. Liste des chefs d'équipe sur un chantier et une date donnée :*/

    public static function getChefDEquipeOnsiteByDay($chantier, $date){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = "
        SELECT Booking.NoPers, PERS.CODEPERS, Pers.FULLNAME, ACCOUNT.CUSTOM,PERSHISTORY.CUSTOM3 FROM BOOKING
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

      INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SITE) AND (ACCOUNT.CUSTOM = ".$chantier.") )
      WHERE THEDATE ='".$date."'
      AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
    ";

        $sth = ibase_query($dbh, $sql);
        $i=0;
        while($row = ibase_fetch_object($sth)) {
            $chefDEquipeOnsite[$i]["matricule"] = trim($row->CODEPERS);
            $chefDEquipeOnsite[$i]["fullname"] = $row->FULLNAME;
            $chefDEquipeOnsite[$i]["chantier"] = $row->CUSTOM;
            $chefDEquipeOnsite[$i]["noyau"] = $row->CUSTOM3;
            $i++;
        }
    return $chefDEquipeOnsite;
    }

    ### 3. Liste des personnes ayant pointé sur ce chantier pour ce chef d'équipe :

    public static function getTeamPointing($noyau, $chantier, $date){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = " SELECT Booking.NoPers, Pers.CODEPERS, Pers.FULLNAME, ACCOUNT.CUSTOM, PERSHISTORY.CUSTOM3  FROM BOOKING
        INNER JOIN Pers on (Pers.NoPers=Booking.NoPers)
        INNER JOIN PERSHISTORY ON
        ((PERSHISTORY.NOPERS=BOOKING.NOPERS)
            AND (PERSHISTORY.STARTDATE<= BOOKING.THEDATE)
            AND ((PERSHISTORY.ENDDATE IS NULL) OR (PERSHISTORY.ENDDATE>= Booking.THEDATE))
            AND (PERSHISTORY.CUSTOM3= '".$noyau."')
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
            INNER JOIN account on ((Account.NoAccount=TERMSHISTORY.SITE) AND (ACCOUNT.CUSTOM = ".$chantier."))
         WHERE THEDATE='".$date."'
         ";

        $sth = ibase_query($dbh, $sql);
        $i=0;



        while($row = ibase_fetch_object($sth)) {
            $team[$i]["id"] = $row->NOPERS;
            $team[$i]["matricule"] = trim($row->CODEPERS);
            $team[$i]["fullname"] = $row->FULLNAME;
            $team[$i]["chantier"] = $row->CUSTOM;
            $team[$i]["noyau"] = $row->CUSTOM3;
            $i++;
        }

        return $team;
    }

    ###   4. Liste détaillée des absences pour la personne et la date :

    public static function getAbsence($date, $worker){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = "
            SELECT PERS.NOPERS, PERS.CODEPERS, PERS.FULLNAME, ABSENCE.THEDATE, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 FROM ABSENCE
            INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
            INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT
            WHERE THEDATE='".$date."'
            AND PERS.NOPERS= ".$worker."
            ";

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)) {
            $absence[$i]["id"] = $row->NOPERS;
            $absence[$i]["matricule"] = trim($row->CODEPERS);
            $absence[$i]["fullname"] = $row->FULLNAME;
            $absence[$i]["date"] = $row->THEDATE;
            $absence[$i]["timemin"] = $row->TIMEMIN;
            $absence[$i]["caption1"] = $row->CAPTION1;
            $i++;
        }

        return $absence;
    }

    ###   4-bis. Liste détaillée des absences pour tous les ouvriers et la date :

    public static function getAllAbsence($date){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = "
            SELECT PERS.NOPERS,PERS.CODEPERS, PERS.FULLNAME, ABSENCE.THEDATE, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 FROM ABSENCE
            INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
            INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT
            WHERE THEDATE='".$date."'
            ";

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)) {
            $allAbsence[$i]["id"] = $row->NOPERS;
            $allAbsence[$i]["matricule"] = trim($row->CODEPERS);
            $allAbsence[$i]["fullname"] = $row->FULLNAME;
            $allAbsence[$i]["date"] = $row->THEDATE;
            $allAbsence[$i]["timemin"] = $row->TIMEMIN;
            $allAbsence[$i]["motif"] = $row->CAPTION1;
            $i++;
        }

        return $allAbsence;
    }

    //   5. Liste des personnes ayant pointé sur le chantier sélectionné mais ne faisant pas parti d'un chef d'équipe sur ce chantier

    public static function getTeamLess($date, $chantier){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql= "SELECT PERSHISTORY.CUSTOM3, Booking.NoPers, Pers.FULLNAME,PERS.CODEPERS, ACCOUNT.CUSTOM  FROM BOOKING
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

                 INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SIte and ACCOUNT.CUSTOM=".$chantier.")

                 WHERE THEDATE='".$date."'

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

                 INNER JOIN account on (Account.NoAccount=TERMSHISTORY.SITE and ACCOUNT.CUSTOM=".$chantier.")

                 WHERE THEDATE='".$date."'

                AND PERSHISTORY.CUSTOM3 = PERS.CODEPERS
                )";

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)) {
            $horsNoyau[$i]["noyau"] = $row->CUSTOM3;
            $horsNoyau[$i]["id"] = $row->NOPERS;
            $horsNoyau[$i]["matricule"] = trim($row->CODEPERS);
            $horsNoyau[$i]["fullname"] = $row->FULLNAME;
            $horsNoyau[$i]["chantier"] = $row->CUSTOM;
            $i++;
        }

        return $horsNoyau;

    }

    ###   6. Durée cumulée des absences sur une journée pour une personne :

    public static function allCumulatedAbsence($date, $worker){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql = "SELECT PERS.NOPERS, PERS.CODEPERS,PERS.FULLNAME, ABSENCE.THEDATE, SUM(ABSENCE.TIMEMIN) FROM ABSENCE
        INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
        INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT
        WHERE THEDATE='".$date."' AND PERS.NOPERS=".$worker."
        GROUP BY PERS.FULLNAME,ABSENCE.THEDATE "
        ;

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)) {

            $absence_cumulee[$i]["id"] = $row->NOPERS;
            $absence_cumulee[$i]["matricule"] = trim($row->CODEPERS);
            $absence_cumulee[$i]["fullname"] = $row->FULLNAME;
            $absence_cumulee[$i]["date"] = $row->THEDATE;
            $absence_cumulee[$i]["absence"] = $row->ABSENCE;

            $i++;
        }

        return $absence_cumulee;

    }

    // echo "<br>7. Liste des noyaux<br><br>";

    public static function allNoyau(){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql="
                SELECT trim(PERS.CODEPERS) AS CODEPERS FROM PERS
                INNER JOIN PERSHISTORY ON PERSHISTORY.NOPERS=PERS.NOPERS
                WHERE PERSHISTORY.CUSTOM3=PERS.CODEPERS ORDER BY PERS.CODEPERS
                ";

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while($row = ibase_fetch_object($sth)) {
            $team[$i]["noyau"] = $row->CODEPERS;
            $i++;
        }

        return $team;
    }

    // Calcul du total de volume horaire effectué par un intérimare sur un chantier

    public static function getCalculTotalHoraire($date, $chantier){
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
        return $pointeuse;
    }

    // Liste des ouvriers par département

    public static function getWorkerByDepartments(){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql="SELECT PERS.FULLNAME, PERS.NOPERS, PERSHISTORY.CUSTOM1, PERSHISTORY.CODEDEPT FROM PERS
                JOIN PERSHISTORY ON PERS.NOPERS = PERSHISTORY.NOPERS
                WHERE ((PERSHISTORY.STARTDATE <= current_timestamp) AND ((PERSHISTORY.ENDDATE >= current_timestamp) OR PERSHISTORY.ENDDATE IS NULL))
                ORDER BY PERS.FULLNAME
                ";

        $sth = ibase_query($dbh, $sql);

        while ($row = ibase_fetch_object($sth))
        {
            $profession[$i]["matricule"] = $row->NOPERS;
            $profession[$i]["nom"] = $row->FULLNAME;
            $profession[$i]["metier"] = $row->CUSTOM1;
            $profession[$i]["dpt"] = $row->CODEDEPT;

            $i++;
        }

        return $profession;
    }

    // Liste des départements

    public static function departments(){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql="SELECT DISTINCT PERSHISTORY.CODEDEPT FROM PERS
                JOIN PERSHISTORY ON PERS.NOPERS = PERSHISTORY.NOPERS
                WHERE ((PERSHISTORY.STARTDATE <= current_timestamp) AND ((PERSHISTORY.ENDDATE >= current_timestamp) OR PERSHISTORY.ENDDATE IS NULL))
                ORDER BY PERS.FULLNAME
                ";

        $sth = ibase_query($dbh, $sql);

        while ($row = ibase_fetch_object($sth))
        {
            $dept[$i]["dpt"] = $row->CODEDEPT;

            $i++;
        }
    return $dept;
    }

    public static function metier(){
        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql="SELECT DISTINCT PERSHISTORY.CUSTOM1 FROM PERS
                JOIN PERSHISTORY ON PERS.NOPERS = PERSHISTORY.NOPERS
                WHERE ((PERSHISTORY.STARTDATE <= current_timestamp) AND ((PERSHISTORY.ENDDATE >= current_timestamp) OR PERSHISTORY.ENDDATE IS NULL))
                ORDER BY PERS.FULLNAME
                ";

        $sth = ibase_query($dbh, $sql);

        $i=0;

        while ($row = ibase_fetch_object($sth))
        {
            $metier[$i]["metier"] = $row->CUSTOM1;

            $i++;
        }
        return $metier;
    }

    public static function getAllNoyauAbsence($noyau, $date){

        $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");

        $sql="SELECT PERS.FULLNAME, PERS.CODEPERS, ABSENCE.THEDATE, ABSENCE.TIMEMIN, ACCOUNT.CAPTION1 , PERSHISTORY.CUSTOM3 FROM ABSENCE
                INNER JOIN PERS ON PERS.NOPERS = ABSENCE.NOPERS
                INNER JOIN PERSHISTORY ON (PERS.NOPERS = PERSHISTORY.NOPERS )
                INNER JOIN ACCOUNT ON ABSENCE.NOACCOUNT= ACCOUNT.NOACCOUNT

                WHERE THEDATE='".$date."' AND
                (PERSHISTORY.STARTDATE<='".$date."'
                AND (PERSHISTORY.ENDDATE>='".$date."' OR PERSHISTORY.ENDDATE IS NULL) )

                AND PERSHISTORY.CUSTOM3= '".$noyau."'
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

        return $membreNoyauAbsence;
    }

}