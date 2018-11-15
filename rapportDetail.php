<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 09/10/2017
 * Time: 11:42
 */
// spl_autoload_register();

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

use Classes\Cdcl\Db\TypeTache;

use Classes\Cdcl\Db\Rapport;

use Classes\Cdcl\Db\Tache;

use Classes\Cdcl\Db\Chantier;

use Classes\Cdcl\Config\Dsk;

$conf = Config::getInstance();

if(!empty($_SESSION)){


   //var_dump($_POST['matriculeList']);
    //exit;

    /**array(37) {
    ["matriculeList"]=>string(5)
     * "Array"
     * ["htot"]=>string(1) "8"
     * ["abs"]=>string(10) "Congé (C)"
     * ["habs"]=>string(1) "8"
     * ["type_task"]=>array(1)
     * {[0]=>string(22) "Choisir une catégorie"}
     * ["tasks"]=>array(1)
     * {[0]=>string(18) "Choisir une tâche"}
     * ["batiment"]=>array(1) {[0]=>string(0) ""}
     * ["axe"]=>array(1) {[0]=>string(0) ""}
     * ["etage"]=>array(1) {[0]=>string(0) ""}
     * ["type_task2"]=>string(1) "4"["tasks2"]=>string(2) "17"
     * ["batiment2"]=>string(1) "A"
     * ["axe2"]=> string(1) "2"
     * ["etage2"]=>string(1) "1"
     * ["type_task3"]=>string(2) "10"
     * ["tasks3"]=>string(1) "9"
     * ["batiment3"]=>string(1) "B"
     * ["axe3"]=>string(1) "1"
     * ["etage3"]=>string(1) "1"
     * ["type_task4"]=>string(2) "10"
     * ["tasks4"]=>string(2) "74"
     * ["batiment4"]=>string(1) "C"
     * ["axe4"]=>string(1) "1"
     * ["etage4"]=>string(1) "1"
     * ["type_task5"]=>string(1) "4"
     * ["tasks5"]=>string(2) "17"
     * ["batiment5"]=>string(1) "D"
     * ["axe5"]=>string(1) "1"
     * ["etage5"]=>string(1) "1"
     * ["type_task6"]=>string(1) "4"
     * ["tasks6"]=>string(2) "17"
     * ["batiment6"]=>string(1) "E"
     * ["axe6"]=>string(1) "1"
     * ["etage6"]=>string(1) "1"
     * ["hins"]=>string(1) "2"
     * ["dpl_pers"]=>string(0) ""
     * ["km"]=>string(1) "5"
    }*/
    // exit;

    /* *
     *
     * $_POST["rapport_id"]
     * $_POST["rapport_type"]
     * $_POST["chef_dequipe_id"]
     * $_POST["chef_dequipe_matricule"]
     * $_POST["date_generation"]
     * $_POST["chantier_code"]
     * $_POST["chantier_id"]
     * $_POST["check_all"]
     * $_POST["selected_matricule"]
     *
     * */
    /*if($_SESSION['post_id'] === 1){
        $matriculeList = isset($_POST['selected_matricule'])? $_POST['selected_matricule'] : '';
    }*/
    $matriculeList = isset($_POST['selected_matricule'])? $_POST['selected_matricule'] : '';

    $batimentList = Chantier::chantierBatimentList($_POST['chantier_id']);

    $batimentList = isset($batimentList) ? $batimentList : '';



    //var_dump($batimentList);
    /*var_dump($matriculeList);

    foreach( $matriculeList as $matricule){
        var_dump($matricule);
        var_dump($_SESSION['username']);
        if($matricule === $_SESSION['username'] || $matricule === '') {
            $newArray[] = $matricule;
        }
    }

    var_dump($newArray);

    exit;
    */
    $_POST['majForm'] = isset($_POST['majForm'])? $_POST['majForm'] : '';
    if($_POST['majForm']){

    //    var_dump($_POST['machine']);

    //    var_dump($_POST['htot']);
    //
    // exit;

        $form = true;

        //var_dump($_POST['rapport_detail_id']);
       /* foreach($_POST['rapport_detail_id'] as $rapport){
            var_dump($rapport);
       }
       exit;*/
        // Gestion des contrôles a effectué avant soumission
        // du formulaire et insertion en base de données

    //    var_dump($_POST);

    //    exit;

        if( ($_POST['ht']=== '0' ||  $_POST['ht']=== '')
            && ($_POST['ht2']=== '0' || $_POST['ht2']=== '')
            && ($_POST['ht3']=== '0' || $_POST['ht3']=== '')
            && ($_POST['ht4']=== '0' || $_POST['ht4']=== '')
            && ($_POST['ht5']=== '0' ||  $_POST['ht5']=== '')
            && ($_POST['ht6']=== '0' ||  $_POST['ht6']=== '')
            && ($_POST['htot']=== '0' ||  $_POST['htot']=== '')){
            $conf->addError('Veuillez saisir au moins une tâche.');
            $form = false;
        }




        if(($_POST['type_task'])!= 'Catégorie'){
            // var_dump('type task non vide');
            if($_POST['tasks'] === 'Tâche'){
            //    var_dump(' task  vide');
                $conf->addError('Veuillez renseigner la tâche 1');
                $form = false;
            }else{
                if(empty($_POST['ht'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 1');
                    $form = false;
                }
            }
        }

        if(($_POST['type_task2']) != 'Catégorie'){
            if(($_POST['tasks2'])=== 'Tâche'){
                $conf->addError('Veuillez renseigner la tâche 2');
                $form = false;
            }else{
                if(empty($_POST['ht2'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 2');
                    $form = false;
                }
            }
        }

        if(($_POST['type_task3']) != 'Catégorie' ){
            if(($_POST['tasks3']) === 'Tâche' ){
                $conf->addError('Veuillez renseigner la tâche 3');
                $form = false;
            }else{
                if(empty($_POST['ht3'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 3');
                    $form = false;
                }
            }
        }

        if(($_POST['type_task4']) != 'Catégorie' ){
            if(($_POST['tasks4'])  === 'Tâche'){
                $conf->addError('Veuillez renseigner la tâche 4');
                $form = false;
            }else{
                if(empty($_POST['ht4'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 4');
                    $form = false;
                }
            }
        }

        if($_POST['type_task5'] != 'Catégorie'){
            if(($_POST['tasks5']) === 'Tâche'){
                $conf->addError('Veuillez renseigner la tâche 5');
                $form = false;
            }else{
                if(empty($_POST['ht5'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 5');
                    $form = false;
                }
            }
        }

        if(($_POST['type_task6']) != 'Catégorie' ){
            if(($_POST['tasks6'])  === 'Tâche' ){
                $conf->addError('Veuillez renseigner la tâche 6');
                $form = false;
            }else{
                if(empty($_POST['ht6'])){
                    $conf->addError('Veuillez renseigner le nombre d\'heures pour la tâche 6');
                    $form = false;
                }
            }
        }

        if(isset($_POST['dpl_pers'])){
            $dpl_pers = ($_POST['dpl_pers']=== 'on')? 1 : 0;
        }


        if($_SESSION['post_id'] === '1'){
            $chef_dequipe_updated = $_SESSION['username'];
        }else{
            if(($_SESSION['post_id'] != '1') && isset($_POST['chef_dequipe_updated'])){
                $chef_dequipe_updated = $_POST['chef_dequipe_updated'];
            }
        }

        if($_POST['type_task'] === 'Catégorie' && $_POST['tasks'] === 'Tâche' && !empty($_POST['ht'])){
            $conf->addError('Veuillez renseigner la tâche 1');
            $form = false;
        }

        if($_POST['type_task2'] === 'Catégorie' && $_POST['tasks2'] === 'Tâche' && !empty($_POST['ht2'])){
            $conf->addError('Veuillez renseigner la tâche 2');
            $form = false;
        }


        if($_POST['type_task3'] === 'Catégorie' && $_POST['tasks3'] === 'Tâche' && !empty($_POST['ht3'])){
            $conf->addError('Veuillez renseigner la tâche 3');
            $form = false;
        }

        if($_POST['type_task4'] === 'Catégorie' && $_POST['tasks4'] === 'Tâche' && !empty($_POST['ht4'])){
            $conf->addError('Veuillez renseigner la tâche 4');
            $form = false;
        }

        if($_POST['type_task5'] === 'Catégorie' && $_POST['tasks5'] === 'Tâche' && !empty($_POST['ht5'])){
            $conf->addError('Veuillez renseigner la tâche 5');
            $form = false;
        }

        if($_POST['type_task6'] === 'Catégorie' && $_POST['tasks6'] === 'Tâche' && !empty($_POST['ht6'])){
            $conf->addError('Veuillez renseigner la tâche 6');
            $form = false;
        }

        if($form){

            if ($_POST['anomaly']==='true'){

                Rapport::updateRapportDetail($_POST['rapport_detail_id'], $_POST['htot'], $_POST['hins'],$_POST['machine'], $_POST['abs'],
                    $_POST['habs'], $dpl_pers,$_POST['km'], $_POST['remarque'], $chef_dequipe_updated,
                    $_POST['type_task'], $_POST['tasks'], $_POST['bat'], $_POST['axe'], $_POST['et'], $_POST['ht'],
                    $_POST['type_task2'], $_POST['tasks2'], $_POST['bat2'], $_POST['axe2'], $_POST['et2'], $_POST['ht2'],
                    $_POST['type_task3'], $_POST['tasks3'], $_POST['bat3'], $_POST['axe3'], $_POST['et3'], $_POST['ht3'],
                    $_POST['type_task4'], $_POST['tasks4'], $_POST['bat4'], $_POST['axe4'], $_POST['et4'], $_POST['ht4'],
                    $_POST['type_task5'], $_POST['tasks5'], $_POST['bat5'], $_POST['axe5'], $_POST['et5'], $_POST['ht5'],
                    $_POST['type_task6'], $_POST['tasks6'], $_POST['bat6'], $_POST['axe6'], $_POST['et6'], $_POST['ht6']);
                //    exit;
                header('Location: anomalieRh.php?success=' . urlencode('Modification effectuée avec succés'));
                exit;
            }else{
                // var_dump($_POST['machine']);
                // exit;

                Rapport::updateRapportDetail($_POST['rapport_detail_id'], $_POST['htot'], $_POST['hins'], $_POST['machine'], $_POST['abs'],
                    $_POST['habs'], $dpl_pers,$_POST['km'], $_POST['remarque'], $chef_dequipe_updated,
                    $_POST['type_task'], $_POST['tasks'], $_POST['bat'], $_POST['axe'], $_POST['et'], $_POST['ht'],
                    $_POST['type_task2'], $_POST['tasks2'], $_POST['bat2'], $_POST['axe2'], $_POST['et2'], $_POST['ht2'],
                    $_POST['type_task3'], $_POST['tasks3'], $_POST['bat3'], $_POST['axe3'], $_POST['et3'], $_POST['ht3'],
                    $_POST['type_task4'], $_POST['tasks4'], $_POST['bat4'], $_POST['axe4'], $_POST['et4'], $_POST['ht4'],
                    $_POST['type_task5'], $_POST['tasks5'], $_POST['bat5'], $_POST['axe5'], $_POST['et5'], $_POST['ht5'],
                    $_POST['type_task6'], $_POST['tasks6'], $_POST['bat6'], $_POST['axe6'], $_POST['et6'], $_POST['ht6']);
                //    exit;
                header('Location: erapportShow.php?rapport_id='.$_POST['rapport_id'].'&rapport_type='.$_POST['rapport_type'].'&chef_dequipe_id='.$_POST['chef_dequipe_id'].'&chef_dequipe_matricule='.$_POST['chef_dequipe_matricule'].'&date_generation='.$_POST['date_generation'].'&chantier_id='.$_POST['chantier_id'].'&chantier_code='.$_POST['chantier_code'].'&majForm=true');
                exit;
            }

        }else{
            $conf->addError('La mise à jour ne s\'est pas effectuée correctement');


            $listTache= Tache::getAll();

            $listTypeTache = TypeTache::getAll();

            $matriculeList = $_POST['matriculeList'];

            if($_POST["rapport_type"]==='NOYAU'){
                $rapportNoyau = Rapport::getRapportNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
                //var_dump($rapportNoyau);
                foreach($rapportNoyau as $rapport){
                    if(in_array($rapport['ouvrier_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                    if(in_array($rapport['interimaire_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                }
            }

            // var_dump(sizeof($workerToUpdate));
            // exit;
            if($_POST["rapport_type"]==='ABSENT') {
                $rapportNoyauAbsent = Rapport::getRapportAbsentNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
                foreach($rapportNoyauAbsent as $rapport){
                    if(in_array($rapport['ouvrier_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                    if(in_array($rapport['interimaire_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                }
            }


            if($_POST["rapport_type"]==='HORSNOYAU'){
                $rapportHorsNoyau = Rapport::getRapportHorsNoyau($_POST["date_generation"], $_POST["chantier_id"]);
                foreach($rapportHorsNoyau as $rapport){
                    if(in_array($rapport['ouvrier_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                    if(in_array($rapport['interimaire_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                }
            }

            if($_POST["rapport_type"]==='ABSENTHORSNOYAU'){
                $rapportAbsentHorsNoyau = Rapport::getRapportAbsentHorsNoyau($_POST["date_generation"], $_POST["chantier_id"],  $_POST["chef_dequipe_matricule"]);
                foreach($rapportAbsentHorsNoyau as $rapport){
                    if(in_array($rapport['ouvrier_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                    if(in_array($rapport['interimaire_id'], $matriculeList)){
                        $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                        $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                        $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                        $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                        $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                        $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                        $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                        $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                        $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                        $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                        $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                        $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                        $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                        $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                        $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                        $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                        $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                        $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                        $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                        $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                        $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                        $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                        $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                        $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                        $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                        $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                        $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                        $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                        $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                        $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                        $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                        $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                        $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                        $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                        $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                        $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                        $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                        $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                        $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                        $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                        $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                        $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                        $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                        $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                        $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                        $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                        $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                        $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                        $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                        $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                        $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                        $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                        $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                        $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                        $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                        $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                        $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                        $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                        $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                        $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                        $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                        $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                    }
                }
            }


        /*    foreach($workerToUpdate as $worker){
                $workerTaskList = Rapport::getWorkerNoyauTask($worker['rapport_detail_id']);
            }

        */    // var_dump($_POST);

            // Gestion de la composition de la matrice si ce sont uniquement des ouvriers
            // ou si ce sont uniquement des intérimaires ou si c'est un mix

            foreach($workerToUpdate as $worker) {
                if(isset($worker['ouvrier_id'])) {
                    $workerType[] = 'Ouvrier';
                }else {
                    $workerType[] = 'Interimaire';
                }
            }



            /*
             * Test de vérification du txpe de matrice Mix, Ouvrier uniquement ou Interimaire uniquement
             *
            if(in_array('Ouvrier', $workerType) && in_array('Interimaire',$workerType )){
                var_dump('Hello Mix');
            }
            if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType )){
                var_dump('Hello Interimaire');
            }
            if(in_array('Ouvrier', $workerType) && !(in_array('Interimaire',$workerType ))){
                var_dump('Hello ouvrier');
            }
            */

            include $conf->getViewsDir().'header.php';
            include $conf->getViewsDir().'sidebar.php';
            include $conf->getViewsDir().'rapportDetail.php';
            include $conf->getViewsDir().'footer.php';
            exit;

        }

    }

    if(!empty($matriculeList)){

    //    var_dump($_POST);

    //    exit;
    //    $date = "2017-10-16" ;

    //    $chantier = 156100;

     //   $test = Dsk::getCalculTotalHoraire($date, $chantier);

    //    var_dump($test);

    //    exit;

        if($_POST["rapport_type"]==='NOYAU'){
            $rapportNoyau = Rapport::getRapportNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
            //var_dump($rapportNoyau);
            foreach($rapportNoyau as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
            }
        }



        if($_POST["rapport_type"]==='ABSENT') {
            $rapportNoyauAbsent = Rapport::getRapportAbsentNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
            foreach($rapportNoyauAbsent as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
            }
        }


        //var_dump($rapportNoyauAbsent);
        //exit;

        if($_POST["rapport_type"]==='HORSNOYAU'){
            $rapportHorsNoyau = Rapport::getRapportHorsNoyau($_POST["date_generation"], $_POST["chantier_id"]);
            foreach($rapportHorsNoyau as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
            }
        }

        if($_POST["rapport_type"]==='ABSENTHORSNOYAU'){
            $rapportAbsentHorsNoyau = Rapport::getRapportAbsentHorsNoyau($_POST["date_generation"], $_POST["chantier_id"], $_POST["chef_dequipe_matricule"]);
            foreach($rapportAbsentHorsNoyau as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
                    $workerToUpdate[$rapport['id']]['rapport_detail_id']= $rapport['id'];
                    $workerToUpdate[$rapport['id']]['rapport_id']= $rapport['rapport_id'];
                    $workerToUpdate[$rapport['id']]['equipe']= $rapport['equipe'];
                    $workerToUpdate[$rapport['id']]['fullname']= $rapport['fullname'];
                    $workerToUpdate[$rapport['id']]['is_chef_dequipe']= $rapport['is_chef_dequipe'];
                    $workerToUpdate[$rapport['id']]['ouvrier_id']= $rapport['ouvrier_id'];
                    $workerToUpdate[$rapport['id']]['interimaire_id']= $rapport['interimaire_id'];
                    $workerToUpdate[$rapport['id']]['htot']= $rapport['htot'];
                    $workerToUpdate[$rapport['id']]['hins']= $rapport['hins'];
                    $workerToUpdate[$rapport['id']]['machine']= $rapport['machine'];
                    $workerToUpdate[$rapport['id']]['abs']= $rapport['abs'];
                    $workerToUpdate[$rapport['id']]['habs']= $rapport['habs'];
                    $workerToUpdate[$rapport['id']]['dpl_pers']= $rapport['dpl_pers'];
                    $workerToUpdate[$rapport['id']]['km']= $rapport['km'];
                    $workerToUpdate[$rapport['id']]['htot_calc']= $rapport['htot_calc'];
                    $workerToUpdate[$rapport['id']]['remarque']= $rapport['remarque'];
                    $workerToUpdate[$rapport['id']]['filled']= $rapport['filled'];
                    $workerToUpdate[$rapport['id']]['submitted']= $rapport['submitted'];
                    $workerToUpdate[$rapport['id']]['validated']= $rapport['validated'];
                    $workerToUpdate[$rapport['id']]['pointed']= $rapport['pointed'];
                    $workerToUpdate[$rapport['id']]['created']= $rapport['created'];
                    $workerToUpdate[$rapport['id']]['deleted']= $rapport['deleted'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_updated']= $rapport['chef_dequipe_updated'];
                    $workerToUpdate[$rapport['id']]['motif_abs']= $rapport['motif_abs'];
                    $workerToUpdate[$rapport['id']]['date']= $rapport['date'];
                    $workerToUpdate[$rapport['id']]['chef_dequipe_matricule']= $rapport['chef_dequipe_matricule'];
                    $workerToUpdate[$rapport['id']]['chantier']= $rapport['chantier'];
                    $workerToUpdate[$rapport['id']]['type_task_id_1']= $rapport['type_task_id_1'];
                    $workerToUpdate[$rapport['id']]['task_id_1']= $rapport['task_id_1'];
                    $workerToUpdate[$rapport['id']]['bat_1']= $rapport['bat_1'];
                    $workerToUpdate[$rapport['id']]['axe_1']= $rapport['axe_1'];
                    $workerToUpdate[$rapport['id']]['et_1']= $rapport['et_1'];
                    $workerToUpdate[$rapport['id']]['ht1']= $rapport['ht1'];
                    $workerToUpdate[$rapport['id']]['type_task_id_2']= $rapport['type_task_id_2'];
                    $workerToUpdate[$rapport['id']]['task_id_2']= $rapport['task_id_2'];
                    $workerToUpdate[$rapport['id']]['bat_2']= $rapport['bat_2'];
                    $workerToUpdate[$rapport['id']]['axe_2']= $rapport['axe_2'];
                    $workerToUpdate[$rapport['id']]['et_2']= $rapport['et_2'];
                    $workerToUpdate[$rapport['id']]['ht2']= $rapport['ht2'];
                    $workerToUpdate[$rapport['id']]['type_task_id_3']= $rapport['type_task_id_3'];
                    $workerToUpdate[$rapport['id']]['task_id_3']= $rapport['task_id_3'];
                    $workerToUpdate[$rapport['id']]['bat_3']= $rapport['bat_3'];
                    $workerToUpdate[$rapport['id']]['axe_3']= $rapport['axe_3'];
                    $workerToUpdate[$rapport['id']]['et_3']= $rapport['et_3'];
                    $workerToUpdate[$rapport['id']]['ht3']= $rapport['ht3'];
                    $workerToUpdate[$rapport['id']]['type_task_id_4']= $rapport['type_task_id_4'];
                    $workerToUpdate[$rapport['id']]['task_id_4']= $rapport['task_id_4'];
                    $workerToUpdate[$rapport['id']]['bat_4']= $rapport['bat_4'];
                    $workerToUpdate[$rapport['id']]['axe_4']= $rapport['axe_4'];
                    $workerToUpdate[$rapport['id']]['et_4']= $rapport['et_4'];
                    $workerToUpdate[$rapport['id']]['ht4']= $rapport['ht4'];
                    $workerToUpdate[$rapport['id']]['type_task_id_5']= $rapport['type_task_id_5'];
                    $workerToUpdate[$rapport['id']]['task_id_5']= $rapport['task_id_5'];
                    $workerToUpdate[$rapport['id']]['bat_5']= $rapport['bat_5'];
                    $workerToUpdate[$rapport['id']]['axe_5']= $rapport['axe_5'];
                    $workerToUpdate[$rapport['id']]['et_5']= $rapport['et_5'];
                    $workerToUpdate[$rapport['id']]['ht5']= $rapport['ht5'];
                    $workerToUpdate[$rapport['id']]['type_task_id_6']= $rapport['type_task_id_6'];
                    $workerToUpdate[$rapport['id']]['task_id_6']= $rapport['task_id_6'];
                    $workerToUpdate[$rapport['id']]['bat_6']= $rapport['bat_6'];
                    $workerToUpdate[$rapport['id']]['axe_6']= $rapport['axe_6'];
                    $workerToUpdate[$rapport['id']]['et_6']= $rapport['et_6'];
                    $workerToUpdate[$rapport['id']]['ht6']= $rapport['ht6'];
                }
            }
        }


        // exit;

        $listTypeTache = TypeTache::getAll();

        $listTache= Tache::getAll();

        // var_dump($workerToUpdate);
        // exit;

        // Gestion de la composition de la matrice si ce sont uniquement des ouvriers
        // ou si ce sont uniquement des intérimaires ou si c'est un mix

        foreach($workerToUpdate as $worker) {
            if(isset($worker['ouvrier_id'])) {
                $workerType[] = 'Ouvrier';
            }else {
                $workerType[] = 'Interimaire';
            }
        }

    //    var_dump($workerToUpdate);

    //    exit;

        /*
         * Test de vérification du txpe de matrice Mix, Ouvrier uniquement ou Interimaire uniquement
         *
        if(in_array('Ouvrier', $workerType) && in_array('Interimaire',$workerType )){
            var_dump('Hello Mix');
        }
        if(!(in_array('Ouvrier', $workerType)) && in_array('Interimaire',$workerType )){
            var_dump('Hello Interimaire');
        }
        if(in_array('Ouvrier', $workerType) && !(in_array('Interimaire',$workerType ))){
            var_dump('Hello ouvrier');
        }
        */


        include $conf->getViewsDir().'header.php';
        include $conf->getViewsDir().'sidebar.php';
        include $conf->getViewsDir().'rapportDetail.php';
        include $conf->getViewsDir().'footer.php';
    }else{
        header('Location: erapportShow.php?rapport_id='.$_POST['rapport_id'].'&rapport_type='.$_POST['rapport_type'].'&chef_dequipe_id='.$_POST['chef_dequipe_id'].'&chef_dequipe_matricule='.$_POST['chef_dequipe_matricule'].'&date_generation='.$_POST['date_generation'].'&chantier_id='.$_POST['chantier_id'].'&chantier_code='.$_POST['chantier_code'].'&erreur=true');
    }

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