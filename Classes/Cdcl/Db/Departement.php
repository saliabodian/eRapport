<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 15/09/2017
 * Time: 17:18
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

class Departement extends DbObject{

    /**@var string*/
    public $code_dpt;

    /**@var string*/
    public $nom_dpt;

    function __construct($id=0, $code_dpt='', $nom_dpt='', $created=0)
    {
        $this->code_dpt = $code_dpt;
        $this->nom_dpt = $nom_dpt;
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getCodeDpt()
    {
        return $this->code_dpt;
    }

    /**
     * @return string
     */
    public function getNomDpt()
    {
        return $this->nom_dpt;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql = '
        SELECT id,
        code_dpt,
        nom_dpt,
        created
        FROM departement
        WHERE id= :id';

        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch();
            $departementObject = new Departement(
                $data['id'],
                $data['code_dpt'],
                $data['nom_dpt'],
                $data['created']
            );
        }
        return $departementObject;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql='SELECT id, code_dpt, nom_dpt, created FROM departement';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDepartement = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDepartement as $row) {
                $returnList[$row['id']]['code_dpt'] = $row['code_dpt'];
                $returnList[$row['id']]['nom_dpt'] = $row['nom_dpt'];
                $returnList[$row['id']]['created'] = $row['created'];
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
        $sql='SELECT id, code_dpt, nom_dpt, created FROM departement ORDER BY nom_dpt';
        $stmt= Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom_dpt'];
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
            $sql='UPDATE departement
            SET code_dpt= :code_dpt,
                nom_dpt= :nom_dpt
            WHERE id = :id';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->bindValue(':code_dpt', $this->code_dpt);
            $stmt->bindValue(':nom_dpt', $this->nom_dpt);
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }else{
            $sql='INSERT INTO departement (code_dpt, nom_dpt)
                  VALUES (:code_dpt, :nom_dpt)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':code_dpt', $this->code_dpt);
            $stmt->bindValue(':nom_dpt', $this->nom_dpt);
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
        $sql='DELETE FROM departement WHERE id=:id';
        $stmt=Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }else{
            return true;
        }
    }


}