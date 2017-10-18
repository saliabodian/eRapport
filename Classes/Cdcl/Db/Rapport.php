<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/09/2017
 * Time: 10:57
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

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

    function __construct($id=0, $date=0, $terminal=0, $chantier=null, $equipe=null, $chefDEquipeMatricule=0, $rapportType=null, $preremp=0, $submitted=0, $validated=0, $deleted=0, $created=0)
    {
        $this->date = $date;
        $this->terminal = $terminal;
        $this->chantier = isset($chantier)? $chantier : new Chantier();;
        $this->equipe = isset($equipe)? $equipe : new User();
        $this->chefDEquipeMatricule = $chefDEquipeMatricule;
        $this->rapportType = $rapportType;
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
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'NOYAU');
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
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'NOYAU');
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENT');
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
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':equipe', $this->equipe->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':chef_dequipe_matricule', $this->chefDEquipeMatricule, \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'ABSENT');
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
        $stmt->bindValue(':chantier', $chantier, \PDO::PARAM_INT);
        $stmt->bindValue(':matricule', $matricule, \PDO::PARAM_INT);
        $stmt->bindValue(':rapport_type', 'ABSENT');
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapport = $stmt->fetch();
        }
        foreach($absentList as $team){
            $sql='INSERT INTO `rapport_detail`
                            (
                            `rapport_id`,
                            `equipe`,
                            `is_chef_dequipe`,
                            `ouvrier_id`,
                            `fullname`,
                            `motif_abs`)
                            VALUES(
                            :rapport_id,
                            :equipe,
                            :is_chef_dequipe,
                            :ouvrier_id,
                            :fullname,
                            :motif_abs)';
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
                  preremp=:preremp,
                  submitted=:submitted,
                  validated=:validated,
                  deleted=:deleted
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'HORSNOYAU');
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
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :rapport_type,
                                :preremp,
                                :submitted,
                                :validated,
                                :deleted
                                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':date', $this->date, \PDO::PARAM_INT);
            $stmt->bindValue(':terminal', $this->matricule_cns, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier', $this->chantier->getId(), \PDO::PARAM_INT);
            $stmt->bindValue(':rapport_type', 'HORSNOYAU');
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
                        AND user.id = :chefDequipeid
                        AND interimaire_has_chantier.doy = :date
                        AND interimaire.actif =1';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantierId',$chantierId, \PDO::PARAM_INT );
        $stmt->bindValue(':chefDequipeid',$chefDequipeid, \PDO::PARAM_INT );
        $stmt->bindValue(':date',$date, \PDO::PARAM_INT );
        if(($stmt->execute()===false)){
            print_r($stmt->errorInfo());
        }else{
            $listInterimaireAffected = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $listInterimaireAffected;
    }

    public static function saveRapportDetailInterimaire($date, $chantier, $matricule, $listInterimaireAffected){

        $sql='SELECT * FROM rapport WHERE date=:date AND chantier=:chantier AND chef_dequipe_matricule=:matricule AND rapport_type=:rapport_type';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':date', $date, \PDO::PARAM_INT);
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
                            `fullname`)
                            VALUES(
                            :rapport_id,
                            :equipe,
                            :interimaire_id,
                            :fullname)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_id',$rapport['id'], \PDO::PARAM_INT);
            $stmt->bindValue(':equipe',$rapport['equipe'], \PDO::PARAM_INT);
            $stmt->bindValue(':interimaire_id',$interimaire['matricule'], \PDO::PARAM_INT);
            $stmt->bindValue(':fullname',$interimaire['lastname'].' '.$interimaire['firstname'], \PDO::PARAM_STR);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }
        }

    }

    public static function getRapportGenerated(){
        $sql='SELECT
                rapport.id as id_rapport, rapport.rapport_type, rapport.date, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 0
                    AND rapport.validated = 0
            GROUP BY rapport.equipe , rapport.chantier , rapport.date
            ORDER BY rapport.date, user.lastname';
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
                rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 0
            GROUP BY rapport.equipe , rapport.chantier , rapport.date
            ORDER BY rapport.date, user.lastname';
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
                rapport.date, rapport.rapport_type, user.id as user_id, user.username, user.firstname, user.lastname, chantier.id as chantier_id, chantier.code, chantier.nom, rapport.submitted, rapport.validated
            FROM
                rapport
            INNER JOIN
                user on user.id = rapport.equipe
            INNER JOIN
                chantier ON chantier.id = rapport.chantier
            WHERE
                rapport.submitted = 1
                    AND rapport.validated = 1
            GROUP BY rapport.equipe , rapport.chantier , rapport.date
            ORDER BY rapport.date, user.lastname';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
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
        $stmt->bindValue(':date',$date,\PDO::PARAM_INT);
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
                ORDER BY rapport_detail.is_chef_dequipe DESC';
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
        $stmt->bindValue(':date',$date,\PDO::PARAM_INT);
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
              ORDER BY rapport_detail.is_chef_dequipe, rapport_detail.ouvrier_id, rapport_detail.interimaire_id';
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
        $stmt->bindValue(':date',$date,\PDO::PARAM_INT);
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
                ORDER BY rapport_detail.is_chef_dequipe, rapport_detail.ouvrier_id, rapport_detail.interimaire_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':rapport_id', $rapport['id'], \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $rapportDetailHorsNoyau= $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $rapportDetailHorsNoyau;
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

    public static function updateRapportDetail($rapportDetailIdList, $htot, $hins, $abs, $habs, $dpl_pers,$km, $remarque, $chef_dequipe_updated,
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
            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $deleteStatus = true;
            }


            $sql = 'UPDATE `rapport_detail`
                    SET
                        `htot` = :htot,
                        `hins` = :hins,
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
            $stmt->bindValue(':ht6', $ht6);
            $stmt->bindValue(':bat_6', $bat6, \PDO::PARAM_INT);
            $stmt->bindValue(':axe_6', $axe6, \PDO::PARAM_INT);
            $stmt->bindValue(':et_6', $et6, \PDO::PARAM_INT);

            $stmt->bindValue(':chef_dequipe_updated', $chef_dequipe_updated, \PDO::PARAM_INT);

            // var_dump($stmt);

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
            $stmt->bindValue(':ht', $ht, \PDO::PARAM_INT);
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
            $stmt->bindValue(':ht2', $ht2, \PDO::PARAM_INT);
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
            $stmt->bindValue(':ht3', $ht3, \PDO::PARAM_INT);
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
            $stmt->bindValue(':ht4', $ht4, \PDO::PARAM_INT);
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
            $stmt->bindValue(':ht5', $ht5, \PDO::PARAM_INT);
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
            $stmt->bindValue(':ht6', $ht6, \PDO::PARAM_INT);
            $stmt->bindValue(':rapportDetailId', $rapportDetail, \PDO::PARAM_INT);

            if($stmt->execute()=== false){
                print_r($stmt->errorInfo());
            }else{
                $insertStatus = true;
            }
        }
    }

    public static function getWorkerNoyauTask($rapport_detail_id){

          //  var_dump($rapport['id']);

            $sql='
                        SELECT
    rapport_detail_has_tache.*,
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
    rapport_detail_has_tache.rapport_detail_id = :rapport_detail_id';

            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':rapport_detail_id', $rapport_detail_id, \PDO::PARAM_INT);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }else{
                $taskList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $taskList;
    }

    public static function getWorkerHorsNoyauTask(){}

    public static function getWorkerAbsentTask(){}
}