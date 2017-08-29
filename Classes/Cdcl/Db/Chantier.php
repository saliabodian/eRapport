<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:25
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Chantier extends DbObject{
    /*----------------Properties------------------*/
    /**
     * @var int
     * code`,
    `chantier`.`nom`,
    `chantier`.`adresse`,
    `chantier`.`adresse_fac`,
    `chantier`.`date`,
    `chantier`.`actif`,
     */
    /**
     * @var string
     */
    public $nom;
    /**
     * @var int
     */
    public $code;
    /**
     * @var string
     */
    public $adresse;
    /**
     * @var string
     */
    public $adresse_fac;
    /**
     * @var int
     */
    public $date_exec;
    /**
     * @var bool
     */
    public $actif;

    function __construct($id=0, $nom='',$code=0, $adresse='', $adresse_fac='', $date_exec=0, $actif=0, $created=0)
    {
        $this->nom = $nom;
        $this->code = $code;
        $this->adresse = $adresse;
        $this->adresse_fac = $adresse_fac;
        $this->date_exec = $date_exec;
        $this->actif = $actif;
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @return string
     */
    public function getAdresseFac()
    {
        return $this->adresse_fac;
    }

    /**
     * @return int
     */
    public function getDate_exec()
    {
        return $this->date_exec;
    }

    /**
     * @return boolean
     */
    public function isActif()
    {
        return $this->actif;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql = '
                SELECT `id`,
                    `nom`,
                    `code`,
                    `adresse`,
                    `adresse_fac`,
                    `date_exec`,
                    `actif`
                FROM `chantier`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $chantierObject = new Chantier(
                $data['id'],
                $data['nom'],
                $data['code'],
                $data['adresse'],
                $data['adresse_fac'],
                $data['date_exec'],
                $data['actif']
            );
        }
        return $chantierObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql=' SELECT * FROM chantier
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allChantiers = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allChantiers as $row) {

                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['code'] = $row['code'];
                $returnList[$row['id']]['adresse'] = $row['adresse'];
                $returnList[$row['id']]['adresse_fac'] = $row['adresse_fac'];
                $returnList[$row['id']]['date_exec'] = $row['date_exec'];
                $returnList[$row['id']]['actif'] = $row['actif'];
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
                `nom`,
                `code`,
                `adresse`,
                `adresse_fac`,
                `date_exec`,
                `actif`
            FROM `chantier`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom'].' '.$row['code'].' '.$row['adresse'];
            }
        }

        return $returnList;
    }

    public static function getAllForSelect2(){
        $sql = '
            SELECT
                `id`,
                `nom`,
                `code`,
                `adresse`,
                `adresse_fac`,
                `date_exec`,
                `actif`
            FROM `chantier`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['code'] = $row['code'];
                $returnList[$row['id']]['adresse'] = $row['adresse'];
                $returnList[$row['id']]['adresse_fac'] = $row['adresse_fac'];
                $returnList[$row['id']]['date_exec'] = $row['date_exec'];
                $returnList[$row['id']]['actif'] = $row['actif'];
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
     //       var_dump($this->id);

        if ($this->id > 0){
            $sql = '
                UPDATE chantier
                SET
                `nom` = :nom,
                `code` = :code,
                `adresse` = :adresse,
                `adresse_fac` = :adresse_fac,
                `date_exec` = :date_exec,
                `actif` = :actif
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':code', $this->code, \PDO::PARAM_INT);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':adresse_fac', $this->adresse_fac);
            $stmt->bindValue(':date_exec', $this->date_exec);
            $stmt->bindValue(':actif', $this->actif);

            //var_dump($sql);

            // exit;
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }

        else {
            $sql = 'INSERT INTO `chantier`
                    (`nom`,
                    `code`,
                    `adresse`,
                    `adresse_fac`,
                    `date_exec`,
                    `actif`)
                VALUES
                (:nom,
                 :code,
                 :adresse,
                 :adresse_fac,
                 :date_exec,
                 :actif
            )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':code', $this->code, \PDO::PARAM_INT);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':adresse_fac', $this->adresse_fac);
            $stmt->bindValue(':date_exec', $this->date_exec);
            $stmt->bindValue(':actif', $this->actif);

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
        $sql = '
                DELETE
                FROM `chantier`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
            $isDeleted = false;
        }
        else {
            return true;
        }
    }


}