<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:25
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class TypeTache extends DbObject{
    /*----------------Properties------------------*/
    /*
    `type_tache`.`nom_type_tache`,
    `type_tache`.`code_type_tache`
     */
    /**
     * @var string
     */
    public $nom_type_tache;
    /**
     * @var string
     */
    public $code_type_tache;

    function __construct($id=0, $nom_type_tache='', $code_type_tache='', $created=0)
    {
        $this->nom_type_tache = $nom_type_tache;
        $this->code_type_tache = $code_type_tache;
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getNomTypeTache()
    {
        return $this->nom_type_tache;
    }

    /**
     * @return string
     */
    public function getCodeTypeTache()
    {
        return $this->code_type_tache;
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
                    `nom_type_tache`,
                    `code_type_tache`,
                    `created`
                FROM `type_tache`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $typeTacheObject = new TypeTache(
                $data['id'],
                $data['nom_type_tache'],
                $data['code_type_tache'],
                $data['created']
            );
        }
        return $typeTacheObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql=' SELECT * FROM type_tache
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allTypeTaches = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allTypeTaches as $row) {

                $returnList[$row['id']]['id'] = $row['id'];
                $returnList[$row['id']]['nom_type_tache'] = $row['nom_type_tache'];
                $returnList[$row['id']]['code_type_tache'] = $row['code_type_tache'];
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
                `nom_type_tache`,
                `code_type_tache`
            FROM `type_tache`
            ORDER BY `nom_type_tache`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom_type_tache'];
            }
        }

        return $returnList;
    }

    public static function getAllForSelect2(){
        $sql = '
            SELECT
                `id`,
                `code_type_tache`,
                `nom_type_tache`
            FROM `type_tache`
            ORDER BY `nom_type_tache`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']]['code_type_tache'] = $row['code_type_tache'];
                $returnList[$row['id']]['nom_type_tache'] = $row['nom_type_tache'];
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
                UPDATE type_tache
                SET
                `nom_type_tache` = :nom_type_tache,
                `code_type_tache` = :code_type_tache
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':nom_type_tache', $this->nom_type_tache);
            $stmt->bindValue(':code_type_tache', $this->code_type_tache);

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
            $sql = 'INSERT INTO `type_tache`
                    (`nom_type_tache`,
                    `code_type_tache`)
                VALUES
                (:nom_type_tache,
                 :code_type_tache
            )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom_type_tache', $this->nom_type_tache);
            $stmt->bindValue(':code_type_tache', $this->code_type_tache);

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
                FROM `type_tache`
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