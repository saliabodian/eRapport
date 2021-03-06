<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 05/09/2017
 * Time: 08:23
 */

namespace Classes\Cdcl\Db;

use \Datetime;

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
    /**
     * @var Qualification
     */
    public $qualif_id;
    /**
     * @var Departement
     */
    public $dpt_id;
    /**
     * @var User
     */
    public $user_id;

    function __construct($id=0, $matricule='', $matricule_cns=0, $firstname='', $lastname='', $actif=0, $taux=0, $taux_horaire=0, $evaluation=null, $evaluateur=null, $chantier_id=null, $charte_securite=0, $date_evaluation=0, $date_vm=0, $date_prem_cont=0, $date_cont_rec=0, $date_deb=0, $date_fin=0, $worker_status=0, $rem_med='', $remarques='', $old_metier_denomination='', $metier_id=null, $agence_id=null, $qualif_id=null, $dpt_id=null, $user_id=null, $created=0)
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
        $this->qualif_id = isset($qualif_id) ? $qualif_id : new Qualification();
        $this->dpt_id = isset($dpt_id) ? $dpt_id : new Departement();
        $this->user_id = isset($user_id) ? $user_id : new User();
        parent::__construct($id, $created);
    }

    /**
     * @return Qualification
     */
    public function getQualifId()
    {
        return $this->qualif_id;
    }

    /**
     * @return Departement
     */
    public function getDptId()
    {
        return $this->dpt_id;
    }

    /**
     * @return User
     */
    public function getUserId()
    {
        return $this->user_id;
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
                `agence_id`,
                `qualif_id`,
                `dpt_id`,
                `user_id`,
                `created`
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
                new Qualification($data['qualif_id']),
                new Departement($data['dpt_id']),
                new User($data['user_id']),
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
        $sql='SELECT * FROM interimaire ORDER BY lastname';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allInterimaires = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allInterimaires as $row) {
                $returnList[$row['id']]['id'] = $row['id'];
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
                $returnList[$row['id']]['qualif_id'] = $row['qualif_id'];
                $returnList[$row['id']]['dpt_id'] = $row['dpt_id'];
                $returnList[$row['id']]['user_id'] = $row['user_id'];
                $returnList[$row['id']]['created'] = $row['created'];
            }
        }
        return $returnList;
    }

    public static function getAllIntActifs()
    {
        $sql='SELECT interimaire.id,
                    interimaire.matricule,
                    interimaire.matricule_cns,
                    interimaire.firstname,
                    interimaire.lastname,
                    interimaire.actif,
                    interimaire.taux,
                    interimaire.taux_horaire,
                    interimaire.evaluateur,
                    interimaire.evaluation,
                    interimaire.evaluation_chantier_id,
                    interimaire.charte_securite,
                    interimaire.date_evaluation,
                    interimaire.date_vm,
                    interimaire.date_prem_cont,
                    interimaire.date_cont_rec,
                    interimaire.date_deb,
                    interimaire.date_fin,
                    interimaire.worker_status,
                    interimaire.rem_med,
                    interimaire.remarques,
                    metier.nom_metier,
                    agence.nom
              FROM interimaire
                LEFT OUTER JOIN
                    `metier` ON `interimaire`.`metier_id` = `metier`.`id`
                LEFT OUTER JOIN
                    `agence` ON `interimaire`.`agence_id` = `agence`.`id`
                LEFT OUTER JOIN
                    `qualification` ON `interimaire`.`qualif_id` = `qualification`.`id`
                LEFT OUTER JOIN
                    `departement` ON `interimaire`.`dpt_id` = `departement`.`id`
                LEFT OUTER JOIN
                    `user` ON `interimaire`.`user_id` = `user`.`id`
                WHERE interimaire.actif=1
                 ORDER BY interimaire.lastname';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allInterimaires = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allInterimaires as $row) {
                $returnList[$row['id']]['id'] = $row['id'];
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
                `interimaire`.`id`,
                `interimaire`.`matricule`,
                `interimaire`.`firstname`,
                `interimaire`.`lastname`
            FROM `interimaire`
              LEFT OUTER JOIN
                 `metier` ON `interimaire`.`metier_id` = `metier`.`id`
              LEFT OUTER JOIN
                 `agence` ON `interimaire`.`agence_id` = `agence`.`id`
              LEFT OUTER JOIN
                 `qualification` ON `interimaire`.`qualif_id` = `qualification`.`id`
              LEFT OUTER JOIN
                  `departement` ON `interimaire`.`dpt_id` = `departement`.`id`
              LEFT OUTER JOIN
                 `user` ON `interimaire`.`user_id` = `user`.`id`
              ORDER BY `interimaire`.`lastname`';
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

    public static function getAllForSelectFilter($search)
    {
        $sql = '
            SELECT
                `interimaire`.`id`,
                `interimaire`.`matricule`,
                `interimaire`.`firstname`,
                `interimaire`.`lastname`,
                `metier`.`nom_metier`,
                `agence`.`nom`,
                `qualification`.`nom_qualif`,
                `departement`.`nom_dpt`,
                `user`.`username`,
                `chantier`.`nom`
            FROM `interimaire`
              LEFT OUTER JOIN
                 `metier` ON `interimaire`.`metier_id` = `metier`.`id`
              LEFT OUTER JOIN
                 `agence` ON `interimaire`.`agence_id` = `agence`.`id`
              LEFT OUTER JOIN
                 `qualification` ON `interimaire`.`qualif_id` = `qualification`.`id`
              LEFT OUTER JOIN
                  `departement` ON `interimaire`.`dpt_id` = `departement`.`id`
              LEFT OUTER JOIN
                 `user` ON `interimaire`.`user_id` = `user`.`id`
             LEFT OUTER JOIN
                 `chantier` ON `interimaire`.`evaluation_chantier_id` = `chantier`.`id`
            WHERE `interimaire`.`matricule` LIKE :search
			OR `interimaire`.`firstname` LIKE :search
			OR `interimaire`.`lastname` LIKE :search
			OR `metier`.`nom_metier` LIKE :search
			OR `agence`.`nom` LIKE :search
			OR `qualification`.`nom_qualif` LIKE :search
			OR `departement`.`nom_dpt` LIKE :search
			OR `chantier`.`nom` LIKE :search
			OR `user`.`username` LIKE :search
			ORDER BY `interimaire`.`lastname`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':search', '%'.$search.'%', \PDO::PARAM_STR);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['matricule'].' '.$row['firstname'].' '.$row['lastname'];
            }
        }
        $returnList = isset($returnList)? $returnList : '';
        return $returnList;
    }

    public static function getAllForSelectActif()
    {
        $sql = '
            SELECT
                `interimaire`.`id`,
                `interimaire`.`matricule`,
                `interimaire`.`firstname`,
                `interimaire`.`lastname`
            FROM `interimaire`
              LEFT OUTER JOIN
                 `metier` ON `interimaire`.`metier_id` = `metier`.`id`
              LEFT OUTER JOIN
                 `agence` ON `interimaire`.`agence_id` = `agence`.`id`
              LEFT OUTER JOIN
                 `qualification` ON `interimaire`.`qualif_id` = `qualification`.`id`
              LEFT OUTER JOIN
                  `departement` ON `interimaire`.`dpt_id` = `departement`.`id`
              LEFT OUTER JOIN
                  `user` ON `interimaire`.`user_id` = `user`.`id`
            WHERE `interimaire`.`actif` = 1
            ORDER BY `interimaire`.`lastname`

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
                `agence_id`= :agence_id,
                `qualif_id`= :qualif_id,
                `dpt_id`= :dpt_id,
                `user_id`= :user_id

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
            $stmt->bindValue(':qualif_id', $this->qualif_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':dpt_id', $this->dpt_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $this->user_id->getId(), \PDO::PARAM_INT);
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
                `agence_id`,
                `qualif_id`,
                `dpt_id`,
                `user_id`
                )
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
                :agence_id,
                :qualif_id,
                :dpt_id,
                :user_id
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
            $stmt->bindValue(':worker_status', 'INTERIMAIRE');
            $stmt->bindValue(':rem_med', $this->rem_med);
            $stmt->bindValue(':remarques', $this->remarques);
            $stmt->bindValue(':old_metier_denomination', $this->old_metier_denomination);
            $stmt->bindValue(':metier_id', $this->metier_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':agence_id', $this->agence_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':qualif_id', $this->qualif_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':dpt_id', $this->dpt_id->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $this->user_id->getId(), \PDO::PARAM_INT);

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
              chantier.code,
              interimaire_has_chantier.woy as weekly_search
              FROM interimaire_has_chantier, chantier,interimaire
          where woy= :woy
          AND interimaire_has_chantier.chantier_id= :chantier_id
          AND interimaire.id= interimaire_has_chantier.interimaire_id
          AND chantier.id =interimaire_has_chantier.chantier_id
          AND interimaire.actif = 1
          ORDER BY `interimaire`.`lastname`, interimaire_has_chantier.date_debut, interimaire_has_chantier.doy, interimaire_has_chantier.woy, interimaire_has_chantier.woy';
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

    public static function getInterimaireAffectedDay($doy, $chantier_id){
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
              chantier.code,
              interimaire_has_chantier.doy as dayly_search
              FROM interimaire_has_chantier, chantier,interimaire
          where doy= :doy
          AND interimaire_has_chantier.chantier_id= :chantier_id
          AND interimaire.id= interimaire_has_chantier.interimaire_id
          AND chantier.id =interimaire_has_chantier.chantier_id
          AND interimaire.actif = 1
          ORDER BY `interimaire`.`lastname`, interimaire_has_chantier.date_debut, interimaire_has_chantier.doy, interimaire_has_chantier.woy, interimaire_has_chantier.woy';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $doy, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);

        // print_r($sql);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            //var_dump($allDatas);
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
                $stmt->bindValue(':doy', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+$i, date('Y', strtotime($date_debut)))));
                $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
                $stmt->bindValue(':date_debut', $date_debut);
                $stmt->bindValue(':date_fin', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+6, date('Y', strtotime($date_debut)))));
                if ($stmt->execute() === false) {
                    print_r($stmt->errorInfo());
                }
            }
        }
    }

