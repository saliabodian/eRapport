<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 12.11.2018
 * Time: 10:35
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

class Batiment extends DbObject{

    /**
     * @var string
     */
    public $nom;

    /**
     * @var integer
     */
    public $chantierId;


    function __construct($id=0, $nom='', $chantierId=null, $created=0)
    {
        $this->nom = $nom;
        $this->chantierId = isset($chantierId)? $chantierId: new Chantier();
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
     * @return integer
     */
    public function getChantierId()
    {
        return $this->chantierId;
    }

    /**
     * @param int $id
     * @return DbObject
     * @throws InvalidSqlQueryException
     */
    public static function get($id)
    {
        $sql='
                 SELECT `id`,
                `nom`,
                `chantier_id`,
                `created`
                FROM batiment where id= :id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $batimentObject = new Batiment(
                $data['id'],
                $data['nom'],
                new Chantier($data['chantier_id']),
                $data['created']
            );
        }
        return $batimentObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
        $sql = 'SELECT * FROM batiment';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allBatiments = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allBatiments as $row) {

                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['chantier_id'] = $row['chantier_id'];
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
                `nom`
            FROM `batiment` ORDER BY `created`
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

        $returnList = isset($returnList) ? $returnList : '';
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
                UPDATE batiment
                SET
                `nom` = :nom,
                `chantier_id`= :chantier_id
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':chantier_id', $this->chantierId->getId(), \PDO::PARAM_INT);

            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }

        }else{
            $sql='
                INSERT INTO `batiment`
                    (`nom`,
                    `chantier_id`)
                VALUES(
                  :nom,
                  :chantier_id
              )';


            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':chantier_id', $this->chantierId->getId(), \PDO::PARAM_INT);



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
        $sql = " delete FROM batiment where id=:id ";

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(":id", $id, \PDO::PARAM_INT);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return true;
        }
    }

    public function batimentCheck($chantierId, $nom){
        $sql = 'SELECT count(id) FROM batiment WHERE nom like :nom AND chantier_id=:chantier_id ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier_id', $chantierId);
        $stmt->bindValue(':nom', '%'.$nom.'%');

        if($stmt->execute() === false){
            print_r($stmt->errorInfo());
        }else{
            if( $stmt->fetch() <= 0 ){
                return true;
            } else{
                return false ;
            }
        }

    }

    public function getBatiment($chantierId, $dateDebut, $dateFin){

        $sql = 'SELECT
                batiment.id,
                batiment.nom
            FROM
                rapport_detail_has_tache,
                rapport_detail,
                rapport,
                chantier,
                batiment
            WHERE
                rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                    AND rapport_detail.rapport_id = rapport.id
                    AND rapport.chantier = chantier.id
                    AND batiment.chantier_id = chantier.id
                    AND chantier.id = :chantier_id
                    AND rapport.date BETWEEN :dateDeb AND :dateFin
            GROUP BY batiment.id';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier_id', $chantierId);
        $stmt->bindValue(':dateDeb', $dateDebut);
        $stmt->bindValue(':dateFin', $dateFin);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return $rst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function getBatimentBis($chantierId,$dateDebut,$dateFin){
        $sql = 'SELECT
                    rapport_detail_has_tache.batiment
                FROM
                    rapport_detail_has_tache,
                    rapport_detail,
                    rapport,
                    chantier
                WHERE
                    rapport_detail_has_tache.rapport_detail_id = rapport_detail.id
                        AND rapport_detail.rapport_id = rapport.id
                        AND rapport.chantier = chantier.id
                        AND chantier.id = :chantier_id
                        AND rapport.date BETWEEN :dateDeb AND :dateFin
                        AND ( rapport_detail_has_tache.batiment <> "")
                GROUP BY rapport_detail_has_tache.batiment';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier_id', $chantierId);
        $stmt->bindValue(':dateDeb', $dateDebut);
        $stmt->bindValue(':dateFin', $dateFin);

        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }else{
            return $rst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }
}