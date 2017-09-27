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

    function __construct($id=0, $date=0, $terminal=0, $chantier=null, $equipe=null, $preremp=0, $submitted=0, $validated=0, $deleted=0, $created=0)
    {
        $this->date = $date;
        $this->terminal = $terminal;
        $this->chantier = isset($chantier)? $chantier : new Chantier();;
        $this->equipe = isset($equipe)? $equipe : new User();
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
                              preremp,
                              submitted,
                              validated,
                              deleted
                              )VALUES(
                                :date,
                                :terminal,
                                :chantier,
                                :equipe,
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


}