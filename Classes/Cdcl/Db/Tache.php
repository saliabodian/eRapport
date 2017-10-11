<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:26
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Tache extends DbObject{
    /*----------------Properties------------------*/

    /**
     * @var string
     */
    public $code;
    /**
     * @var string
     */
    public $nom;
    /**
     * @var TypeTache
     */
    protected $typeTache;

    function __construct($id=0, $code='', $nom='', $typeTache=null, $created=0)
    {
        $this->code = $code;
        $this->nom = $nom;
        $this->typeTache = isset($typeTache) ? $typeTache : new TypeTache();
        parent::__construct($id, $created);
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return TypeTache
     */
    public function getTypeTache()
    {
        return $this->typeTache;
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
                    `code`,
                    `nom`,
                    `type_tache_id`,
                    `created`
                FROM `tache`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $tacheObject = new Tache(
                $data['id'],
                $data['code'],
                $data['nom'],
                new TypeTache($data['type_tache_id']),
                $data['created']
            );
        }
        return $tacheObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql=' SELECT * FROM tache
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allTaches = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allTaches as $row) {

                $returnList[$row['id']]['code'] = $row['code'];
                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['type_tache_id'] = $row['type_tache_id'];
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
                `code`,
                `nom`,
                `type_tache_id`
            FROM `tache`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom'];
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
                UPDATE tache
                SET
                `code` = :code,
                `nom` = :nom,
                `type_tache_id`= :type_tache_id
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':code', $this->code);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':type_tache_id', $this->typeTache->getId(), \PDO::PARAM_INT);


            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }
        else {
            $sql = 'INSERT INTO `tache`
                    (`code`,
                    `nom`,
                    `type_tache_id`)
                VALUES
                (:code,
                 :nom,
                 :type_tache_id
            )';

            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':code', $this->code);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':type_tache_id', $this->typeTache->getId(), \PDO::PARAM_INT);


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
                FROM `tache`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            return true;
        }
    }

    public static function getTacheByTypeTache($typeTacheId){
        $sql = "SELECT tache.* FROM tache, type_tache where tache.type_tache_id =:typeTacheId AND tache.type_tache_id=type_tache.id";
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':typeTacheId', $typeTacheId, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $tasks;
    }
}