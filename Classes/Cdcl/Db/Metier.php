<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:25
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Metier extends DbObject{
    /*----------------Properties------------------*/
    /*
    `metier`.`code_metier`,
    `metier`.`nom_metier`,
     */
    /**
     * @var string
     */
    public $code_metier;
    /**
     * @var string
     */
    public $nom_metier;

    function __construct($id=0, $code_metier='', $nom_metier='',$created=0)
    {
        $this->code_metier = $code_metier;
        $this->nom_metier = $nom_metier;
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getCodeMetier()
    {
        return $this->code_metier;
    }

    /**
     * @return string
     */
    public function getNomMetier()
    {
        return $this->nom_metier;
    }



    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql = '
                SELECT
                    `id`,
                    `code_metier`,
                    `nom_metier`
                FROM `metier`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $metierObject = new Metier(
                $data['id'],
                $data['code_metier'],
                $data['nom_metier']            );
        }
        return $metierObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql=' SELECT * FROM metier
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allMetiers = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($metierObject as $row) {

                $returnList[$row['id']]['code_metier'] = $row['code_metier'];
                $returnList[$row['id']]['nom_metier'] = $row['nom_metier'];
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
                `code_metier`,
                `nom_metier`
            FROM `metier`
            ORDER BY `nom_metier`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom_metier'];
            }
        }

        return $returnList;
    }

    public static function getAllForSelect2(){
        $sql = '
            SELECT
                `id`,
                `code_metier`,
                `nom_metier`
            FROM `metier`
            ORDER BY `nom_metier`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']]['code_metier'] = $row['code_metier'];
                $returnList[$row['id']]['nom_metier'] = $row['nom_metier'];
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
                UPDATE metier
                SET
                `code_metier` = :code_metier,
                `nom_metier` = :nom_metier
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':code_metier', $this->code_metier);
            $stmt->bindValue(':nom_metier', $this->nom_metier);

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
            $sql = 'INSERT INTO `metier`
                    (`code_metier`,
                    `nom_metier`)
                VALUES
                (:code_metier,
                 :nom_metier
            )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':code_metier', $this->code_metier);
            $stmt->bindValue(':nom_metier', $this->nom_metier);

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
                FROM `metier`
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