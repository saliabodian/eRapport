<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 05/09/2017
 * Time: 08:23
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

class Interimaire extends DbObject{

    /*---------------------Properties------------------*/

    /**
     * @var string
     */
    public $matricule;

    /**
     * @var double
     */
    public $matricule_cns;

    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var bool
     */
    public $actif;

    /**
     * @var double
     */
    public $taux;

    /**
     * @var double
     */
    public $taux_horaire;

    /**
     * @var string
     */
    public $evaluation;

    /**
     * @var string
     */
    public $evaluateur;

    /**
     * @var Chantier
     */
    public $chantier_id;

    /**
     * @var bool
     */
    public $charte_securite;
    /**
     * @var date
     */
    public $date_evaluation;

    /**
     * @var date
     */
    public $date_vm;

    /**
     * @var date
     */
    public $date_prem_cont;

    /**
     * @var date
     */
    public $date_cont_rec;

    /**
     * @var date
     */
    public $date_deb;

    /**
     * @var date
     */
    public $date_fin;

    /**
     * @var string
     */
    public $worker_status;

    /**
     * @var string
     */
    public $rem_med;

    /**
     * @var string
     */
    public $remarques;

    /**
     * @var string
     */
    public $old_metier_denomination;

    /**
     * @var Metier
     */
    public $metier_id;

    /**
     * @var Agence
     */
    public $agence_id;

    function __construct($id=0, $matricule='', $matricule_cns=0, $firstname='', $lastname='', $actif=0, $taux=0, $taux_horaire=0, $evaluation=null, $evaluateur=null, $chantier_id=null, $charte_securite=0, $date_evaluation=0, $date_vm=0, $date_prem_cont=0, $date_cont_rec=0, $date_deb=0, $date_fin=0, $worker_status=0, $rem_med='', $remarques='', $old_metier_denomination='', $metier_id=null, $agence_id=null, $created=0)
    {
        $this->matricule = $matricule;
        $this->matricule_cns = $matricule_cns;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->actif = $actif;
        $this->taux = $taux;
        $this->taux_horaire = $taux_horaire;
        $this->evaluation = $evaluation;
        $this->evaluateur = $evaluateur;
        $this->chantier_id = isset($chantier_id)? $chantier_id : new Chantier();
        $this->charte_securite = $charte_securite;
        $this->date_evaluation = $date_evaluation;
        $this->date_vm = $date_vm;
        $this->date_prem_cont = $date_prem_cont;
        $this->date_cont_rec = $date_cont_rec;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->worker_status = $worker_status;
        $this->rem_med = $rem_med;
        $this->remarques = $remarques;
        $this->old_metier_denomination = $old_metier_denomination;
        $this->metier_id = isset($metier_id) ? $metier_id : new Metier();
        $this->agence_id = isset($agence_id) ? $agence_id : new Agence();
        parent::__construct($id, $created);
    }