/*    public static function affectationInterimaireSaved($chantier_id, $week, $isAffected, $date_debut){
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
            $stmt->bindValue(':doy', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+$i, date('Y', strtotime($date_debut)))));
            $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
            $stmt->bindValue(':date_debut', $date_debut);
            $stmt->bindValue(':date_fin', date('Y-m-d', mktime(0,0,0, date('m', strtotime($date_debut)), date('d', strtotime($date_debut))+6, date('Y', strtotime($date_debut)))));
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
            }
        }
    }*/

    public static function affectationInterimaireSaved($chantier_id, $week, $isAffected, $date_debut){
        $day = intval($date_debut->format('N'));
        $rel = 7 - $day;
        $date_fin = new DateTime($date_debut->format('Y-m-d').' +'.$rel .'day');
        for($i=0; $i<=$rel ; $i++){
            $doy = new DateTime($date_debut->format('Y-m-d').' +'.$i .'day');
            $year = $doy->format('Y');
            $sql= 'INSERT INTO `interimaire_has_chantier`
                (`interimaire_id`,
                `chantier_id`,
                `doy`,
                `woy`,
                `year`,
                `date_debut`,
                `date_fin`)
                VALUES(
                :interimaire_id,
                :chantier_id,
                :doy,
                :woy,
                :year,
                :date_debut,
                :date_fin
                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':interimaire_id', $isAffected, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
            $stmt->bindValue(':doy', $doy->format('Y-m-d'));
            $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
            $stmt->bindValue(':year', $year, \PDO::PARAM_INT);
            $stmt->bindValue(':date_debut', $date_debut->format('Y-m-d'));
            $stmt->bindValue(':date_fin', $date_fin->format('Y-m-d'));
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
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
    /*
    public static function checkInterimaireAffectation($chantier_id, $week, $interimaire_id){
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
    } */

    public static function checkInterimaireAffectation($chantier_id, $week, $year, $interimaire_id){
        $sql = 'SELECT * FROM interimaire_has_chantier WHERE
            interimaire_id= :interimaire_id
            AND chantier_id= :chantier_id
            AND woy= :woy
            AND year=:year
            AND ismobile = 0'
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':interimaire_id', $interimaire_id, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
        $stmt->bindValue(':year', $year, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            return $stmt->rowCount();
        }
    }

    public static function checkInterimaireAffectationTemporaire($chantier_id, $week, $year, $interimaire_id){
        $sql = 'SELECT * FROM interimaire_has_chantier WHERE
            interimaire_id= :interimaire_id
            AND chantier_id= :chantier_id
            AND woy= :woy
            AND year=:year
            AND ismobile = 1'
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':interimaire_id', $interimaire_id, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
        $stmt->bindValue(':year', $year, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            return $stmt->rowCount();
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

    public static function changeChantierAffectation($day, $chantier_id, $chef_dequipe_id, $id){

        $sql = 'UPDATE interimaire_has_chantier SET doy = :doy , chantier_id=:chantier_id, chef_dequipe_id=:chef_dequipe_id WHERE id = :id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);
        $stmt->bindValue(':chef_dequipe_id', $chef_dequipe_id, \PDO::PARAM_INT);
    //    $stmt->bindValue(':doy', date('Y-m-d', mktime(0,0,0, date('m', strtotime($day)), date('d', strtotime($day)), date('Y', strtotime($day)))), \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        // var_dump($stmt->debugDumpParams());

        // exit;

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
            return false;
        }else{
            return true;
        }
    }

    public static function checkChantierAndDoyAffectation($day, $interimaire_id, $chantier_id, $chef_dequipe_id){
        $sql='SELECT * FROM interimaire_has_chantier, user, interimaire WHERE chantier_id= :chantier_id AND doy= :doy AND interimaire_id = :interimaire_id
              AND interimaire.id =:interimaire_id AND interimaire.user_id = user.id AND (interimaire_has_chantier.chefe_dequipe_id=:chef_dequipe_id OR interimaire.user_id=:chef_dequipe_id)';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);
        $stmt->bindValue(':interimaire_id', $interimaire_id, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        $stmt->bindValue(':chef_dequipe_id', $chef_dequipe_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            $row = $stmt->rowCount();
        }
        return $row;
    }

    public static function compareDateForChangeAffectation($day, $date_debut, $date_fin){
        $sql = "
                SELECT * FROM interimaire_has_chantier
                WHERE doy=:doy AND :doy
                BETWEEN :date_debut AND :date_fin
                ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':doy', $day, \PDO::PARAM_INT);
        $stmt->bindValue(':date_debut', $date_debut, \PDO::PARAM_INT);
        $stmt->bindValue(':date_fin', $date_fin, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            $row = $stmt->rowCount();
        }
        return $row;
    }

    public static function getLastMatricule($agence_id){
        $sql='select matricule
                from interimaire
                WHERE agence_id= :agence_id
              AND matricule >=10000 order by matricule desc limit 1';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':agence_id', $agence_id, \PDO::PARAM_INT);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $matricule =  $stmt->fetch();
        }
        return $newMatricule = $matricule['matricule'];
    }

    public static function getLastId($agence_id, $matricule){
        $sql='select id
                from interimaire
                WHERE agence_id= :agence_id AND matricule = :matricule
              AND matricule >=10000 order by matricule desc limit 1';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':agence_id', $agence_id, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $id =  $stmt->fetch();
        }
        return $lastId = $id['id'];
    }
    public static function duplicateAffectation($weekToDuplicate, $weekToAffect){
        /* Récupération des éléments de la semaine que l'on veut dupliquer*/
        $sql = 'SELECT * FROM interimaire_has_chantier WHERE woy= :week AND interimaire_id IN (SELECT id FROM interimaire WHERE actif = 1)';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':week', $weekToDuplicate, \PDO::PARAM_INT);
        if($stmt->execute()=== false){
            print_r($stmt->errorInfo());
        }else{
            $affectationEnCours = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        //var_dump($affectationEnCours);
        // Calcul du nombre de jour à ajouter pour avoir les bonnes dates,
        // ce nombre de jours nous permet d'avoir un pas et donc de faire une duplication entre des semaines n'étant pas juxtaposées
        // exple duplicatat de ls semaine 38 pour semaine 46

        $d= ($weekToAffect - $weekToDuplicate)*7;

        // Vérification de l'existance d'affectation pour la nouvelle semaine d'affectation pour éviter les doublons

        for($i=0; $i<sizeof($affectationEnCours); $i++) {
        //    var_dump($affectationEnCours[$i]['interimaire_id']);
        //    var_dump($weekToAffect);

            $sql = 'SELECT interimaire_id as int_id FROM interimaire_has_chantier WHERE interimaire_id= :interimaire_id AND woy= :weekToAffect AND interimaire_id IN (SELECT id FROM interimaire WHERE actif = 1)';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':weekToAffect', $weekToAffect, \PDO::PARAM_INT);
            $stmt->bindValue(':interimaire_id', $affectationEnCours[$i]['interimaire_id'], \PDO::PARAM_INT);
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
            } else {
                $int_id[$i]=$stmt->fetch();
                $row[$i] = $stmt->rowCount();
            }
        }

    //    var_dump($row);
    //    var_dump($int_id);



       for($i=0; $i<sizeof($affectationEnCours); $i++){
           // Insertion en base de données pour les intérimaires n'étant pas encore affectés pour la semaine choisie
            if($row[$i]<1){
                $sql='INSERT INTO interimaire_has_chantier (interimaire_id,
                  chantier_id,
                  doy,
                  woy,
                  date_debut,
                  date_fin)
                  VALUES
                  (:interimaire_id,
                  :chantier_id,
                  :doy,
                  :woy,
                  :date_debut,
                  :date_fin)';
                $stmt=Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':interimaire_id',$affectationEnCours[$i]['interimaire_id'], \PDO::PARAM_INT);
                $stmt->bindValue(':chantier_id',$affectationEnCours[$i]['chantier_id'], \PDO::PARAM_INT);
                $stmt->bindValue(':doy', date('Y-m-d', mktime(0,0,0, date('m', strtotime($affectationEnCours[$i]['doy'])), date('d', strtotime($affectationEnCours[$i]['doy']))+$d, date('Y', strtotime($affectationEnCours[$i]['doy'])))));
                $stmt->bindValue(':woy',$weekToAffect, \PDO::PARAM_INT);
                $stmt->bindValue(':date_debut', date('Y-m-d', mktime(0,0,0, date('m', strtotime($affectationEnCours[$i]['date_debut'])), date('d', strtotime($affectationEnCours[$i]['date_debut']))+$d, date('Y', strtotime($affectationEnCours[$i]['date_debut'])))));
                $stmt->bindValue(':date_fin', date('Y-m-d', mktime(0,0,0, date('m', strtotime($affectationEnCours[$i]['date_fin'])), date('d', strtotime($affectationEnCours[$i]['date_fin']))+$d, date('Y', strtotime($affectationEnCours[$i]['date_fin'])))));
                if($stmt->execute()===false){
                    print_r($stmt->errorInfo());
                }
            }
        }
    }
    // Modification des champs de date de début de mission et date de fin de mission après ré-affectation.
    // Cette fonction ne devrait fonctionner au cas ou la réaffectation se fait pour la semaine courrante.

    public static function updateDateDebutDateFinInterimaire($week){

        $sql = 'SElECT date_debut, date_fin FROM interimaire_has_chantier WHERE woy=:woy AND interimaire_id IN (SELECT id FROM interimaire WHERE actif = 1) limit 1';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $dates = $stmt->fetch();
        }

        $sql = 'SElECT DISTINCT interimaire_id FROM interimaire_has_chantier WHERE woy=:woy AND interimaire_id IN (SELECT id FROM interimaire WHERE actif = 1)';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':woy', $week, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $interimaireToUpdate = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        for($i=0; $i<sizeof($interimaireToUpdate); $i++){
            $sql = 'UPDATE interimaire SET date_deb=:date_deb, date_fin=:date_fin WHERE id=:id';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date_deb', $dates['date_debut']);
            $stmt->bindValue(':date_fin', $dates['date_fin']);
            $stmt->bindValue(':id', $interimaireToUpdate[$i]['interimaire_id']);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }
    }

    public static function deleteInterimaireAffectation($intHasChtId){
        $sql = 'DELETE FROM interimaire_has_chantier WHERE id=:intHasChtId';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':intHasChtId', $intHasChtId, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return true;
        }
    }


    public static function getOuvrier($chantierId){
        $sql = 'SELECT distinct fullname, ouvrier_id, interimaire_id
                FROM rapport_detail, rapport, chantier
                WHERE rapport_detail.rapport_id = rapport.id
                AND rapport.chantier = :chantierId
                ORDER BY interimaire_id, ouvrier_id ASC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantierId', $chantierId, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return $listOuvrier = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }


    public static function getOuvrierTache($fullname){
        $sql = 'SELECT DISTINCT
                    tache.id, tache.code, tache.nom
                FROM
                    rapport,
                    rapport_detail,
                    rapport_detail_has_tache,
                    tache
                WHERE
                    rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND (ouvrier_id like :fullname OR interimaire_id like :fullname)
                    AND rapport_detail.rapport_id = rapport.id
                    AND rapport_detail_has_tache.tache_id = tache.id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':fullname', $fullname, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return $listOuvrierTache = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    /*Affectation des Intérimaires pour la semaine courante nouvelle version*/

    public static function affectationInterimaire($dateCourante){
        $interimaireList = Interimaire::getAllIntActifs();
    //    $dateCourante = new DateTime();
        $dateCourante = new DateTime($dateCourante);
        $numeroJour = intval($dateCourante->format('N'));
        $ecartVersPremierJour = $numeroJour -1;

        $premierJourDeLaSemaine = new DateTime($dateCourante->format('Y-m-d').'-'.$ecartVersPremierJour.' days');
        $dernierJourDeLaSemaine = new DateTime($premierJourDeLaSemaine->format('Y-m-d').'+6 days');
        $numeroSemaineCourrante = intval($premierJourDeLaSemaine->format('W'));
        $anneeSemaineCourrante = intval($premierJourDeLaSemaine->format('Y'));
    //    $premierJourDeLaSemaineProchaine = new DateTime($premierJourDeLaSemaine->format('Y-m-d').'+7 days');
    //    $dernierJourDeLaSemaineProchaine = new DateTime($dernierJourDeLaSemaine->format('Y-m-d').'+7 days');
    //    $numeroSemaineProchaine = intval($premierJourDeLaSemaineProchaine->format('W'));
    //    $anneeSemaineProchaine = intval($premierJourDeLaSemaineProchaine->format('Y'));
    //    var_dump($premierJourDeLaSemaine);
    //    var_dump($dernierJourDeLaSemaine);
    //    var_dump($numeroSemaineCourrante);
    //    var_dump($anneeSemaineCourrante);
    //    var_dump($premierJourDeLaSemaineProchaine);
    //    var_dump($dernierJourDeLaSemaineProchaine);
    //    var_dump($numeroSemaineProchaine);
    //    var_dump($anneeSemaineProchaine);
        $premierJourDeLaSemaine = $premierJourDeLaSemaine->format('Y-m-d');
        $dernierJourDeLaSemaine = $dernierJourDeLaSemaine->format('Y-m-d');
    //    $premierJourDeLaSemaineProchaine = $premierJourDeLaSemaineProchaine->format('Y-m-d');
    //    $dernierJourDeLaSemaineProchaine = $dernierJourDeLaSemaineProchaine->format('Y-m-d');

        foreach($interimaireList as $interimaire){
            $id=$interimaire['id'];
            // Je me suis rendu compte qu'il y a des intérimaires actifs avec la colonne chantier_id vide :-( donc si c'est le cas je mets l'id 21 du ferrallaige
            $chantier_id = isset($interimaire['evaluation_chantier_id']) ? $interimaire['evaluation_chantier_id']: 21;
            $sql = " UPDATE interimaire SET date_deb=:date_debut, date_fin=:date_fin WHERE id=:id";
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date_debut', $premierJourDeLaSemaine);
            $stmt->bindValue(':date_fin', $dernierJourDeLaSemaine);
            $stmt->bindValue(':id', $id);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }

            $affectationExist = Interimaire::checkInterimaireAffectation($chantier_id, $numeroSemaineCourrante, $anneeSemaineCourrante, $id);

            if($affectationExist <1 ){
                for($i=0; $i<7; $i++){
                    if($i===0){
                        $doy =  new DateTime($premierJourDeLaSemaine) ;
                        $doy = $doy->format('Y-m-d');

                    }else{
                        $doy = new DateTime($premierJourDeLaSemaine.'+'.$i.' day') ;
                        $doy = $doy->format('Y-m-d');
                    }

                //    var_dump($doy);
                //    var_dump($numeroSemaineCourrante);
                //    var_dump($anneeSemaineCourrante);



                    $sql='INSERT INTO interimaire_has_chantier (interimaire_id,
                          chantier_id,
                          doy,
                          woy,
                          year,
                          date_debut,
                          date_fin)
                          VALUES
                          (:interimaire_id,
                          :chantier_id,
                          :doy,
                          :woy,
                          :year,
                          :date_debut,
                          :date_fin)';
                    $stmt = Config::getInstance()->getPDO()->prepare($sql);
                    $stmt->bindValue(':interimaire_id', $id);
                    $stmt->bindValue(':chantier_id', $chantier_id);
                    $stmt->bindValue(':doy', $doy);
                    $stmt->bindValue(':woy', $numeroSemaineCourrante);
                    $stmt->bindValue(':year', $anneeSemaineCourrante);
                    $stmt->bindValue(':date_debut', $premierJourDeLaSemaine);
                    $stmt->bindValue(':date_fin', $dernierJourDeLaSemaine);
                    if($stmt->execute()===false){
                        print_r($stmt->errorInfo());
                    }
                }
            }
        }

    }

    /*Affectation des Intérimaires pour la gestion de la mobilité*/

    public static function affectationInterimaireMobilite($dateDebut, $dateFin, $daysNumber, $chantier_id, $interimnaire_id){
        $dateDebut = $dateDebut->format('Y-m-d');
        $dateFin = $dateFin->format('Y-m-d');

        for($i=0; $i<=$daysNumber; $i++){
                    if($i===0){
                        $doy =  new DateTime($dateDebut) ;
                        $week =  intval($doy->format('W')) ;
                        $year =  intval($doy->format('Y')) ;
                        $doy = $doy->format('Y-m-d');

                    }else{
                        $doy = new DateTime($dateDebut.'+'.$i.' day') ;
                        $week =  intval($doy->format('W')) ;
                        $year =  intval($doy->format('Y')) ;
                        $doy = $doy->format('Y-m-d');
                    }


                    $sql='INSERT INTO interimaire_has_chantier (interimaire_id,
                          chantier_id,
                          doy,
                          woy,
                          year,
                          date_debut,
                          date_fin,
                          ismobile)
                          VALUES
                          (:interimaire_id,
                          :chantier_id,
                          :doy,
                          :woy,
                          :year,
                          :date_debut,
                          :date_fin,
                          :ismobile)';
                    $stmt = Config::getInstance()->getPDO()->prepare($sql);
                    $stmt->bindValue(':interimaire_id', $interimnaire_id);
                    $stmt->bindValue(':chantier_id', $chantier_id);
                    $stmt->bindValue(':doy', $doy);
                    $stmt->bindValue(':woy', $week);
                    $stmt->bindValue(':year', $year);
                    $stmt->bindValue(':date_debut', $dateDebut);
                    $stmt->bindValue(':date_fin', $dateFin);
                    $stmt->bindValue(':ismobile', 1);
                    if($stmt->execute()===false){
                        print_r($stmt->errorInfo());
                    }
                }
    }

    //**Affectation pour la semaine suivante**/

    public static function affectationInterimaireNextWeek(){
        $interimaireList = Interimaire::getAllIntActifs();
        $dateCourante = new DateTime();
        $numeroJour = intval($dateCourante->format('N'));
        $ecartVersPremierJour = $numeroJour -1;

        $premierJourDeLaSemaine = new DateTime($dateCourante->format('Y-m-d').'-'.$ecartVersPremierJour.' days');
        $dernierJourDeLaSemaine = new DateTime($premierJourDeLaSemaine->format('Y-m-d').'+6 days');
        //$numeroSemaineCourrante = intval($premierJourDeLaSemaine->format('W'));
        //$anneeSemaineCourrante = intval($premierJourDeLaSemaine->format('Y'));
        $premierJourDeLaSemaineProchaine = new DateTime($premierJourDeLaSemaine->format('Y-m-d').'+7 days');
        $dernierJourDeLaSemaineProchaine = new DateTime($dernierJourDeLaSemaine->format('Y-m-d').'+7 days');
        $numeroSemaineProchaine = intval($premierJourDeLaSemaineProchaine->format('W'));
        $anneeSemaineProchaine = intval($premierJourDeLaSemaineProchaine->format('Y'));
        //    var_dump($premierJourDeLaSemaine);
        //    var_dump($dernierJourDeLaSemaine);
        //    var_dump($numeroSemaineCourrante);
        //    var_dump($anneeSemaineCourrante);
        //    var_dump($premierJourDeLaSemaineProchaine);
        //    var_dump($dernierJourDeLaSemaineProchaine);
        //    var_dump($numeroSemaineProchaine);
        //    var_dump($anneeSemaineProchaine);
        //$premierJourDeLaSemaine = $premierJourDeLaSemaine->format('Y-m-d');
        //$dernierJourDeLaSemaine = $dernierJourDeLaSemaine->format('Y-m-d');
        $premierJourDeLaSemaineProchaine = $premierJourDeLaSemaineProchaine->format('Y-m-d');
        $dernierJourDeLaSemaineProchaine = $dernierJourDeLaSemaineProchaine->format('Y-m-d');

        foreach($interimaireList as $interimaire){
            $id=$interimaire['id'];
            // Je me suis rendu compte qu'il y a des intérimaires actifs avec la colonne chantier_id vide :-( donc si c'est le cas je mets l'id 21 du ferrallaige
            $chantier_id = isset($interimaire['evaluation_chantier_id']) ? $interimaire['evaluation_chantier_id']: 21;
            $sql = " UPDATE interimaire SET date_deb=:date_debut, date_fin=:date_fin WHERE id=:id";
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date_debut', $premierJourDeLaSemaineProchaine);
            $stmt->bindValue(':date_fin', $dernierJourDeLaSemaineProchaine);
            $stmt->bindValue(':id', $id);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }

            $affectationExist = Interimaire::checkInterimaireAffectation($chantier_id, $numeroSemaineProchaine, $anneeSemaineProchaine, $id);

            if($affectationExist <1 ){
                for($i=0; $i<7; $i++){
                    if($i===0){
                        $doy =  new DateTime($premierJourDeLaSemaineProchaine) ;
                        $doy = $doy->format('Y-m-d');

                    }else{
                        $doy = new DateTime($premierJourDeLaSemaineProchaine.'+'.$i.' day') ;
                        $doy = $doy->format('Y-m-d');
                    }

                    //    var_dump($doy);
                    //    var_dump($numeroSemaineCourrante);
                    //    var_dump($anneeSemaineCourrante);



                    $sql='INSERT INTO interimaire_has_chantier (interimaire_id,
                          chantier_id,
                          doy,
                          woy,
                          year,
                          date_debut,
                          date_fin)
                          VALUES
                          (:interimaire_id,
                          :chantier_id,
                          :doy,
                          :woy,
                          :year,
                          :date_debut,
                          :date_fin)';
                    $stmt = Config::getInstance()->getPDO()->prepare($sql);
                    $stmt->bindValue(':interimaire_id', $id);
                    $stmt->bindValue(':chantier_id', $chantier_id);
                    $stmt->bindValue(':doy', $doy);
                    $stmt->bindValue(':woy', $numeroSemaineProchaine);
                    $stmt->bindValue(':year', $anneeSemaineProchaine);
                    $stmt->bindValue(':date_debut', $premierJourDeLaSemaineProchaine);
                    $stmt->bindValue(':date_fin', $dernierJourDeLaSemaineProchaine);
                    if($stmt->execute()===false){
                        print_r($stmt->errorInfo());
                    }
                }
            }
        }

    }

    public static function majScript (){
        $sql = "SELECT * FROM interimaire_has_chantier  where 1=1";
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return $allRows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public static function updateDates(){
        $interimaires = Interimaire::getAll();

        foreach($interimaires as $interimaire){
            if($interimaire['date_deb']=='0000-00-00'){
                /*
                var_dump($interimaire['id']);
                var_dump($interimaire['date_prem_cont']);
                var_dump($interimaire['date_deb']);
                var_dump($interimaire['date_fin']);
                */
                $date= new DateTime($interimaire['date_prem_cont']);
                $date= $date->format('Y-m-d');
                $date_fin = new DateTime($date.'+6 days');
                $date_fin = $date_fin->format('Y-m-d');

                /*
                var_dump($date);
                var_dump($date_fin);
                */

                $sql = "UPDATE interimaire SET date_evaluation =:date_evaluation,
                        date_cont_rec=:date_cont_rec,
                        date_deb=:date_deb,
                        date_fin =:date_fin,
                        date_vm =:date_vm
                        WHERE id=:id
                        AND id BETWEEN 1 AND 500";
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':date_evaluation', $date);
                $stmt->bindValue(':date_fin', $date_fin);
                $stmt->bindValue(':date_deb', $date);
                $stmt->bindValue(':date_cont_rec', $date);
                $stmt->bindValue(':date_vm', $date);
                $stmt->bindValue(':id', $interimaire['id']);
                if($stmt->execute()===false){
                    print_r($stmt->errorInfo());
                }

                $sql = "UPDATE interimaire SET date_evaluation =:date_evaluation,
                        date_cont_rec=:date_cont_rec,
                        date_deb=:date_deb,
                        date_fin =:date_fin,
                        date_vm =:date_vm
                        WHERE id=:id
                        AND id BETWEEN 501 AND 1000";
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':date_evaluation', $date);
                $stmt->bindValue(':date_fin', $date_fin);
                $stmt->bindValue(':date_deb', $date);
                $stmt->bindValue(':date_cont_rec', $date);
                $stmt->bindValue(':date_vm', $date);
                $stmt->bindValue(':id', $interimaire['id']);
                if($stmt->execute()===false){
                    print_r($stmt->errorInfo());
                }

                $sql = "UPDATE interimaire SET date_evaluation =:date_evaluation,
                        date_cont_rec=:date_cont_rec,
                        date_deb=:date_deb,
                        date_fin =:date_fin,
                        date_vm =:date_vm
                        WHERE id=:id
                        AND id BETWEEN 1001 AND 1500";
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':date_evaluation', $date);
                $stmt->bindValue(':date_fin', $date_fin);
                $stmt->bindValue(':date_deb', $date);
                $stmt->bindValue(':date_cont_rec', $date);
                $stmt->bindValue(':date_vm', $date);
                $stmt->bindValue(':id', $interimaire['id']);
                if($stmt->execute()===false){
                    print_r($stmt->errorInfo());
                }
            }
        }
    }

    public static function testDateTime($date_debut, $date_fin){
        $sql = 'UPDATE interimaire_has_chantier SET date_debut=:date_debut, date_fin=:date_fin  WHERE interimaire_id=43';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue('date_debut', $date_debut);
        $stmt->bindValue('date_fin', $date_fin);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return 'OK';
        }
    }

    public static function interimaireDesactivation($interimaireId){

        $sql = 'UPDATE interimaire set actif = 0 WHERE id=:interimaire_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':interimaire_id', $interimaireId);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }
}