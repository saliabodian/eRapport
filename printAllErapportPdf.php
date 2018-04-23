<pre>
<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 05.04.2018
 * Time: 14:34
 */

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

require __DIR__ . '/vendor/autoload.php';

use Classes\Cdcl\Config\Config;

use Classes\Cdcl\Db\User;

use Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();

use Classes\Cdcl\Db\Rapport;


if(!empty($_SESSION)){

    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4-L',
    ]);

    ob_start();


    $user = new User();

    $chantier = new Chantier();

    $listChantier = $user->listChantierByUser2($_SESSION['id']);

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
        //    var_dump($_POST);
        $chantierId = $_POST['chantier_id']? $_POST['chantier_id']: '';
        $chefDequipeId = $_POST['chef_dequipe']? $_POST['chef_dequipe']: '';
        $dateDebut = $_POST['date_deb']? $_POST['date_deb']: '';
        $dateFin = $_POST['date_fin']? $_POST['date_fin']: '';
        //    $formOk = true;

        //var_dump($formOk);
        if(empty($chantierId) && empty($chantierId) && empty($chefDequipeId) && empty($dateDebut) && empty($dateFin)){
            $listPrintableRapport = Rapport::getRapportValidatedLimited();

            if(!empty($listPrintableRapport)){
                foreach($listPrintableRapport as $printableRapport){
                        var_dump($printableRapport);
                    $rapportNoyau = Rapport::getRapportNoyau($printableRapport['user_id'], $printableRapport['date'], $printableRapport['chantier_id']);
                //    var_dump($rapportNoyau);
                    if(!empty($rapportNoyau)){
                        for($i=0; $i<1; $i++) {
                            $idRapportNoyau = $rapportNoyau[$i]['rapport_id'];
                            $chefDequipeMatricule = $rapportNoyau[$i]['chef_dequipe_matricule'];
                            $rapportJournalierDate = $rapportNoyau[$i]['date'];
                            $chantierObject = $chantier->get($rapportNoyau[$i]['chantier']);
                            $_GET["chantier_code"] = $chantierObject->getCode();
                        }
                    }




                    foreach($rapportNoyau as $noyau){
                        $noyauWorkerTask[$noyau['id']] = Rapport::getWorkerTask($noyau['id']);
                    }

                    $noyauHeader = Rapport::getRapportNoyauHeader($idRapportNoyau, $printableRapport['user_id'], $printableRapport['date'], $printableRapport['chantier_id']);

                    $noyauHourGlobal = 0;
                    $noyauHourAbsencesGlobal = 0;
                    $noyauHourPenibleGlobal = 0;
                    $noyauKmGlobal = 0;

                    foreach($rapportNoyau as $noyau){
                        $noyauHourGlobal = $noyauHourGlobal + $noyau['htot'];
                        $noyauHourAbsencesGlobal = $noyauHourAbsencesGlobal + $noyau['habs'];
                        $noyauHourPenibleGlobal = $noyauHourPenibleGlobal + $noyau['hins'];
                        $noyauKmGlobal = $noyauKmGlobal + $noyau['km'];
                    }


                    $rapportHorsNoyau = Rapport::getRapportHorsNoyau($printableRapport['date'], $printableRapport['chantier_id']);
                    if(!empty($rapportHorsNoyau)){
                        for($i=0; $i<1; $i++) {
                            $idRapportHorsNoyau = $rapportHorsNoyau[$i]['rapport_id'];
                        }
                    }

                    foreach($rapportHorsNoyau as $horsNoyau){
                        $horsNoyauTask[$horsNoyau['id']] = Rapport::getWorkerTask($horsNoyau['id']);
                    }

                    $horsNoyauHeader = Rapport::getRapportHorsNoyauHeader($idRapportHorsNoyau, $printableRapport['date'], $printableRapport['chantier_id']);
                    $horsNoyauHourGlobal = 0;
                    $horsNoyauHourAbsencesGlobal = 0;
                    $horsNoyauHourPenibleGlobal = 0;
                    $horsNoyauKmGlobal = 0;

                    foreach($rapportHorsNoyau as $noyau){
                        $horsNoyauHourGlobal = $horsNoyauHourGlobal + $noyau['htot'];
                        $horsNoyauHourAbsencesGlobal = $horsNoyauHourAbsencesGlobal + $noyau['habs'];
                        $horsNoyauHourPenibleGlobal = $horsNoyauHourPenibleGlobal + $noyau['hins'];
                        $horsNoyauKmGlobal = $horsNoyauKmGlobal + $noyau['km'];
                    }
                }
                // endforeach list printable
            }
            exit;
        }

        /*    if ($formOk) {
        *
        *
        *    }else{
        *        $conf->addError('Erreur dans l\'ajout ou la modification');
        *    }
        */
    }

    include $conf->getViewsDir().'printAllErapportPdf.php';

    $html = ob_get_contents();

    ob_end_clean();




// $html = file_get_contents($conf->getViewsDir().'eRapportShowPrint.php');

    $mpdf->WriteHTML($html);
    $mpdf->Output('Liste des rapports journaliers.pdf',\Mpdf\Output\Destination::DOWNLOAD);


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
