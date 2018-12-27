<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 20.07.2018
 * Time: 13:55
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


use \Classes\Cdcl\Config\Config;


use \Classes\Cdcl\Db\User;

$conf = Config::getInstance();
if(!empty($_SESSION)){

    $ExportTxtDir= array_diff(scandir("ExportTxt"),  array(".", ".."));
    $ExportHoursDir= array_diff(scandir("ExportHours"),  array(".", ".."));
    $ExportKmDir= array_diff(scandir("ExportKm"),  array(".", "..") );
    $ExportTpenDir= array_diff(scandir("ExportTpen"),  array(".", ".."));

    $user = new User();

    $form = true;

    $dateDebut = isset($_POST['date_deb'])?  date('Y-m-d', strtotime($_POST['date_deb']))  : '';
    $dateFin = isset($_POST['date_fin'])? date('Y-m-d', strtotime($_POST['date_fin'])) : '';


    if(!empty($_POST)){

        $_POST['T'] = isset($_POST['T'])? $_POST['T'] : '';

        $_POST['H'] = isset($_POST['H'])? $_POST['H'] : '';

        $_POST['KM'] = isset($_POST['KM'])? $_POST['KM'] : '';

        $_POST['TPEN'] = isset($_POST['TPEN'])? $_POST['TPEN'] : '';

        /*
         *
         *
         * Export des T pour les ouvriers CDCL
         *
         *
         * */
        if($_POST['T'] === '1'){

        //    var_dump($_POST);
        //    var_dump($_GET);
        //    echo "On est la chez les T ouvriers CDCL";
            if(empty($dateDebut) || $dateDebut === '1970-01-01'){
                $conf->addError('Veuillez renseigner l\'heure de début.');
                $form = false;
            }

            if(empty($dateFin) || $dateFin === '1970-01-01'){

                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($dateFin < $dateDebut){
                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($form){
                $contenu = '';

                $contenu .= '';

                $fichier = 'ExportTxt\export_'.$dateDebut.'_'.$dateFin.'.txt';

                $exportDplList = $user->getDplForExport($dateDebut, $dateFin);

                foreach($exportDplList as $dpl){
                    $contenu .= $dpl['code_entreprise'].
                        "\t".$dpl['ouvrier_id'].
                        "\t".$dpl['am'].
                        "\t".$dpl['code_p'].
                        "\t".$dpl['jd'].
                        "\t".$dpl['jf'].
                        "\t".$dpl['code_cpt_tache'].
                        "\t".$dpl['code_interne0'].
                        "\t".$dpl['code_interne1'].
                        "\t".$dpl['dpl_pers'].
                        "\t".$dpl['code_interne2'].
                        "\t".$dpl['code_interne3'].
                        "\t".$dpl['code_interne4'].
                        "\t".$dpl['code_interne5'].
                        "\t".$dpl['code_interne6'].
                        "\r\n";
                }

                if(file_exists($fichier)){
                    unlink($fichier);
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }else{
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }

                $conf->addSuccess('L\'export des T s\'est déroulé avec succés !.');

            //    header('Location: exportDpl.php?success='.urlencode('Génération du fichier avec succès.'));
            //    exit;

            }else{
                $conf->addError('Veuillez redéfinir vos critères d\'importation.');
            }
        }

        // var_dump($_POST);
        /*
         *
         *
         * Export des heures des intérimaires
         *
         *
         * */
        if($_POST['H'] === '1'){
        //    echo "On est la chez les Heures intérimaires";
            if(empty($dateDebut) || $dateDebut === '1970-01-01'){
                $conf->addError('Veuillez renseigner l\'heure de début.');
                $form = false;
            }

            if(empty($dateFin) || $dateFin === '1970-01-01'){

                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($dateFin < $dateDebut){
                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($form){
                $contenu = '';

                $contenu .= '';

                $fichier = 'ExportHours\export_'.$dateDebut.'_'.$dateFin.'.txt';

                $exportDplList = $user->getIntHoursForExport($dateDebut, $dateFin);

                foreach($exportDplList as $dpl){
                    $contenu .= $dpl['code_entreprise'].
                        "\t".$dpl['interimaire_id'].
                        "\t".$dpl['am'].
                        "\t".$dpl['code_p'].
                        "\t".$dpl['jd'].
                        "\t".$dpl['jf'].
                        "\t".$dpl['code_cpt_tache'].
                        "\t".$dpl['code_chantier'].
                        "\t".$dpl['code_interne1'].
                        "\t".$dpl['heures'].
                        "\t".$dpl['code_interne2'].
                        "\t".$dpl['code_interne3'].
                        "\t".$dpl['code_interne4'].
                        "\t".$dpl['code_interne5'].
                        "\t".$dpl['code_interne6'].
                        "\r\n";
                }

                if(file_exists($fichier)){
                    unlink($fichier);
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }else{
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }

                $conf->addSuccess('L\'export des heures des intérimaires s\'est déroulé avec succés !.');

            //    header('Location: exportDpl.php?success='.urlencode('Génération du fichier avec succès.'));
            //    exit;

            }else{
                $conf->addError('Veuillez redéfinir vos critères d\'importation.');
            }
        }

        /*
        *
        *
        * Export des Km Ouvrier CDC
        *
        *
        * */
        if($_POST['KM'] === '1'){
            //    echo "On est la chez les Heures intérimaires";
            if(empty($dateDebut) || $dateDebut === '1970-01-01'){
                $conf->addError('Veuillez renseigner l\'heure de début.');
                $form = false;
            }

            if(empty($dateFin) || $dateFin === '1970-01-01'){

                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($dateFin < $dateDebut){
                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($form){
                $contenu = '';

                $contenu .= '';

                $fichier = 'ExportKm\export_'.$dateDebut.'_'.$dateFin.'.txt';

                $exportDplList = $user->getKmForExport($dateDebut, $dateFin);

                foreach($exportDplList as $dpl){
                    $contenu .= $dpl['code_entreprise'].
                        "\t".$dpl['matricule'].
                        "\t".$dpl['am'].
                        "\t".$dpl['code_p'].
                        "\t".$dpl['jd'].
                        "\t".$dpl['jf'].
                        "\t".$dpl['code_cpt_tache'].
                        "\t".$dpl['code'].
                        "\t".$dpl['code_interne1'].
                        "\t".$dpl['km'].
                        "\t".$dpl['code_interne2'].
                        "\t".$dpl['code_interne3'].
                        "\t".$dpl['code_interne4'].
                        "\t".$dpl['code_interne5'].
                        "\t".$dpl['code_interne6'].
                        "\r\n";
                }

                if(file_exists($fichier)){
                    unlink($fichier);
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }else{
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }

                $conf->addSuccess('L\'export des Kilométres s\'est déroulé avec succés !.');

            //    header('Location: exportDpl.php?success='.urlencode('Génération du fichier avec succès.'));
            //    exit;

            }else{
                $conf->addError('Veuillez redéfinir vos critères d\'importation.');
            }
        }

        /*
        *
        *
        * Export des Km Ouvrier CDC
        *
        *
        * */
        if($_POST['TPEN'] === '1'){
            //    echo "On est la chez les Heures intérimaires";
            if(empty($dateDebut) || $dateDebut === '1970-01-01'){
                $conf->addError('Veuillez renseigner l\'heure de début.');
                $form = false;
            }

            if(empty($dateFin) || $dateFin === '1970-01-01'){

                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($dateFin < $dateDebut){
                $conf->addError('Veuillez renseigner une heure de fin valide.');
                $form = false;
            }

            if($form){
                $contenu = '';

                $contenu .= '';

                $fichier = 'ExportTpen\export_'.$dateDebut.'_'.$dateFin.'.txt';

                $exportDplList = $user->getTPenForExport($dateDebut, $dateFin);

                foreach($exportDplList as $dpl){
                    $contenu .= $dpl['code_entreprise'].
                        "\t".$dpl['matricule'].
                        "\t".$dpl['am'].
                        "\t".$dpl['code_p'].
                        "\t".$dpl['jd'].
                        "\t".$dpl['jf'].
                        "\t".$dpl['code_cpt_tache'].
                        "\t".$dpl['code'].
                        "\t".$dpl['code_interne1'].
                        "\t".$dpl['hins'].
                        "\t".$dpl['code_interne2'].
                        "\t".$dpl['code_interne3'].
                        "\t".$dpl['code_interne4'].
                        "\t".$dpl['code_interne5'].
                        "\t".$dpl['code_interne6'].
                        "\r\n";
                }

                if(file_exists($fichier)){
                    unlink($fichier);
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }else{
                    $f = fopen($fichier, 'x+');
                    fwrite($f, $contenu);
                    fclose($f);
                }

                $conf->addSuccess('L\'export des heures de travaux pénibles s\'est déroulé avec succés !.');

                //    header('Location: exportDpl.php?success='.urlencode('Génération du fichier avec succès.'));
                //    exit;

            }else{
                $conf->addError('Veuillez redéfinir vos critères d\'importation.');
            }
        }
    }



//    var_dump($_POST);
//var_dump($form);
//var_dump($dateDebut);
//var_dump($dateFin);




    // var_dump($exportDplList);

    // exit;


    $ExportTxtDir= array_diff(scandir("ExportTxt"),  array(".", ".."));
    $ExportHoursDir= array_diff(scandir("ExportHours"),  array(".", ".."));
    $ExportKmDir= array_diff(scandir("ExportKm"),  array(".", "..") );
    $ExportTpenDir= array_diff(scandir("ExportTpen"),  array(".", ".."));

    include $conf->getViewsDir().'headerTableExport.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'exportDpl.php';
    include $conf->getViewsDir().'footerTableExport.php';
}else {
    header('Location: index.php');
}