    /**
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @return double
     */
    public function getMatriculeCns()
    {
        return $this->matricule_cns;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return boolean
     */
    public function isActif()
    {
        return $this->actif;
    }

    /**
     * @return float
     */
    public function getTaux()
    {
        return $this->taux;
    }

    /**
     * @return float
     */
    public function getTauxHoraire()
    {
        return $this->taux_horaire;
    }

    /**
     * @return string
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @return string
     */
    public function getEvaluateur()
    {
        return $this->evaluateur;
    }

    /**
     * @return Chantier
     */
    public function getChantierId()
    {
        return $this->chantier_id;
    }

    /**
     * @return boolean
     */
    public function isCharteSecurite()
    {
        return $this->charte_securite;
    }

    /**
     * @return date
     */
    public function getDateEvaluation()
    {
        return $this->date_evaluation;
    }

    /**
     * @return date
     */
    public function getDateVm()
    {
        return $this->date_vm;
    }

    /**
     * @return date
     */
    public function getDatePremCont()
    {
        return $this->date_prem_cont;
    }

    /**
     * @return date
     */
    public function getDateContRec()
    {
        return $this->date_cont_rec;
    }

    /**
     * @return date
     */
    public function getDateDeb()
    {
        return $this->date_deb;
    }

    /**
     * @return date
     */
    public function getDateFin()
    {
        return $this->date_fin;
    }

    /**
     * @return string
     */
    public function getWorkerStatus()
    {
        return $this->worker_status;
    }

    /**
     * @return string
     */
    public function getRemMed()
    {
        return $this->rem_med;
    }

    /**
     * @return string
     */
    public function getRemarques()
    {
        return $this->remarques;
    }

    /**
     * @return string
     */
    public function getOldMetierDenomination()
    {
        return $this->old_metier_denomination;
    }

    /**
     * @return Metier
     */
    public function getMetierId()
    {
        return $this->metier_id;
    }

    /**
     * @return Agence
     */
    public function getAgenceId()
    {
        return $this->agence_id;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
        /**
         *
         *     $agence_id=null, $created=0
        */
    {
        $sql='SELECT
                `id`,
                `matricule`,
                `matricule_cns`,
                `firstname`,
                `lastname`,
                `actif`,
                `taux`,
                `taux_horaire`,
                `evaluation`,
                `evaluateur`,
                `evaluation_chantier_id`,
                `charte_securite`,
                `date_evaluation`,
                `date_vm`,
                `date_prem_cont`,
                `date_cont_rec`,
                `date_deb`,
                `date_fin`,
                `worker_status`,
                `rem_med`,
                `remarques`,
                `old_metier_denomination`,
                `metier_id`,
                `agence_id`
                 FROM interimaire
                 WHERE id= :id' ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $interimaireObject = new Interimaire(
                $data['id'],
                $data['matricule'],
                $data['matricule_cns'],
                $data['firstname'],
                $data['lastname'],
                $data['actif'],
                $data['taux'],
                $data['taux_horaire'],
                $data['evaluation'],
                $data['evaluateur'],
                new Chantier($data['evaluation_chantier_id']),
                $data['charte_securite'],
                $data['date_evaluation'],
                $data['date_vm'],
                $data['date_prem_cont'],
                $data['date_cont_rec'],
                $data['date_deb'],
                $data['date_fin'],
                $data['worker_status'],
                $data['rem_med'],
                $data['remarques'],
                $data['old_metier_denomination'],
                new Metier($data['metier_id']),
                new Agence($data['agence_id']),
                $data['created']
            );
        }
        return $interimaireObject;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql='SELECT * FROM interimaire';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allInterimaires = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allInterimaires as $row) {

                $returnList[$row['id']]['matricule'] = $row['matricule'];
                $returnList[$row['id']]['matricule_cns'] = $row['matricule_cns'];
                $returnList[$row['id']]['firstname'] = $row['firstname'];
                $returnList[$row['id']]['lastname'] = $row['lastname'];
                $returnList[$row['id']]['actif'] = $row['actif'];
                $returnList[$row['id']]['taux'] = $row['taux'];
                $returnList[$row['id']]['taux_horaire'] = $row['taux_horaire'];
                $returnList[$row['id']]['evaluateur'] = $row['evaluateur'];
                $returnList[$row['id']]['evaluation'] = $row['evaluation'];
                $returnList[$row['id']]['evaluation_chantier_id'] = $row['evaluation_chantier_id'];
                $returnList[$row['id']]['charte_securite'] = $row['charte_securite'];
                $returnList[$row['id']]['date_evaluation'] = $row['date_evaluation'];
                $returnList[$row['id']]['date_vm'] = $row['date_vm'];
                $returnList[$row['id']]['date_prem_cont'] = $row['date_prem_cont'];
                $returnList[$row['id']]['date_cont_rec'] = $row['date_cont_rec'];
                $returnList[$row['id']]['date_deb'] = $row['date_deb'];
                $returnList[$row['id']]['date_fin'] = $row['date_fin'];
                $returnList[$row['id']]['worker_status'] = $row['worker_status'];
                $returnList[$row['id']]['rem_med'] = $row['rem_med'];
                $returnList[$row['id']]['remarques'] = $row['remarques'];
                $returnList[$row['id']]['old_metier_denomination'] = $row['old_metier_denomination'];
                $returnList[$row['id']]['metier_id'] = $row['metier_id'];
                $returnList[$row['id']]['agence_id'] = $row['agence_id'];
            }
        }
        return $returnList;
    }

    public static function getAllIntActifs()
    {
        $sql='SELECT interimaire.id, interimaire.matricule, interimaire.matricule_cns, interimaire.firstname, interimaire.lastname, interimaire.actif,
              interimaire.taux, interimaire.taux_horaire, interimaire.evaluateur, interimaire.evaluation, evaluation_chantier_id, interimaire.charte_securite,
              interimaire.date_evaluation,interimaire.date_vm, interimaire.date_prem_cont, interimaire.date_cont_rec, interimaire.date_deb, interimaire.date_fin,
              interimaire.worker_status, interimaire.rem_med, interimaire.remarques, metier.nom_metier, agence.nom
              FROM interimaire, metier, agence
              WHERE interimaire.agence_id=agence.id AND interimaire.metier_id=metier.id AND interimaire.actif=1';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allInterimaires = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allInterimaires as $row) {

                $returnList[$row['id']]['matricule'] = $row['matricule'];
                $returnList[$row['id']]['matricule_cns'] = $row['matricule_cns'];
                $returnList[$row['id']]['firstname'] = $row['firstname'];
                $returnList[$row['id']]['lastname'] = $row['lastname'];
                $returnList[$row['id']]['actif'] = $row['actif'];
                $returnList[$row['id']]['taux'] = $row['taux'];
                $returnList[$row['id']]['taux_horaire'] = $row['taux_horaire'];
                $returnList[$row['id']]['evaluateur'] = $row['evaluateur'];
                $returnList[$row['id']]['evaluation'] = $row['evaluation'];
                $returnList[$row['id']]['evaluation_chantier_id'] = $row['evaluation_chantier_id'];
                $returnList[$row['id']]['charte_securite'] = $row['charte_securite'];
                $returnList[$row['id']]['date_evaluation'] = $row['date_evaluation'];
                $returnList[$row['id']]['date_vm'] = $row['date_vm'];
                $returnList[$row['id']]['date_prem_cont'] = $row['date_prem_cont'];
                $returnList[$row['id']]['date_cont_rec'] = $row['date_cont_rec'];
                $returnList[$row['id']]['date_deb'] = $row['date_deb'];
                $returnList[$row['id']]['date_fin'] = $row['date_fin'];
                $returnList[$row['id']]['worker_status'] = $row['worker_status'];
                $returnList[$row['id']]['rem_med'] = $row['rem_med'];
                $returnList[$row['id']]['remarques'] = $row['remarques'];
                $returnList[$row['id']]['old_metier_denomination'] = $row['old_metier_denomination'];
                $returnList[$row['id']]['nom_metier'] = $row['nom_metier'];
                $returnList[$row['id']]['nom_agence'] = $row['nom'];
            }
        }
        return $returnList;
    }

    /**
     * @return array
     * @throws InvalidSqlQueryException
     */
    public static function getAllForSelect()
    {
        $sql = '
            SELECT
                `id`,
                `matricule`,
                `firstname`,
                `lastname`
            FROM `interimaire`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['matricule'].' '.$row['firstname'].' '.$row['lastname'];
            }
        }
        return $returnList;
    }

    public static function getAllForSelectActif()
    {
        $sql = '
            SELECT
                `id`,
                `matricule`,
                `firstname`,
                `lastname`
            FROM `interimaire`
            WHERE `actif` = 1
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['matricule'].' '.$row['firstname'].' '.$row['lastname'];
            }
        }
        return $returnList;
    }

    /**
     * @return bool
     * @throws InvalidSqlQueryException
     */
    public function saveDB()
    {
    //    var_dump($this->agence_id->getId());
    //exit;

        if ($this->id > 0){
            $sql = '
                UPDATE interimaire
                SET
                `matricule` = :matricule,
                `matricule_cns` = :matricule_cns,
                `firstname`= :firstname,
                `lastname`= :lastname,
                `actif`= :actif,
                `taux`= :taux,
                `taux_horaire`= :taux_horaire,
                `evaluateur`= :evaluateur,
                `evaluation`= :evaluation,
                `evaluation_chantier_id`= :evaluation_chantier_id,
                `charte_securite`= :charte_securite,
                `date_evaluation`= :date_evaluation,
                `date_vm`= :date_vm,
                `date_prem_cont`= :date_prem_cont,
                `date_cont_rec`= :date_cont_rec,
                `date_deb`= :date_deb,
                `date_fin`= :date_fin,
                `worker_status`= :worker_status,
                `rem_med`= :rem_med,
                `remarques`= :remarques,
                `old_metier_denomination`= :old_metier_denomination,
                `metier_id`= :metier_id,
                `agence_id`= :agence_id
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':matricule', $this->matricule);
            $stmt->bindValue(':matricule_cns', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':firstname', $this->firstname);
            $stmt->bindValue(':lastname', $this->lastname);
            $stmt->bindValue(':actif', $this->actif);
            $stmt->bindValue(':taux', $this->taux);
            $stmt->bindValue(':taux_horaire', $this->taux_horaire);
            $stmt->bindValue(':evaluateur', $this->evaluateur);
            $stmt->bindValue(':evaluation', $this->evaluation);
            $stmt->bindValue(':evaluation_chantier_id', $this->chantier_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':charte_securite', $this->charte_securite);
            $stmt->bindValue(':date_evaluation', $this->date_evaluation);
            $stmt->bindValue(':date_vm', $this->date_vm);
            $stmt->bindValue(':date_prem_cont', $this->date_prem_cont);
            $stmt->bindValue(':date_cont_rec', $this->date_cont_rec);
            $stmt->bindValue(':date_deb', $this->date_deb);
            $stmt->bindValue(':date_fin', $this->date_fin);
            $stmt->bindValue(':worker_status', $this->worker_status);
            $stmt->bindValue(':rem_med', $this->rem_med);
            $stmt->bindValue(':remarques', $this->remarques);
            $stmt->bindValue(':old_metier_denomination', $this->old_metier_denomination);
            $stmt->bindValue(':metier_id', $this->metier_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':agence_id', $this->agence_id->getId(), \PDO::PARAM_INT);
            // print_r($this->chantier_id->getId());

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }

        }else{
            $sql='
                INSERT INTO `interimaire`(
                `matricule`,
                `matricule_cns`,
                `firstname`,
                `lastname`,
                `actif`,
                `taux`,
                `taux_horaire`,
                `evaluateur`,
                `evaluation`,
                `evaluation_chantier_id`,
                `charte_securite`,
                `date_evaluation`,
                `date_vm`,
                `date_prem_cont`,
                `date_cont_rec`,
                `date_deb`,
                `date_fin`,
                `worker_status`,
                `rem_med`,
                `remarques`,
                `old_metier_denomination`,
                `metier_id`,
                `agence_id`)
                VALUES(
                :matricule,
                :matricule_cns,
                :firstname,
                :lastname,
                :actif,
                :taux,
                :taux_horaire,
                :evaluateur,
                :evaluation,
                :evaluation_chantier_id,
                :charte_securite,
                :date_evaluation,
                :date_vm,
                :date_prem_cont,
                :date_cont_rec,
                :date_deb,
                :date_fin,
                :worker_status,
                :rem_med,
                :remarques,
                :old_metier_denomination,
                :metier_id,
                :agence_id
              )';

            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':matricule', $this->matricule);
            $stmt->bindValue(':matricule_cns', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':firstname', $this->firstname);
            $stmt->bindValue(':lastname', $this->lastname);
            $stmt->bindValue(':actif', $this->actif);
            $stmt->bindValue(':taux', $this->taux);
            $stmt->bindValue(':taux_horaire', $this->taux_horaire);
            $stmt->bindValue(':evaluateur', $this->evaluateur);
            $stmt->bindValue(':evaluation', $this->evaluation);
            $stmt->bindValue(':evaluation_chantier_id', $this->chantier_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':charte_securite', $this->charte_securite);
            $stmt->bindValue(':date_evaluation', $this->date_evaluation);
            $stmt->bindValue(':date_vm', $this->date_vm);
            $stmt->bindValue(':date_prem_cont', $this->date_prem_cont);
            $stmt->bindValue(':date_cont_rec', $this->date_cont_rec);
            $stmt->bindValue(':date_deb', $this->date_deb);
            $stmt->bindValue(':date_fin', $this->date_fin);
            $stmt->bindValue(':worker_status', $this->worker_status);
            $stmt->bindValue(':rem_med', $this->rem_med);
            $stmt->bindValue(':remarques', $this->remarques);
            $stmt->bindValue(':old_metier_denomination', $this->old_metier_denomination);
            $stmt->bindValue(':metier_id', $this->metier_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':agence_id', $this->agence_id->getId(), \PDO::PARAM_INT);

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false;
            }
            else {
                return true;
            }
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws InvalidSqlQueryException
     */
    public static function deleteById($id)
    {
        $sql='DELETE FROM interimaire where id= :id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            return true;
        }
    }

    public static function getInterimaireAffected($woy, $chantier_id){
        $sql='SELECT interimaire_has_chantier.id as int_has_cht_id,
              interimaire_has_chantier.doy,
              interimaire_has_chantier.woy,
              interimaire_has_chantier.chantier_id,
              interimaire_has_chantier.date_debut,
              interimaire_has_chantier.date_fin,
              interimaire_has_chantier.interimaire_id,
              interimaire.matricule,
              interimaire.id,
              interimaire.firstname,
              interimaire.lastname,
              chantier.nom,
              chantier.code
              FROM interimaire_has_chantier, chantier,interimaire
          where woy= :woy
          AND chantier_id= :chantier_id
          AND interimaire.id= interimaire_has_chantier.interimaire_id
          AND chantier.id =interimaire_has_chantier.chantier_id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':woy', $woy, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);

       // print_r($sql);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $allDatas;
        }

    }

    public static function affectationSaved($chantier_id, $week, $listInterimaire, $date_debut){
        foreach($listInterimaire as $isAffected){
            for($i=0; $i<7; $i++){
                $sql= 'INSERT INTO `interimaire_has_chantier`
                    (`interimaire_id`,
                    `chantier_id`,
                    doy,
                    woy,
                    date_debut,
                    date_fin)
                    VALUES(
                    :interimaire_id,
                    :chantier_id,
                    :doy,
                    :woy,
                    :date_debut,
                    :date_fin
                    )';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':interimaire_id', $isAffected, \PDO::PARAM_INT);
                $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
                $stmt->bindValue(':doy', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+$i, date('Y', strtotime($date_debut)))), \PDO::PARAM_INT);
                $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
                $stmt->bindValue(':date_debut', $date_debut, \PDO::PARAM_INT);
                $stmt->bindValue(':date_fin', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+6, date('Y', strtotime($date_debut)))), \PDO::PARAM_INT);
                if ($stmt->execute() === false) {
                    print_r($stmt->errorInfo());
                }
            }
        }
    }

    // Vérification de l'existance des affectationd pour un chantier une semaine et des intérimaires

    public static function checkAffectation($chantier_id, $week, $listInterimaire){
        foreach($listInterimaire as $interimaire_id){
            $sql = 'SELECT * FROM interimaire_has_chantier WHERE
                interimaire_id= :interimaire_id
                AND chantier_id= :chantier_id
                AND woy= :woy';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':interimaire_id', $interimaire_id, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
            $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
            }else{
                return $stmt->rowCount();
            }
        }

    }

    public static function interimaireSelected($int_has_chant_id) {
        $sql='SELECT interimaire_has_chantier.id as int_has_cht_id,
              interimaire_has_chantier.doy,
              interimaire_has_chantier.woy,
              interimaire_has_chantier.chantier_id,
              interimaire_has_chantier.interimaire_id,
              interimaire_has_chantier.date_debut,
              interimaire_has_chantier.date_fin,
              interimaire.matricule,
              interimaire.id,
              interimaire.firstname,
              interimaire.lastname,
              chantier.nom,
              chantier.code
              FROM interimaire_has_chantier, chantier,interimaire
          where interimaire_has_chantier.id= :id
            AND chantier.id=interimaire_has_chantier.chantier_id
            AND interimaire.id = interimaire_has_chantier.interimaire_id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $int_has_chant_id, \PDO::PARAM_INT);


        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $interimaireSelected = $stmt->fetch();
            return $interimaireSelected;
        }
    }
    /**fetchAll(\PDO::FETCH_ASSOC);*/

    public static function changeChantierAffectation($day, $id, $chantier_id){

        /*$sql = 'SELECT * FROM interimaire_has_chantier WHERE doy BETWEEN (date_debut and date_fin) AND woy = :woy ';*/
        $sql = 'UPDATE interimaire_has_chantier SET doy = :doy AND chantier_id= :chantier_id WHERE id = :id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
    }

    public static function checkChantierAndDoyAffectation($day, $interimaire_id, $chantier_id){
        $sql='SELECT * FROM interimaire_has_chantier WHERE chantier_id= :chantier_id AND doy= :doy AND interimaire_id = :interimaire_id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);
        $stmt->bindValue(':id', $interimaire_id, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            $row = $stmt->rowCount();
        }
        return $row;
    }

    public static function compareDateForChangeAffectation($day){
        $sql = 'SELECT * FROM interimaire_has_chantier WHERE doy= :doy AND :doy BETWEEN date_debut AND date_fin';

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            $row = $stmt->rowCount();
        }
        return $row;
    }

    public static function duplicateAffectation(){

    }

}