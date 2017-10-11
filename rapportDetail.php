<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 09/10/2017
 * Time: 11:42
 */
spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\TypeTache;

use Classes\Cdcl\Db\Rapport;

$conf = Config::getInstance();

if(!empty($_SESSION)){

   // var_dump($_POST);

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

    $matriculeList = isset($_POST['selected_matricule'])? $_POST['selected_matricule'] : '';

    //var_dump($matriculeList);

    if(!empty($matriculeList)){
        if($_POST["rapport_type"]==='NOYAU'){
            $rapportNoyau = Rapport::getRapportNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
            //var_dump($rapportNoyau);
            foreach($rapportNoyau as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
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
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
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
                }
            }
        }


        //var_dump($workerToUpdate);
        //exit;

        if($_POST["rapport_type"]==='ABSENT') {
            $rapportNoyauAbsent = Rapport::getRapportAbsentNoyau($_POST["chef_dequipe_id"], $_POST["date_generation"], $_POST["chantier_id"]);
            foreach($rapportNoyauAbsent as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
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
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
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
                }
            }
        }


        //var_dump($rapportNoyauAbsent);
        //exit;

        if($_POST["rapport_type"]==='HORSNOYAU'){
            $rapportHorsNoyau = Rapport::getRapportHorsNoyau($_POST["date_generation"], $_POST["chantier_id"]);
            foreach($rapportHorsNoyau as $rapport){
                if(in_array($rapport['ouvrier_id'], $matriculeList)){
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
                }
                if(in_array($rapport['interimaire_id'], $matriculeList)){
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
                }
            }
        }

        $listTypeTache = TypeTache::getAll();
        // var_dump($listTypeTache);
        // exit;


        include $conf->getViewsDir().'header.php';
        include $conf->getViewsDir().'sidebar.php';
        include $conf->getViewsDir().'rapportDetail.php';
        include $conf->getViewsDir().'footer.php';
    }else{
        header('Location: erapportShow.php?rapport_id='.$_POST['rapport_id'].'&rapport_type='.$_POST['rapport_type'].'&chef_dequipe_id='.$_POST['chef_dequipe_id'].'&chef_dequipe_matricule='.$_POST['chef_dequipe_matricule'].'&date_generation='.$_POST['date_generation'].'&chantier_id='.$_POST['chantier_id'].'&chantier_code='.$_POST['chantier_code'].'&erreur=true');
    }

}else{
    header('Location: index.php');
}