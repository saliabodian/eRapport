<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 10:57
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

/**
 * Class Rapport
 * @package Classes\Cdcl\Db
 */
class Rapport extends DbObject{

    /*----------------Properties------------------*/

    /**
     * @var int
     */
    public $date;
    /**
     * @var int
     */
    public $terminal;
    /**
     * @var chantier
     */
    public $chantier;
    /**
     * @var user
     */
    public $equipe;
    /**
     * @var int
     */
    public $chefDEquipeMatricule;
    /**
     * @var string
     */
    public $rapportType;
    /**
     * @var int
     */
    public $generatedBy;
    /**
     * @var bool
     */
    public $preremp;
    /**
     * @var bool
     */
    public $submitted;
    /**
     * @var bool
     */
    public $validated;
    /**
     * @var bool
     */
    public $deleted;

    function __construct($id=0, $date=0, $terminal=0, $chantier=null, $equipe=null, $chefDEquipeMatricule=0, $rapportType=null, $generatedBy=0, $preremp=0, $submitted=0, $validated=0, $deleted=0, $created=0)
    {
        $this->date = $date;
        $this->terminal = $terminal;
        $this->chantier = isset($chantier)? $chantier : new Chantier();;
        $this->equipe = isset($equipe)? $equipe : new User();
        $this->chefDEquipeMatricule = $chefDEquipeMatricule;
        $this->rapportType = $rapportType;
        $this->generatedBy = $generatedBy;
        $this->preremp = $preremp;
        $this->submitted = $submitted;
        $this->validated = $validated;
        $this->deleted = $deleted;
        parent::__construct($id, $created);
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getTerminal()
    {
        return $this->terminal;
    }

    /**
     * @return chantier
     */
    public function getChantier()
    {
        return $this->chantier;
    }

    /**
     * @return user
     */
    public function getEquipe()
    {
        return $this->equipe;
    }

    /**
     * @return int
     */
    public function getChefDEquipeMatricule()
    {
        return $this->chefDEquipeMatricule;
    }

    /**
     * @return string
     */
    public function getRapportType()
    {
        return $this->rapportType;
    }

    /**
     * @return int
     */
    public function getGeneratedBy()
    {
        return $this->generatedBy;
    }

    /**
     * @return boolean
     */
    public function isPreremp()
    {
        return $this->preremp;
    }

    /**
     * @return boolean
     */
    public function isSubmitted()
    {
        return $this->submitted;
    }

    /**
     * @return boolean
     */
    public function isValidated()
    {
        return $this->validated;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql='SELECT * FROM rapport WHERE id=:id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $data = $stmt->fetch();
            $rapportObject = new Rapport(
                $data['id'],
                $data['date'],
                $data['terminal'],
                new Chantier($data['chantier']),
                new User($data['equipe']),
                $data['chef_dequipe_matricule'],
                $data['rapport_type'],
                $data['generated_by'],
                $data['preremp'],
                $data['submitted'],
                $data['validated'],
                $data['deleted'],
                $data['created']
            );
        }
        return $rapportObject;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql = 'SELECT * FROM rapport';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
            }else{
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach($allDatas as $row){
                $returnList[$row['id']]['date']=$row['date'];
                $returnList[$row['id']]['terminal']=$row['terminal'];
                $returnList[$row['id']]['chantier']=$row['chantier'];
                $returnList[$row['id']]['equipe']=$row['equipe'];
                $returnList[$row['id']]['chef_dequipe_matricule']=$row['chef_dequipe_matricule'];
                $returnList[$row['id']]['rapport_type']=$row['rapport_type'];
                $returnList[$row['id']]['generated_by']=$row['generated_by'];
                $returnList[$row['id']]['preremp']=$row['preremp'];
                $returnList[$row['id']]['submitted']=$row['submitted'];
                $returnList[$row['id']]['validated']=$row['validated'];
                $returnList[$row['id']]['deleted']=$row['deleted'];
                $returnList[$row['id']]['created']=$row['created'];
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
        $sql = 'SELECT rapport.date,
                       rapport.terminal,
                       chantier.nom,
                       user.username
                  FROM rapport
                  LEFT JOIN chantier ON chantier.id=rapport.chantier
                  LEFT JOIN user ON user.id = rapport.equipe';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']]= $row['date'].' '.$row['terminal'].' '.$row['nom'].' '.$row['username'];
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
        if ($this->id > 0){
            $sql = '
                UPDATE rapport
                SET
                  date=:date,
                  terminal=:terminal,
                  chantier=:chantier,
                  equipe=:equipe,
                  chef_dequipe_matricule=:chef_dequipe_matricule,
                  rapport_type=:rapport_type,
                  generated_by=:generated_by,
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'NOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', $this->preremp, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', $this->submitted, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', $this->validated, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', $this->deleted, \PDO::PARAM_INT);
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
            $sql='INSERT INTO rapport(
                              date,
                              terminal,
                              chantier,
                              equipe,
                              chef_dequipe_matricule,
                              rapport_type,
                              generated_by,
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :equipe,
                                :chef_dequipe_matricule,
                                :rapport_type,
                                :generated_by,
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'NOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', 0, \PDO::PARAM_INT);

