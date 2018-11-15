<pre>
<?php
echo " Calcul du total de volume horaire effectué par un intérimare sur un chantier ";

    $dbh = ibase_connect("31.204.90.68:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");
    //    $dbh = ibase_connect("10.10.110.30:C:\DSK\Data\dsk2.fdb","SYSDBA","masterkey");


    $stmt = "select noaccount, caption1, custom, giddid
                from account
                left join termshistory on account.NOACCOUNT = termshistory.site left join terms on termshistory.NOTERM = terms.NOTERM
                where (noaccount > 20000) and (mod(noaccount,10) = 1) and (account.custom = 156100)";

    $sth = ibase_query($dbh, $stmt);
    $row = ibase_fetch_object($sth);
    $chantier_id = $row->NOACCOUNT;

    $sql = "
                Select Rvalue,fullname, codepers, nopers, raccount
                from listaccountdate('2018-06-25', '2018-06-25')
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