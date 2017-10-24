<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 15/09/2017
 * Time: 17:18
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Qualification extends DbObject{

    /**@var string*/
    public $nom_qualif;

    function __construct($id=0, $nom_qualif='', $created=0)
    {
        $this->nom_qualif = $nom_qualif;
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getNomQualif()
    {
        return $this->nom_qualif;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql = 'SELECT id, nom_qualif, created FROM qualification WHERE id=:id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $data = $stmt->fetch();
            $quailficationObject= new Qualification(
                $data['id'],
                $data['nom_qualif'],
                $data['created']
            );
        }
        return $quailficationObject;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql = 'SELECT id, nom_qualif, created FROM qualification';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $allQualification = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach($allQualification as $row){
                $returnList[$row['id']]['nom_qualif'] = $row['nom_qualif'];
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
        $sql = 'SELECT id, nom_qualif, created FROM qualification ORDER BY nom_qualif';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            $allQualification = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach($allQualification as $row){
                $returnList[$row['id']]=$row['nom_qualif'];
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
        if($this->id > 0){
            $sql='UPDATE qualification SET nom_qualif= :nom_qualif WHERE id=:id';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id , \PDO::PARAM_INT);
            $stmt->bindValue(':nom_qualif', $this->nom_qualif);
            if($stmt->execute() === false){
                print_r($stmt->errorInfo());
            }else{
                return true;
            }
        }else{
            $sql = 'INSERT INTO qualification (nom_qualif) VALUE (:nom_qualif)';
            $stmt=Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom_qualif', $this->nom_qualif);
            if($stmt->execute()===false){
                print_r($stmt->errorInfo());
            }else{
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
        $sql='DELETE FROM qualification WHERE id=:id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()=== false){
            print_r($stmt->errorInfo());
        }else{
            return true;
        }
    }


}