            //var_dump($stmt);
            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }
    }

    public static function saveRapportDetail($date, $chantier, $matricule, $noyauList){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        foreach($noyauList as $team){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `equipe`,
                            `is_chef_dequipe`,
                            `ouvrier_id`,
                            `fullname`)
                            VALUES(
                            :rapport_id,
                            :equipe,
                            :is_chef_dequipe,
                            :ouvrier_id,
                            :fullname)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':equipe',$rapport['equipe'], \PDO::PARAM_INT);
            if($team['matricule']===$team['noyau']){
                $stmt->bindValue(':is_chef_dequipe', 1, \PDO::PARAM_INT);
            }else{
                $stmt->bindValue(':is_chef_dequipe', 0, \PDO::PARAM_INT);
            }
            $stmt->bindValue(':ouvrier_id',$team['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$team['fullname'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }

    }

    public function saveDBAbsentDuNoyau()
    {
        if ($this->id > 0){
            $sql = '
                UPDATE rapport
                SET
                  date=:date,
                  terminal=:terminal,
                  chantier=:chantier,
                  equipe=:equipe,
                  chef_dequipe_matricule=:chef_dequipe_matricule,
                  rapport_type=:rapport_type,
                  generated_by=:generated_by,
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENT');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', $this->preremp, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', $this->submitted, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', $this->validated, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', $this->deleted, \PDO::PARAM_INT);
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
            $sql='INSERT INTO rapport(
                              date,
                              terminal,
                              chantier,
                              equipe,
                              chef_dequipe_matricule,
                              rapport_type,
                              generated_by,
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :equipe,
                                :chef_dequipe_matricule,
                                :rapport_type,
                                :generated_by,
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENT');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', 0, \PDO::PARAM_INT);
            // print_r($this->chantier_id->getId());

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }
    }

    public static  function saveRapportDetailAbsent($date, $chantier, $matricule, $absentList){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        // N'insert pas dans le champ is_chef_dequipe pour éviter le bug notice undefined variable
        foreach($absentList as $team){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `equipe`,
                            `ouvrier_id`,
                            `fullname`,
                            `habs`,
                            `abs`)
                            VALUES(
                            :rapport_id,
                            :equipe,
                            :ouvrier_id,
                            :fullname,
                            :habs,
                            :motif_abs)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':equipe',$rapport['equipe'], \PDO::PARAM_INT);
            /*if($team['matricule']===$team['noyau']){
                $stmt->bindValue(':is_chef_dequipe', 1, \PDO::PARAM_INT);
            }else{
                $stmt->bindValue(':is_chef_dequipe', 0, \PDO::PARAM_INT);
            }*/
            $stmt->bindValue(':ouvrier_id',$team['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$team['fullname'], \PDO::PARAM_STR);
            $stmt->bindValue(':habs',$team['timemin']/60, \PDO::PARAM_INT);
            $stmt->bindValue(':motif_abs',$team['motif'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }

    }

    public function saveDBHorsNoyau()
    {
        if ($this->id > 0){
            $sql = '
                UPDATE rapport
                SET
                  date=:date,
                  terminal=:terminal,
                  chantier=:chantier,
                  rapport_type=:rapport_type,
                  generated_by=:generated_by,
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'HORSNOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', $this->preremp, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', $this->submitted, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', $this->validated, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', $this->deleted, \PDO::PARAM_INT);
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
            $sql='INSERT INTO rapport(
                              date,
                              terminal,
                              chantier,
                              rapport_type,
                              generated_by,
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :rapport_type,
                                :generated_by,
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'HORSNOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', 0, \PDO::PARAM_INT);
            // print_r($this->chantier_id->getId());

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }
    }

    public static  function saveRapportDetailHorsNoyau($date, $chantier, $horsNoyauList){


        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }

        foreach($horsNoyauList as $team){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `ouvrier_id`,
                            `fullname`)
                            VALUES(
                            :rapport_id,
                            :ouvrier_id,
                            :fullname)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':ouvrier_id',$team['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$team['fullname'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }

    }

    public static  function saveRapportDetailInterimaireMobile($date, $chantier, $interimaireMobileList){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        foreach($interimaireMobileList as $interimaireMobile) {

            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `interimaire_id`,
                            `htot`,
                            `fullname`)
                            VALUES(
                            :rapport_id,
                            :interimaire_id,
                            :htot,
                            :fullname)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':interimaire_id',$interimaireMobile['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':htot',8, \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$interimaireMobile['lastname'].' '.$interimaireMobile['firstname'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }

    }

    public function saveDBAbsentHorsNoyau()
    {
        if ($this->id > 0){
            $sql = '
                UPDATE rapport
                SET
                  date=:date,
                  terminal=:terminal,
                  chantier=:chantier,
                  rapport_type=:rapport_type,
                  generated_by=:generated_by,
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', $this->preremp, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', $this->submitted, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', $this->validated, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', $this->deleted, \PDO::PARAM_INT);
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
            $sql='INSERT INTO rapport(
                              date,
                              terminal,
                              chantier,
                              rapport_type,
                              generated_by,
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :rapport_type,
                                :generated_by,
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date);
            $stmt->bindValue(':terminal', $this->terminal, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU');
            $stmt->bindValue(':generated_by', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':preremp', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':submitted', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':validated', 0, \PDO::PARAM_INT);
            $stmt->bindValue(':deleted', 0, \PDO::PARAM_INT);
            // print_r($this->chantier_id->getId());

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }
    }

    public static  function saveRapportDetailAbsentHorsNoyau($date, $chantier, $absentHorsNoyauList, $generatedBy){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND rapport_type=:rapport_type AND generated_by=:generated_by';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU');
        $stmt->bindValue(':generated_by', $generatedBy, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        foreach($absentHorsNoyauList as $team){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `ouvrier_id`,
                            `fullname`,
                            `habs`,
                            `abs`)
                            VALUES(
                            :rapport_id,
                            :ouvrier_id,
                            :fullname,
                            :habs,
                            :motif_abs)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':ouvrier_id',$team['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$team['fullname'], \PDO::PARAM_STR);
            $stmt->bindValue(':habs',$team['timemin']/60, \PDO::PARAM_STR);
            $stmt->bindValue(':motif_abs',$team['motif'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
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
        $sql ='Delete from rapport where id=:id';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return true;
        }
    }

    public static function checkChefDEquipeRapportExist($date, $chantier, $matricule){
        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $nbRows = $stmt->rowCount();
            if($nbRows>=1){
                $rapportExist = true;
            }else{
                $rapportExist = false;
            }
        }
        return $rapportExist;
    }

    public static function checkRapportAbsentExist($date, $chantier, $matricule){
        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $nbRows = $stmt->rowCount();
            if($nbRows>=1){
                $rapportExist = true;
            }else{
                $rapportExist = false;
            }
        }
        return $rapportExist;
    }

    public static function checkChefDEquipeRapportHorsNoyauExist($date, $chantier){
        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule IS NULL AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $nbRows = $stmt->rowCount();
            if($nbRows>=1){
                $rapportHorsNoyauExist = true;
            }else{
                $rapportHorsNoyauExist = false;
            }
        }
        return $rapportHorsNoyauExist;
    }

    public static function checkrapportAbsentHorsNoyauExist($date, $chantier, $generatedBy){
        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule IS NULL AND rapport_type=:rapport_type AND generated_by=:generated_by';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU');
        $stmt->bindValue(':generated_by', $generatedBy, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $nbRows = $stmt->rowCount();
            if($nbRows>=1){
                $rapportAbsentHorsNoyauExist = true;
            }else{
                $rapportAbsentHorsNoyauExist = false;
            }
        }
        return $rapportAbsentHorsNoyauExist;
    }

    public static function getInterimaireByTeamSiteAndDate($date, $chefDequipeid, $chantierId){
        $sql ='SELECT
                interimaire_has_chantier.id,
                interimaire_has_chantier.interimaire_id,
                interimaire_has_chantier.chantier_id,
                interimaire.user_id,
                interimaire_has_chantier.doy,
                interimaire_has_chantier.woy,
                interimaire.matricule,
                interimaire.lastname,
                interimaire.firstname
                FROM
                    user,
                    interimaire_has_chantier
                        INNER JOIN
                    interimaire ON interimaire.id = interimaire_has_chantier.interimaire_id
                        INNER JOIN
                    chantier ON chantier.id = interimaire_has_chantier.chantier_id
                WHERE
                    user.id = interimaire.user_id
                        AND interimaire_has_chantier.chantier_id = :chantierId
                        AND (user.id = :chefDequipeid OR interimaire_has_chantier.chef_dequipe_id = :chefDequipeid)
                        AND interimaire_has_chantier.doy = :date
                        AND interimaire.actif =1
                        AND interimaire_has_chantier.ismobile = 0';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantierId',$chantierId, \PDO::PARAM_INT );
        $stmt->bindValue(':chefDequipeid',$chefDequipeid, \PDO::PARAM_INT );
        $stmt->bindValue(':date',$date);
        if(($stmt->execute()===false)){
            print_r($stmt->errorInfo());
        }else{
            $listInterimaireAffected = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $listInterimaireAffected;
    }

    public static function getInterimaireMobileByTeamSiteAndDate($date,  $chantierId){
        $sql ='SELECT
                interimaire_has_chantier.id,
                interimaire_has_chantier.interimaire_id,
                interimaire_has_chantier.chantier_id,
                interimaire_has_chantier.doy,
                interimaire_has_chantier.woy,
                interimaire_has_chantier.year,
                interimaire.matricule,
                interimaire.lastname,
                interimaire.firstname
                FROM
                    interimaire_has_chantier
                        INNER JOIN
                    interimaire ON interimaire.id = interimaire_has_chantier.interimaire_id
                        INNER JOIN
                    chantier ON chantier.id = interimaire_has_chantier.chantier_id
                WHERE
                        interimaire_has_chantier.chantier_id = :chantierId
                        AND interimaire_has_chantier.doy = :date
                        AND interimaire.actif =1
                        AND interimaire_has_chantier.ismobile = 1';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantierId',$chantierId, \PDO::PARAM_INT );
        $stmt->bindValue(':date',$date);
        if(($stmt->execute()===false)){
            print_r($stmt->errorInfo());
        }else{
            $listInterimaireMobile = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $listInterimaireMobile;
    }

    public static function saveRapportDetailInterimaire($date, $chantier, $matricule, $listInterimaireAffected){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        foreach($listInterimaireAffected as $interimaire){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `equipe`,
                            `interimaire_id`,
                            `htot`,
                            `fullname`)
                            VALUES(
                            :rapport_id,
                            :equipe,
                            :interimaire_id,
                            :htot,
                            :fullname)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':equipe',$rapport['equipe'], \PDO::PARAM_INT);
            $stmt->bindValue(':interimaire_id',$interimaire['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':htot',8, \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$interimaire['lastname'].' '.$interimaire['firstname'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }
    }

    public static function getRapportGenerated(){
    $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC ';
    $stmt = Config::getInstance()->getPDO()->prepare($sql);
    if($stmt->execute() === false){
        print_r($stmt->errorInfo());
    }else{
        $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    return $rapportGeneratedList;
}

    public static function getRapportIntemperieGenerated(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 1
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportGeneratedList;
    }

    public static function getRapportSubmitted(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function getRapportIntemperieSubmitted(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.is_itp = 1
                    AND rapport.validated = 0
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function getRapportValidated(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.generated_by, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 0
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportIntemperieValidated(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.generated_by, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 1
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportValidatedLimited(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.generated_by, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportValidatedFiltered($chantierId, $userId, $dateDeb, $dateFin){

    //    var_dump($chantierId);
    //    var_dump($userId);
    //    var_dump($dateDeb);
    //    var_dump($dateFin);
    //    exit;

        $sql='SELECT
                rapport.id as id_rapport,
                rapport.date,
                rapport.rapport_type,
                user.id as user_id,
                user.username,
                user.firstname,
                user.lastname,
                chantier.id as chantier_id,
                chantier.code,
                chantier.nom,
                rapport.submitted,
                rapport.validated,
                rapport.generated_by,
                rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND chantier.id like :chantierId
                 AND user.id like :userId
                 AND rapport.date BETWEEN :dateDeb AND :dateFin
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC
        ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantierId', '%'.$chantierId.'%');
        $stmt->bindValue(':userId', '%'.$userId.'%');
        $stmt->bindValue(':dateDeb', $dateDeb);
        $stmt->bindValue(':dateFin', $dateFin);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportGeneratedForConducteur($userId){

        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportGeneratedList;
    }

    public static function getRapportIntemperieGeneratedForConducteur($userId){

        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 1
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportGeneratedList;
    }

    public static function getRapportSubmittedForConducteur($userId){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function getRapportIntemperieSubmittedForConducteur($userId){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
                    AND rapport.is_itp = 1
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function getRapportValidatedForConducteur($userId){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 0
                 AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportIntemperieValidatedForConducteur($userId){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 1
                 AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportGeneratedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
                    AND user.username =:matricule
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportGeneratedList;
    }

    public static function getRapportIntemperieGeneratedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
                    AND rapport.is_itp = 1
                    AND user.username =:matricule
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportGeneratedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportGeneratedList;
    }

    public static function getRapportSubmittedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
                    AND rapport.is_itp = 0
                    AND user.username =:matricule
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id =:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function getRapportIntemperieSubmittedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
                    AND rapport.is_itp = 1
                    AND user.username =:matricule
                    AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id =:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportSubmittedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportSubmittedList;
    }

    public static function  getRapportValidatedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 0
                 AND user.username =:matricule
                 AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function  getRapportIntemperieValidatedForChefDEquipe($userId, $userMatricule){
        $sql='SELECT
                rapport.id as id_rapport, rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated, rapport.is_itp
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
              rapport.validated = 1
                 AND rapport.submitted = 1
                 AND rapport.is_itp = 1
                 AND user.username =:matricule
                 AND rapport.chantier IN (SELECT chantier_id FROM chantier_has_user WHERE user_id=:user_id)
            GROUP BY user.lastname, rapport.date, rapport.chantier
            ORDER BY rapport.date DESC';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $userMatricule, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportValidatedList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportValidatedList;
    }

    public static function getRapportNoyau($equipeId, $date, $chantier){
        $sql = 'SELECT * FROM rapport WHERE equipe=:equipeId AND rapport_type=:rapport_type AND date=:date AND chantier=:chantier';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId',$equipeId,\PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','NOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }


        $sql = 'SELECT rapport_detail.*,rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
                WHERE rapport_detail.rapport_id=:rapport_id
                AND rapport.id = rapport_detail.rapport_id
                ORDER BY rapport_detail.is_chef_dequipe DESC , rapport_detail.interimaire_id , rapport_detail.ouvrier_id  ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetail= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetail;
    }

    public static function getRapportAbsentNoyau($equipeId, $date, $chantier){
        $sql = 'SELECT * FROM rapport WHERE equipe=:equipe_id AND rapport_type=:rapport_type AND date=:date AND chantier=:chantier';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipe_id',$equipeId,\PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','ABSENT',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }

        $sql = 'SELECT rapport_detail.*,
                    rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
              WHERE rapport_detail.rapport_id=:rapport_id
              AND rapport.id =rapport_detail.rapport_id
              ORDER BY rapport_detail.is_chef_dequipe DESC, rapport_detail.interimaire_id, rapport_detail.ouvrier_id ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'],\PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetailAbsent= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetailAbsent;
    }

    public static function getRapportHorsNoyau($date, $chantier){
        $sql = 'SELECT * FROM rapport WHERE rapport_type=:rapport_type AND date=:date AND chantier=:chantier';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type','HORSNOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }

        $sql = 'SELECT rapport_detail.*,
                    rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
                WHERE rapport_detail.rapport_id=:rapport_id
                AND rapport.id = rapport_detail.rapport_id
                ORDER BY rapport_detail.is_chef_dequipe DESC, rapport_detail.interimaire_id, rapport_detail.ouvrier_id ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetailHorsNoyau= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetailHorsNoyau;
    }

    public static function getRapportAbsentHorsNoyau($date, $chantier, $generatedBy){
        $sql = 'SELECT * FROM rapport WHERE rapport_type=:rapport_type AND date=:date AND chantier=:chantier AND generated_by=:generated_by';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type','ABSENTHORSNOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':generated_by',$generatedBy,\PDO::PARAM_INT);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }

        $sql = 'SELECT rapport_detail.*,
                    rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
                WHERE rapport_detail.rapport_id=:rapport_id
                AND rapport.id = rapport_detail.rapport_id
                ORDER BY rapport_detail.is_chef_dequipe DESC, rapport_detail.interimaire_id, rapport_detail.ouvrier_id ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetailAbsentHorsNoyau= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetailAbsentHorsNoyau;
    }

    public static function setWorkerHourCalculated($htot, $id){
        $sql = '
                UPDATE `rapport_detail` SET `htot`=:htot WHERE `id`=:id
              ';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':htot', $htot);
        $stmt->bindValue(':id', $id);

        //var_dump($sql);

        if(($stmt->execute()) === false) {
            print_r($stmt->errorInfo());
        }
    }

    public static function setHorsNoyauHourCalculated($habs, $id){
        $sql = '
                UPDATE `rapport_detail` SET `habs`=:habs WHERE `id`=:id
              ';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':habs', $habs);
        $stmt->bindValue(':id', $id);

        //var_dump($sql);

        if(($stmt->execute()) === false) {
            print_r($stmt->errorInfo());
        }
    }

    public static function updateRapportDetail($rapportDetailIdList, $htot, $hins, $machine, $abs, $habs, $dpl_pers,$km, $remarque, $chef_dequipe_updated,
                                                $type_task, $task, $bat, $axe, $et, $ht,
                                                $type_task2, $task2, $bat2, $axe2, $et2, $ht2,
                                                $type_task3, $task3, $bat3, $axe3, $et3, $ht3,
                                                $type_task4, $task4, $bat4, $axe4, $et4, $ht4,
                                                $type_task5, $task5, $bat5, $axe5, $et5, $ht5,
                                                $type_task6, $task6, $bat6, $axe6, $et6, $ht6)
    {
        foreach($rapportDetailIdList as $rapportDetail){
            $sql = 'DELETE FROM `rapport_detail_has_tache`
                    WHERE rapport_detail_id = :rapportDetailId';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT );

            // var_dump($stmt);

            // exit;
            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }


            $sql = 'UPDATE `rapport_detail`
                    SET
                        `htot` = :htot,
                        `hins` = :hins,
                        `machine` = :machine,
                        `abs` = :abs,
                        `habs` = :habs,
                        `dpl_pers` = :dpl_pers,
                        `km` = :km,

                        `type_task_id_1` = :type_task_id_1,
                        `task_id_1` = :task_id_1,
                        `ht1` = :ht1,
                        `bat_1` = :bat_1,
                        `axe_1` = :axe_1,
                        `et_1` = :et_1,

                        `type_task_id_2` = :type_task_id_2,
                        `task_id_2` = :task_id_2,
                        `ht2` = :ht2,
                        `bat_2` = :bat_2,
                        `axe_2` = :axe_2,
                        `et_2` = :et_2,


                        `type_task_id_3` = :type_task_id_3,
                        `task_id_3` = :task_id_3,
                        `ht3` = :ht3,
                        `bat_3` = :bat_3,
                        `axe_3` = :axe_3,
                        `et_3` = :et_3,


                        `type_task_id_4` = :type_task_id_4,
                        `task_id_4` = :task_id_4,
                        `ht4` = :ht4,
                        `bat_4` = :bat_4,
                        `axe_4` = :axe_4,
                        `et_4` = :et_4,


                        `type_task_id_5` = :type_task_id_5,
                        `task_id_5` = :task_id_5,
                        `ht5` = :ht5,
                        `bat_5` = :bat_5,
                        `axe_5` = :axe_5,
                        `et_5` = :et_5,


                        `type_task_id_6` = :type_task_id_6,
                        `task_id_6` = :task_id_6,
                        `ht6` = :ht6,
                        `bat_6` = :bat_6,
                        `axe_6` = :axe_6,
                        `et_6` = :et_6,


                        `remarque` = :remarque,
                        `updated` = :updated,
                        `chef_dequipe_updated` = :chef_dequipe_updated

                    WHERE `id` = :rapportDetailId
                    ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);
            $stmt->bindValue(':htot', $htot);
            $stmt->bindValue(':hins', $hins);
            $stmt->bindValue(':machine', $machine);
            $stmt->bindValue(':abs', $abs);
            $stmt->bindValue(':habs', $habs);
            $stmt->bindValue(':dpl_pers', $dpl_pers, \PDO::PARAM_INT);
            $stmt->bindValue(':km', $km);
            $stmt->bindValue(':remarque', $remarque, \PDO::PARAM_STR);
            $stmt->bindValue(':updated', $updated, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_1', $type_task, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_1', $task, \PDO::PARAM_INT);
            $stmt->bindValue(':ht1', $ht);
            $stmt->bindValue(':bat_1', $bat, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_1', $axe, \PDO::PARAM_INT);
            $stmt->bindValue(':et_1', $et, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_2', $type_task2, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_2', $task2, \PDO::PARAM_INT);
            $stmt->bindValue(':ht2', $ht2);
            $stmt->bindValue(':bat_2', $bat2, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_2', $axe2, \PDO::PARAM_INT);
            $stmt->bindValue(':et_2', $et2, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_3', $type_task3, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_3', $task3, \PDO::PARAM_INT);
            $stmt->bindValue(':ht3', $ht3);
            $stmt->bindValue(':bat_3', $bat3, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_3', $axe3, \PDO::PARAM_INT);
            $stmt->bindValue(':et_3', $et3, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_4', $type_task4, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_4', $task4, \PDO::PARAM_INT);
            $stmt->bindValue(':ht4', $ht4);
            $stmt->bindValue(':bat_4', $bat4, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_4', $axe4, \PDO::PARAM_INT);
            $stmt->bindValue(':et_4', $et4, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_5', $type_task5, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_5', $task5, \PDO::PARAM_INT);
            $stmt->bindValue(':ht5', $ht5);
            $stmt->bindValue(':bat_5', $bat5, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_5', $axe5, \PDO::PARAM_INT);
            $stmt->bindValue(':et_5', $et5, \PDO::PARAM_INT);

            $stmt->bindValue(':type_task_id_6', $type_task6, \PDO::PARAM_INT);
            $stmt->bindValue(':task_id_6', $task6, \PDO::PARAM_INT);
            $stmt->bindValue(':ht6', $ht6 );
            $stmt->bindValue(':bat_6', $bat6, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_6', $axe6, \PDO::PARAM_INT);
            $stmt->bindValue(':et_6', $et6, \PDO::PARAM_INT);

            $stmt->bindValue(':chef_dequipe_updated', $chef_dequipe_updated, \PDO::PARAM_INT);

            //var_dump($stmt);
            //exit;

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $updateStatus = true;
            }
            //exit;
            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task,
                            :type_task,
                            :bat,
                            :axe,
                            :et,
                            :ht
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task', $type_task, \PDO::PARAM_INT);
            $stmt->bindValue(':task', $task, \PDO::PARAM_INT);
            $stmt->bindValue(':bat', $bat);
            $stmt->bindValue(':axe', $axe);
            $stmt->bindValue(':et', $et, \PDO::PARAM_INT);
            $stmt->bindValue(':ht', $ht);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }

            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task2,
                            :type_task2,
                            :bat2,
                            :axe2,
                            :et2,
                            :ht2
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task2', $type_task2, \PDO::PARAM_INT);
            $stmt->bindValue(':task2', $task2, \PDO::PARAM_INT);
            $stmt->bindValue(':bat2', $bat2);
            $stmt->bindValue(':axe2', $axe2);
            $stmt->bindValue(':et2', $et2, \PDO::PARAM_INT);
            $stmt->bindValue(':ht2', $ht2);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }

            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task3,
                            :type_task3,
                            :bat3,
                            :axe3,
                            :et3,
                            :ht3
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task3', $type_task3, \PDO::PARAM_INT);
            $stmt->bindValue(':task3', $task3, \PDO::PARAM_INT);
            $stmt->bindValue(':bat3', $bat3);
            $stmt->bindValue(':axe3', $axe3);
            $stmt->bindValue(':et3', $et3, \PDO::PARAM_INT);
            $stmt->bindValue(':ht3', $ht3);
            $stmt->bindValue(':rapportDetailId',$rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }

            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task4,
                            :type_task4,
                            :bat4,
                            :axe4,
                            :et4,
                            :ht4
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task4', $type_task4, \PDO::PARAM_INT);
            $stmt->bindValue(':task4', $task4, \PDO::PARAM_INT);
            $stmt->bindValue(':bat4', $bat4);
            $stmt->bindValue(':axe4', $axe4);
            $stmt->bindValue(':et4', $et4, \PDO::PARAM_INT);
            $stmt->bindValue(':ht4', $ht4);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }

            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task5,
                            :type_task5,
                            :bat5,
                            :axe5,
                            :et5,
                            :ht5
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task5', $type_task5, \PDO::PARAM_INT);
            $stmt->bindValue(':task5', $task5, \PDO::PARAM_INT);
            $stmt->bindValue(':bat5', $bat5);
            $stmt->bindValue(':axe5', $axe5);
            $stmt->bindValue(':et5', $et5, \PDO::PARAM_INT);
            $stmt->bindValue(':ht5', $ht5);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }

            $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `batiment`,
                        `etage`,
                        `axe`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task6,
                            :type_task6,
                            :bat6,
                            :axe6,
                            :et6,
                            :ht6
                             )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':type_task6', $type_task6, \PDO::PARAM_INT);
            $stmt->bindValue(':task6', $task6, \PDO::PARAM_INT);
            $stmt->bindValue(':bat6', $bat6);
            $stmt->bindValue(':axe6', $axe6);
            $stmt->bindValue(':et6', $et6, \PDO::PARAM_INT);
            $stmt->bindValue(':ht6', $ht6);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }
        }
    }

    // Récupération de manière groupée les volumes horaires cumulées par taches

    public static function getWorkerTask($rapport_detail_id){

          //  var_dump($rapport['id']);

            $sql='
                SELECT rapport_detail_has_tache.id,
                    rapport_detail_has_tache.tache_id,
                    sum(rapport_detail_has_tache.heures) as vhr,
                    tache.code,
                    tache.nom,
                    type_tache.nom_type_tache,
                    type_tache.code_type_tache
                FROM
                    rapport_detail_has_tache
                    INNER JOIN
                    tache ON tache.id= rapport_detail_has_tache.tache_id
                    INNER JOIN
                    type_tache ON type_tache.id = rapport_detail_has_tache.type_tache_id
                WHERE
                    rapport_detail_has_tache.rapport_detail_id = :rapport_detail_id
                    GROUP BY rapport_detail_has_tache.tache_id
                    ORDER BY rapport_detail_has_tache.tache_id
                ';

            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_detail_id', $rapport_detail_id, \PDO::PARAM_INT);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }else{
                $taskList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $taskList;
    }

    // Récupération des volumes horaires cumulées par taches

    public static function getWorkerTaskDetail($rapport_detail_id){

        //  var_dump($rapport['id']);

        $sql='
                SELECT
                    rapport_detail_has_tache.id,
                    rapport_detail_has_tache.heures,
                    tache.code,
                    tache.nom,
                    type_tache.nom_type_tache,
                    type_tache.code_type_tache
                FROM
                    rapport_detail_has_tache
                    INNER JOIN
                    tache ON tache.id= rapport_detail_has_tache.tache_id
                    INNER JOIN
                    type_tache ON type_tache.id = rapport_detail_has_tache.type_tache_id
                WHERE
                    rapport_detail_has_tache.rapport_detail_id = :rapport_detail_id
                    AND type_tache.id = tache.type_tache_id
                ORDER BY tache_id
                ';

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_detail_id', $rapport_detail_id, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $detailTaskList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $detailTaskList;
    }

    public static function getRapportNoyauHeader($rapport_id, $equipeId, $date, $chantier){

        $sql = 'SELECT
                    rapport_detail_has_tache.id,
                    tache.code,
                    tache.nom,
                    SUM(rapport_detail_has_tache.heures) AS vht,
                    rapport_detail_has_tache.tache_id
                FROM
                    rapport_detail_has_tache,
                    tache
                WHERE
                    tache.id = rapport_detail_has_tache.tache_id
                    AND rapport_detail_id IN (SELECT
                            rapport_detail.id
                        FROM
                            rapport_detail,
                            rapport
                        WHERE
                            rapport_detail.rapport_id = :rapport_id
                                AND rapport.id = rapport_detail.rapport_id
                                AND rapport_detail.rapport_id IN (SELECT
                                    id
                                FROM
                                    rapport
                                WHERE
                                    equipe = :equipeId AND rapport_type = :rapport_type
                                        AND date = :date
                                        AND chantier = :chantier))

                GROUP BY tache_id
                ORDER BY tache_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport_id, \PDO::PARAM_INT);
        $stmt->bindValue(':equipeId',$equipeId,\PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','NOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $noyauHeader= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $noyauHeader;
    }

    public static function getRapportAbsentNoyauHeader($rapport_id, $equipeId, $date, $chantier){

        $sql = 'SELECT
                    rapport_detail_has_tache.id,
                    tache.code,
                    tache.nom,
                    SUM(rapport_detail_has_tache.heures) AS vht,
                    rapport_detail_has_tache.tache_id
                FROM
                    rapport_detail_has_tache, tache
                WHERE
                    tache.id=rapport_detail_has_tache.tache_id
                    AND rapport_detail_id IN (SELECT
                            rapport_detail.id
                        FROM
                            rapport_detail,
                            rapport
                        WHERE
                            rapport_detail.rapport_id = :rapport_id
                                AND rapport.id = rapport_detail.rapport_id
                                AND rapport_detail.rapport_id IN (SELECT
                                    id
                                FROM
                                    rapport
                                WHERE
                                    equipe = :equipe_id AND rapport_type = :rapport_type
                                        AND date = :date
                                        AND chantier = :chantier))

                GROUP BY tache_id
                ORDER BY tache_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport_id,\PDO::PARAM_INT);
        $stmt->bindValue(':equipe_id',$equipeId,\PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','ABSENT',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $noyauHeaderAbsent= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $noyauHeaderAbsent;
    }

    public static function getRapportHorsNoyauHeader($rapport_id, $date, $chantier){

        $sql = 'SELECT
                    rapport_detail_has_tache.id,
                    tache.code,
                    tache.nom,
                    SUM(rapport_detail_has_tache.heures) AS vht,
                    rapport_detail_has_tache.tache_id
                FROM
                    rapport_detail_has_tache,
                    tache
                WHERE
                    tache.id = rapport_detail_has_tache.tache_id
                        AND rapport_detail_id IN (SELECT
                            rapport_detail.id
                        FROM
                            rapport_detail,
                            rapport
                        WHERE
                            rapport_detail.rapport_id = :rapport_id
                                AND rapport.id = rapport_detail.rapport_id
                                AND rapport_detail.rapport_id IN (SELECT
                                    id
                                FROM
                                    rapport
                                WHERE
                                    rapport_type = :rapport_type
                                        AND date = :date
                                        AND chantier =:chantier ))
                GROUP BY tache_id
                ORDER BY tache_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport_id, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','HORSNOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $noyauHeaderHorsNoyau= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $noyauHeaderHorsNoyau;
    }

    public static function getRapportAbsentHorsNoyauHeader($rapport_id, $date, $chantier){

        $sql = 'SELECT
                    rapport_detail_has_tache.id,
                    tache.code,
                    tache.nom,
                    SUM(rapport_detail_has_tache.heures) AS vht,
                    rapport_detail_has_tache.tache_id
                FROM
                    rapport_detail_has_tache,
                    tache
                WHERE
                    tache.id = rapport_detail_has_tache.tache_id
                        AND rapport_detail_id IN (SELECT
                            rapport_detail.id
                        FROM
                            rapport_detail,
                            rapport
                        WHERE
                            rapport_detail.rapport_id = :rapport_id
                                AND rapport.id = rapport_detail.rapport_id
                                AND rapport_detail.rapport_id IN (SELECT
                                    id
                                FROM
                                    rapport
                                WHERE
                                    rapport_type = :rapport_type
                                        AND date = :date
                                        AND chantier =:chantier ))
                GROUP BY tache_id
                ORDER BY tache_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport_id, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','ABSENTHORSNOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $noyauHeaderAbsentHorsNoyau= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $noyauHeaderAbsentHorsNoyau;
    }

    public static function validateRapport($equipeId, $date, $chantier){
        $sql = 'UPDATE rapport set validated=:validated
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set validated=:validated
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set validated=:validated
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }
    /*
     * rapport_id=4
     * &rapport_type=NOYAU
     * &chef_dequipe_id=67
     * &chef_dequipe_matricule=38
     * &date_generation=2017-10-02
     * &chantier_id=205
     * &chantier_code=156100
     * */

    public static function validateHorsNoyau($date, $chantier){

        $sql = 'UPDATE rapport set validated=:validated
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 1);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function inValidateRapport($equipeId, $date, $chantier){
        $sql = 'UPDATE rapport set validated=:validated,
                submitted =:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated,submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set validated=:validated,
                submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }


        $sql='UPDATE rapport_detail set validated=:validated,submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set validated=:validated,
                submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated,submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function unValidateHorsNoyau($date, $chantier){

        $sql = 'UPDATE rapport set validated=:validated,
                submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set validated=:validated,submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':validated', 0);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function submittRapport($equipeId, $date, $chantier){
        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function submittHorsNoyau($date, $chantier){

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 1);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function unSubmittRapport($equipeId, $date, $chantier){

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'NOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier
                AND equipe=:equipe)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENT' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );
        $stmt->bindValue(':equipe',$equipeId, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function unSubmiittHorsNoyau($date, $chantier){

        $sql = 'UPDATE rapport set submitted=:submitted
                WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }

        $sql='UPDATE rapport_detail set submitted=:submitted  WHERE rapport_id IN
                ( SELECT id FROM rapport WHERE rapport_type=:rapport_type
                AND date=:date
                AND chantier=:chantier )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':submitted', 0);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU' );
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier',$chantier, \PDO::PARAM_INT );

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }

    public static function deleteRapport($equipeId, $date, $chantier)
    {
        $sql='DELETE FROM rapport_detail_has_tache WHERE rapport_detail_id IN
              (SELECT rapport_detail.id
                    FROM rapport_detail, rapport
                    WHERE rapport.id = rapport_detail.rapport_id
                    AND rapport_id IN
                        (SELECT id FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                        )
                )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport_detail
                WHERE rapport_detail.rapport_id IN
                        (SELECT id FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier ';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport_detail_has_tache WHERE rapport_detail_id IN
              (SELECT rapport_detail.id
                    FROM rapport_detail, rapport
                    WHERE rapport.id = rapport_detail.rapport_id
                    AND rapport_id IN
                        (SELECT id FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                        )
                )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport_detail
                WHERE rapport_detail.rapport_id IN
                        (SELECT id FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport
                            WHERE equipe=:equipeId
                            AND rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier ';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId', $equipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

    //    return true;
    }

    public static function deleteRapportAbsentHorsNoyau($date, $chantier, $generatedBy){
        $sql='DELETE FROM rapport_detail_has_tache WHERE rapport_detail_id IN
              (SELECT rapport_detail.id
                    FROM rapport_detail, rapport
                    WHERE rapport.id = rapport_detail.rapport_id
                    AND rapport_id IN
                        (SELECT id FROM rapport
                            WHERE  rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                            AND generated_by=:generated_by
                        )
                )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':generated_by', $generatedBy, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport_detail
                WHERE rapport_detail.rapport_id IN
                        (SELECT id FROM rapport
                            WHERE rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                            AND generated_by=:generated_by
                            )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':generated_by', $generatedBy, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport
                            WHERE rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                            AND generated_by=:generated_by';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'ABSENTHORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':generated_by', $generatedBy, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

    //    return "yo";
    }

    public static function deleteRapportHorsNoyau($date, $chantier){

        $sql='DELETE FROM rapport_detail_has_tache WHERE rapport_detail_id IN
              (SELECT rapport_detail.id
                    FROM rapport_detail, rapport
                    WHERE rapport.id = rapport_detail.rapport_id
                    AND rapport_id IN
                        (SELECT id FROM rapport
                            WHERE  rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier
                        )
                )';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport_detail
                WHERE rapport_detail.rapport_id IN
                        (SELECT id FROM rapport
                            WHERE rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier)';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        $sql='DELETE FROM rapport
                            WHERE rapport_type=:rapport_type
                            AND date=:date
                            AND chantier=:chantier ';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU', \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        return "true";
    }

    public static function getRapportDetailWithHourAnomaly(){
        $sql = 'SELECT
                  rapport_detail.*,
                  rapport.date,
                  rapport.chef_dequipe_matricule,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.equipe,
                    chantier.code,
                    chantier.nom
                FROM
                    rapport_detail
                        INNER JOIN
                    rapport ON rapport.id = rapport_detail.rapport_id
                        INNER JOIN
                    chantier ON chantier.id = rapport.chantier
                WHERE
                    htot <> (ht1 + ht2 + ht3 + ht4 + ht5 + ht6)
                    AND rapport_detail.hour_anomaly_treated = 0
                        AND rapport_detail.validated = 1
                        AND rapport_detail.submitted = 1
                        AND (rapport.rapport_type LIKE "NOYAU" OR rapport.rapport_type LIKE "HORSNOYAU")
                GROUP BY rapport_detail.id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);

        if($stmt->execute()=== false){
            print_r($stmt->errorInfo());
        }else{
            $hourAnomalxList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $hourAnomalxList;
    }

    public static function hourAnomalyTreatment($rapport_detail_id){
        $sql = 'Update rapport_detail SET hour_anomaly_treated = 1 where id =:id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $rapport_detail_id);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }
    }

    public static function getRapportDetailWithAbsenceAnomaly(){
        $sql = "SELECT
                  rapport_detail.*,
                  rapport.date,
                  rapport.chef_dequipe_matricule,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.equipe,
                    chantier.code,
                    chantier.nom
                FROM
                    rapport_detail
                        INNER JOIN
                    rapport ON rapport.id = rapport_detail.rapport_id
                        INNER JOIN
                    chantier ON chantier.id = rapport.chantier
                WHERE
                    (abs = 'Accident (A)'
                    OR abs = 'Congé (C)'
                    OR abs = 'Absence  Excusée (EX)'
                    OR abs = 'Intempéries (INT)'
                    OR abs = 'Formation (FOR)'
                    OR abs = 'Congé Extraordinaire (CE)'
                    OR abs = 'Absence non Excusée (ABS)'
                    OR abs = 'Congé Syndical (CS)'
                    OR abs = 'Visite Médicale STI (STI)'
                    OR abs = 'Travaux Autre Chantier (TAC)'
                    OR abs = 'Maladie (M)'
                    OR abs = 'Fin de mission (FM)'
                    OR abs = 'Transfert vers autre chantier (TVC)')
                    AND rapport_detail.absence_anomaly_treated = 0
                    AND rapport_detail.validated = '1'
                    AND rapport_detail.submitted = '1'
                    AND (rapport.rapport_type LIKE 'NOYAU' OR rapport.rapport_type LIKE 'HORSNOYAU')";
        $stmt = Config::getInstance()->getPDO()->prepare($sql);

        if($stmt->execute()=== false){
            print_r($stmt->errorInfo());
        }else{
            $absenceList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $absenceList;
    }

    public static function absenceAnomalyTreatment($rapport_detail_id){
        $sql = 'Update rapport_detail SET absence_anomaly_treated = 1 where id =:id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $rapport_detail_id);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }
    }

    public static function updateHtotInterimaire($interimaire)
    {
        $sql='UPDATE rapport_detail set htot = (ht1+ht2+ht3+ht4+ht5+ht6) WHERE interimaire_id=:interimaire_id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':interimaire_id', $interimaire, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

    }

    public static function getRapportInterimaire($equipeId, $date, $chantier){
        $sql = 'SELECT * FROM rapport WHERE equipe=:equipeId AND rapport_type=:rapport_type AND date=:date AND chantier=:chantier';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':equipeId',$equipeId,\PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type','NOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }


        $sql = 'SELECT rapport_detail.*,rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
                WHERE rapport_detail.rapport_id=:rapport_id
                AND rapport.id = rapport_detail.rapport_id
                AND rapport_detail.interimaire_id is not null';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetail= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetail;
    }

    public static function getRapportInterimaireMobile( $date, $chantier){
        $sql = 'SELECT * FROM rapport WHERE rapport_type=:rapport_type AND date=:date AND chantier=:chantier';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_type','HORSNOYAU',\PDO::PARAM_STR);
        $stmt->bindValue(':date',$date);
        $stmt->bindValue(':chantier',$chantier,\PDO::PARAM_INT);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }


        $sql = 'SELECT rapport_detail.*,rapport.date,
                    rapport.chef_dequipe_matricule,
                    rapport.chantier
                FROM rapport_detail, rapport
                WHERE rapport_detail.rapport_id=:rapport_id
                AND rapport.id = rapport_detail.rapport_id
                AND rapport_detail.interimaire_id is not null';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetail= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetail;
    }

    public static function tasksHoursByWorkersBySite($chantier,$date_debut, $date_fin){

        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) task_hours,
                    tache.id,
                    tache.code,
                    tache.nom,
                    rapport.id,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $taskHoursbyWorkersbySite = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $taskHoursbyWorkersbySite;
    }

    public static function tasksHoursBySite($chantier, $date_debut, $date_fin){
        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) task_hours,
                    tache.id,
                    tache.code,
                    tache.nom,
                    rapport.id,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, chantier.id
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $taskHoursBySite = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $taskHoursBySite;
    }

    public static function tasksHoursBySiteByWorker($chantier, $tache, $date_debut, $date_fin, $worker){
        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) task_hours,
                    tache.id as id_tache,
                    tache.code as code_tache,
                    tache.nom as nom_tache,
                    rapport.id as id_rapport,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id as type_tache_id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail.remarque,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.tache_id LIKE :tache_id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id = :chantier
                    AND (rapport_detail.ouvrier_id LIKE :worker OR rapport_detail.interimaire_id LIKE :worker)
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id, rapport.date
                ORDER BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id, rapport.date
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':worker','%'.$worker.'%',\PDO::PARAM_STR);
        $stmt->bindValue(':tache_id','%'.$tache.'%',\PDO::PARAM_STR);


        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $taskHoursBySiteWorker = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $taskHoursBySiteWorker;
    }

    public static function tasksHoursBySiteByWorkerRecap($chantier, $tache, $date_debut, $date_fin, $worker){
        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) task_hours,
                    tache.id as id_tache,
                    tache.code as code_tache,
                    tache.nom as nom_tache,
                    rapport.id as id_rapport,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id as type_tache_id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.tache_id LIKE :tache_id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id = :chantier
                    AND (rapport_detail.ouvrier_id LIKE :worker OR rapport_detail.interimaire_id LIKE :worker)
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
                ORDER BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':worker','%'.$worker.'%',\PDO::PARAM_STR);
        $stmt->bindValue(':tache_id',$tache,\PDO::PARAM_STR);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $taskHoursBySiteWorkerRecap = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $taskHoursBySiteWorkerRecap;
    }

    public static function tasksHoursBySiteByWorkerHeader($chantier, $date_debut, $date_fin, $worker){
        $sql="SELECT
                    distinct
                    tache.id as id_tache,
                    tache.code as code_tache,
                    rapport_detail.fullname,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND (rapport_detail.fullname LIKE :worker OR rapport_detail.ouvrier_id LIKE :worker OR rapport_detail.interimaire_id LIKE :worker)
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY rapport_detail.fullname
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':worker','%'.$worker.'%',\PDO::PARAM_STR);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $taskHoursBySiteWorkerHeader = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $taskHoursBySiteWorkerHeader;
    }

    public static function tasksHoursDoneBySite($chantier, $date_debut, $date_fin, $tache){
        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) as task_hours,
                    tache.id as id_tache,
                    tache.code as code_tache,
                    tache.nom as nom_tache,
                    rapport.id as id_rapport,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND tache.id like :tache
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':tache',$tache,\PDO::PARAM_STR);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $eachTaskHoursBySite = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $eachTaskHoursBySite;
    }

    public static function tasksHoursDoneBySiteExcel($chantier, $date_debut, $date_fin, $tache){
        $sql="SELECT
                    chantier.code,
                    chantier.nom,
                    rapport.date,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    tache.code as code_tache,
                    tache.nom as nom_tache,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures,
                    SUM(rapport_detail_has_tache.heures) as task_hours
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND tache.id like :tache
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id, rapport_detail.fullname, chantier.id
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':tache',$tache,\PDO::PARAM_STR);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $eachTaskHoursBySite = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $eachTaskHoursBySite;
    }

    public static function tasksHoursDoneBySiteHeader($chantier, $date_debut, $date_fin, $tache){
        $sql="SELECT
                    SUM(rapport_detail_has_tache.heures) as task_hours,
                    tache.id as id_tache,
                    tache.code as code_tache,
                    tache.nom as nom_tache,
                    rapport.id as id_rapport,
                    rapport.chantier,
                    rapport.rapport_type,
                    rapport.date,
                    chantier.id,
                    chantier.code,
                    chantier.nom,
                    rapport.equipe,
                    rapport.chef_dequipe_matricule,
                    rapport_detail.ouvrier_id,
                    rapport_detail.interimaire_id,
                    rapport_detail.fullname,
                    rapport_detail.htot,
                    rapport_detail.abs,
                    rapport_detail.habs,
                    type_tache.id,
                    type_tache.code_type_tache,
                    type_tache.nom_type_tache,
                    rapport_detail_has_tache.batiment,
                    rapport_detail_has_tache.etage,
                    rapport_detail_has_tache.axe,
                    rapport_detail_has_tache.heures
                FROM
                    type_tache,
                    tache,
                    rapport_detail,
                    rapport,
                    chantier,
                    rapport_detail_has_tache
                WHERE
                    rapport.id = rapport_detail.rapport_id
                    AND chantier.id = rapport.chantier
                    AND rapport_detail_has_tache.type_tache_id = type_tache.id
                    AND rapport_detail_has_tache.tache_id = tache.id
                    AND rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND chantier.id LIKE :chantier
                    AND tache.id like :tache
                    AND rapport.date BETWEEN :date_debut AND :date_fin
                    AND rapport.submitted = 1
                    AND rapport.validated = 1
                    AND rapport.rapport_type IN ('NOYAU' ,  'HORSNOYAU')
                GROUP BY tache.id, type_tache.id,  chantier.id
                ORDER BY chantier.id
        ";

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date_debut',$date_debut);
        $stmt->bindValue(':date_fin',$date_fin);
        $stmt->bindValue(':tache',$tache,\PDO::PARAM_STR);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $eachTaskHoursBySite = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $eachTaskHoursBySite;
    }

    public static function condenseTaskDoneOnSite($chantier, $dateDebut, $dateFin){
        $sql = 'SELECT
                    E.code as code_chantier, E.nom as nom_chantier, B.code as code_tache, B.nom as nom_tache, SUM(A.heures) heures
                FROM
                    rapport_detail_has_tache AS A,
                    tache AS B,
                    rapport_detail AS C,
                    rapport AS D,
                    chantier AS E
                WHERE
                    A.tache_id = B.id
                        AND A.rapport_detail_id = C.id
                        AND C.rapport_id = D.id
                        AND D.chantier = E.id
                        AND E.id =:chantier
                        AND D.date BETWEEN :dateDebut AND :dateFin
                GROUP BY B.nom
                ORDER BY B.nom';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier);
        $stmt->bindValue(':dateDebut', $dateDebut);
        $stmt->bindValue(':dateFin', $dateFin);

        if($stmt->execute()=== false){
            print_r($stmt->errorInfo());
        }else{
            $rst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rst;
    }

    public static function checkAllRapportSubmitted($date, $chantier){

        $submitted = array();

        $sql = "SELECT * FROM rapport where date =:date AND chantier =:chantier AND rapport_type <> 'HORSNOYAU'";
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date',$date);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $allRapport = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        foreach($allRapport as $rapport){
            $submitted[] = $rapport['submitted'] ;
        }

        $ok = in_array("0", $submitted);
        return $ok;
    }

    public static function checkAllRapportValidated($date, $chantier){

        $validated = array();

        $sql = "SELECT * FROM rapport where date =:date AND chantier =:chantier AND rapport_type <> 'HORSNOYAU'";
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date',$date);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $allRapport = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        foreach($allRapport as $rapport){
            $validated[] = $rapport['validated'] ;
        }

        $ok = in_array("0", $validated);
        return $ok;
    }

    public static function checkAllRapportDeleted($date, $chantier){


        $sql = "SELECT * FROM rapport where date =:date AND chantier =:chantier AND rapport_type <> 'HORSNOYAU'";
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier',$chantier);
        $stmt->bindValue(':date',$date);
        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $nbRows = $stmt->rowCount();
        }
        if ($nbRows <= 0){
            $ok = true;
        }else{
            $ok = false;
        }

        return $ok;

    }

    // récupération du dernier rapport généré et validé pour ce chantier et ce chef d'équipe
    public static function lastRapportNoyauValidated($chantier, $chefDEquipeId){
        $sql = "SELECT * FROM rapport
                WHERE chantier=:chantier
                AND equipe =:chefDEquipeId
                AND rapport_type='NOYAU'
                AND validated = 1
                AND is_itp = 0
                ORDER BY id desc LIMIT 1"
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':chefDEquipeId', $chefDEquipeId, \PDO::PARAM_INT);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportValidated = $stmt->fetch();
        }
        return $lastRapportValidated;
    }

    // recupération du dernier rapport créé

    public static function getLastRapportNoyauCreated($chantier, $equipe, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier = :chantier
                AND equipe = :equipe
                AND rapport_type = 'NOYAU'
                AND date = :date";

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier);
        $stmt->bindValue(':equipe', $equipe);
        $stmt->bindValue(':date', $date);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportCreated = $stmt->fetch();
        }

        return $lastRapportCreated ;
    }

    // La date qui sera mise dans ces 3 fonctions ci-dessous proviennent du résultat de la première requête
    public static function lastRapportAbsentNoyauValidated($chantier, $chefDEquipeId, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier=:chantier
                AND date =:date
                AND equipe =:chefDEquipeId
                AND rapport_type='ABSENT'
                AND validated = 1"
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':chefDEquipeId', $chefDEquipeId, \PDO::PARAM_INT);
        $stmt->bindValue(':date', $date);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportValidated = $stmt->fetch();
        }
        return $lastRapportValidated;
    }

    public static function getLastRapportAbsentCreated($chantier, $equipe, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier = :chantier
                AND equipe = :equipe
                AND rapport_type = 'ABSENT'
                AND date = :date";

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier);
        $stmt->bindValue(':equipe', $equipe);
        $stmt->bindValue(':date', $date);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportAbsentCreated = $stmt->fetch();
        }

        return $lastRapportAbsentCreated ;
    }

    public static function lastRapportHorsNoyauValidated($chantier, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier=:chantier
                AND date =:date
                AND rapport_type='HORSNOYAU'
                AND validated = 1"
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':date', $date);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportValidated = $stmt->fetch();
        }
        return $lastRapportValidated;
    }

    public static function getLastRapportHorsNoyauCreated($chantier, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier = :chantier
                AND rapport_type = 'HORSNOYAU'
                AND date = :date";

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier);
        $stmt->bindValue(':date', $date);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportHorsNoyauCreated = $stmt->fetch();
        }

        return $lastRapportHorsNoyauCreated ;
    }

    public static function lastRapportAbsentHorsNoyauValidated($chantier, $date, $generated_by){
        $sql = "SELECT * FROM rapport
                WHERE chantier=:chantier
                AND date =:date
                AND rapport_type='ABSENTHORSNOYAU'
                AND validated = 1
                AND generated_by =:generated_by"
        ;
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':generated_by', $generated_by);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportValidated = $stmt->fetch();
        }
        return $lastRapportValidated;
    }

    public static function getLastRapportAbsentHorsNoyauCreated($chantier, $date){
        $sql = "SELECT * FROM rapport
                WHERE chantier = :chantier
                AND rapport_type = 'ABSENTHORSNOYAU'
                AND date = :date";

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier', $chantier);
        $stmt->bindValue(':date', $date);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $lastRapportAbsentHorsNoyauCreated = $stmt->fetch();
        }

        return $lastRapportAbsentHorsNoyauCreated ;
    }

    public static function rapportDetailIntemperieSave($rapportId, $lastRapportIdCreated) {
        $sql = "SELECT * FROM rapport_detail WHERE rapport_id =:rapport_id";
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapportId, \PDO::PARAM_INT);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetail = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        foreach ($rapportDetail as $detail){
            $sql = 'INSERT INTO rapport_detail(
                    rapport_id,
                    equipe,
                    fullname,
                    is_chef_dequipe,
                    ouvrier_id,
                    interimaire_id)
                    VALUES(:rapport_id,
                    :equipe,
                    :fullname,
                    :is_chef_dequipe,
                    :ouvrier_id,
                    :interimaire_id)';

            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id', $lastRapportIdCreated);
            $stmt->bindValue(':equipe',$detail['equipe'] );
            $stmt->bindValue(':fullname', $detail['fullname']);
            $stmt->bindValue(':is_chef_dequipe',$detail['is_chef_dequipe'] );
            $stmt->bindValue(':ouvrier_id', $detail['ouvrier_id']);
            $stmt->bindValue(':interimaire_id',$detail['interimaire_id'] );

            if($stmt->execute() === false){
                print_r($stmt->errorInfo());
            }else{
                $ok  = true;
            }
        }
    }

    public static function rapportDetailAbsentIntemperieSave($rapportId, $lastRapportIdCreated) {
        $sql = "SELECT * FROM rapport_detail WHERE rapport_id =:rapport_id";
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapportId, \PDO::PARAM_INT);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetail = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        foreach ($rapportDetail as $detail){
            $sql = 'INSERT INTO rapport_detail(
                    rapport_id,
                    equipe,
                    fullname,
                    is_chef_dequipe,
                    ouvrier_id,
                    interimaire_id,
                    habs,
                    abs)
                    VALUES(:rapport_id,
                    :equipe,
                    :fullname,
                    :is_chef_dequipe,
                    :ouvrier_id,
                    :interimaire_id,
                    :habs,
                    :abs)';

            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id', $lastRapportIdCreated);
            $stmt->bindValue(':equipe',$detail['equipe'] );
            $stmt->bindValue(':fullname', $detail['fullname']);
            $stmt->bindValue(':is_chef_dequipe',$detail['is_chef_dequipe'] );
            $stmt->bindValue(':ouvrier_id', $detail['ouvrier_id']);
            $stmt->bindValue(':interimaire_id',$detail['interimaire_id'] );
            $stmt->bindValue(':habs',$detail['habs'] );
            $stmt->bindValue(':abs',$detail['abs'] );

            if($stmt->execute() === false){
                print_r($stmt->errorInfo());
            }else{
                $ok  = true;
            }
        }
    }

    public static function rapportIntemperieSave($date, $chantier, $equipe, $chefDEquipeMatricule, $rapport_type, $generated_by, $preremp){
        $sql='INSERT INTO rapport(
                              date,
                              chantier,
                              equipe,
                              chef_dequipe_matricule,
                              rapport_type,
                              generated_by,
                              is_itp,
                              preremp
                              )VALUES(
                                :date,
                                :chantier,
                                :equipe,
                                :chef_dequipe_matricule,
                                :rapport_type,
                                :generated_by,
                                :is_itp,
                                :preremp
                                )';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':equipe', $equipe, \PDO::PARAM_INT);
        $stmt->bindValue(':chef_dequipe_matricule', $chefDEquipeMatricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', $rapport_type);
        $stmt->bindValue(':generated_by', $generated_by, \PDO::PARAM_INT);
        $stmt->bindValue(':is_itp', 1, \PDO::PARAM_INT);
        $stmt->bindValue(':preremp', $preremp, \PDO::PARAM_INT);

        //var_dump($stmt);
        // exit;
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
            return false ;
        }
        else {
            return true ;
        }
    }

    public static function getRapportNoyauItp($date, $chantierId, $generatedBy){
    $sql = 'SELECT
            rapport.id
        FROM
            rapport,
            chantier
        WHERE
            date =:date
        AND chantier.id = rapport.chantier
        AND chantier.id =:chantier_id
        AND rapport.rapport_type =:rapport_type
        AND chantier.is_itp = 1
        AND rapport.generated_by =:generated_by';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier_id', $chantierId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'NOYAU');
        $stmt->bindValue(':generated_by', $generatedBy);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $rapport = $stmt->fetch();
        }
        return $rapport;
    }

    public static function getRapportDetailsItp($rapportId){
        $sql = 'SELECT * FROM rapport_detail WHERE rapport_id =:rapport_id';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapportId);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            return $detailList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public static function getRapportDetailsOuvrierItp($rapportId){
        $sql = 'SELECT * FROM rapport_detail WHERE rapport_id =:rapport_id AND ouvrier_id is not  null';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapportId);

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            return $detailList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public static function getRapportHorsNoyauItp($date, $chantierId, $generatedBy){
        $sql = 'SELECT
            rapport.id
        FROM
            rapport,
            chantier
        WHERE
            date =:date
        AND chantier.id = rapport.chantier
        AND chantier.id =:chantier_id
        AND rapport.rapport_type =:rapport_type
        AND chantier.is_itp = 1
        AND generated_by=:generated_by';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date);
        $stmt->bindValue(':chantier_id', $chantierId, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'HORSNOYAU');
        $stmt->bindValue(':generated_by', $generatedBy);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $rapport = $stmt->fetch();
        }
        return $rapport;
    }

    public static function setItpTask($rapportId, $itpOuvriers){
        $sql = 'SELECT
                    rapport_detail.id,
                    rapport_detail.ouvrier_id
                FROM
                    rapport_detail
                WHERE
                    rapport_id =:rapport_id
                AND rapport_detail.ouvrier_id IS NOT NULL';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapportId, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetails = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

    //
    //    var_dump($itpOuvrier);

    //    exit;

        foreach($rapportDetails as $rapportDetail){
            foreach($itpOuvriers as $itpOuvrier){

                if($rapportDetail['ouvrier_id'] === $itpOuvrier['matricule']) {
                    $sql = 'UPDATE rapport_detail SET type_task_id_1 = 11,
                          task_id_1 = 97,
                          ht1=:htask
                          WHERE rapport_detail.id=:rapport_detail_id';
                    $stmt = Config::getInstance()->getPDO()->prepare($sql);
                    $stmt->bindValue(':htask', $itpOuvrier['timemin']/60, \PDO::PARAM_INT);
                    $stmt->bindValue(':rapport_detail_id', $rapportDetail['id'], \PDO::PARAM_INT);
                    if ($stmt->execute() === false) {
                        print_r($stmt->errorInfo());
                    } else {
                        $success = true;
                    }

                    $sql = 'INSERT INTO rapport_detail_has_tache(
                        `rapport_detail_id`,
                        `tache_id`,
                        `type_tache_id`,
                        `heures`
                    )
                    VALUES(
                            :rapportDetailId,
                            :task,
                            :type_task,
                            :ht
                             )';
                    $stmt = Config::getInstance()->getPDO()->prepare($sql);
                    $stmt->bindValue(':type_task', 11, \PDO::PARAM_INT);
                    $stmt->bindValue(':task', 97, \PDO::PARAM_INT);
                    $stmt->bindValue(':ht', $itpOuvrier['timemin']/60, \PDO::PARAM_INT);
                    $stmt->bindValue(':rapportDetailId', $rapportDetail['id'], \PDO::PARAM_INT);

                    if ($stmt->execute() === false) {
                        print_r($stmt->errorInfo());
                    } else {
                        $insertStatus = true;
                    }

                }
            }
        }
    }

    public static function updateHtotForIntemperie($date, $chantier, $itpOuvriers){

        foreach($itpOuvriers as $itpOuvrier){

            $sql = 'UPDATE rapport_detail
                    SET
                        htot = (htot + ht1 + ht2 + ht3 + ht4 + ht5 + ht6)
                    WHERE
                        ouvrier_id =:ouvrier_id
                            AND
                                rapport_id IN (SELECT
                                        id
                                    FROM
                                        rapport
                                    WHERE
                                        date =:date AND chantier =:chantier)';
            $stmt= Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':ouvrier_id', $itpOuvrier['matricule']);
            $stmt->bindValue(':date', $date);
            $stmt->bindValue(':chantier', $chantier);

            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }else{
                $ok = true;
            }
        }
    }

}