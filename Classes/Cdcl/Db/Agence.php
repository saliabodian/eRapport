<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:25
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Agence extends DbObject{
    /*----------------Properties------------------*/

    /**
     * @var string
     */
    public $nom;
    /**
     * @var int
     */
    public $telephone;
    /**
     * @var string
     */
    public $adresse;
    /**
     * @var string
     */
    public $code_postal;
    /**
     * @var string
     */
    public $ville;
    /**
     * @var timestamp
     */
    public $created;
    /**
     * @var int
     */
    public $pays;

    function __construct($id=0, $nom='', $telephone=0, $adresse='', $code_postal='', $ville='', $pays='', $created=0)
    {
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->created = $created;
        //parent constructeur
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
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param int $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * @param string $code_postal
     */
    public function setCodePostal($code_postal)
    {
        $this->code_postal = $code_postal;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return timestamp
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param timestamp $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return int
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param int $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /* return bool*/
    public function saveDB(){
    //    var_dump($this->id);
    //    exit;
        if ($this->id > 0){
            $sql = '
                UPDATE agence
                SET
                `nom` = :nom,
                `telephone` = :telephone,
                `adresse` = :adresse,
                `code_postal` = :code_postal,
                `ville` = :ville,
                `pays` = :pays
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':telephone', $this->telephone);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':code_postal', $this->code_postal);
            $stmt->bindValue(':ville', $this->ville);
            $stmt->bindValue(':pays', $this->pays);

            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }
        }

        else {
            $sql = 'INSERT INTO `agence`
                    (`nom`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`)
                VALUES
                (:nom,
                 :telephone,
                 :adresse,
                 :code_postal,
                 :ville,
                 :pays
            )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':telephone', $this->telephone, \PDO::PARAM_INT);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':code_postal', $this->code_postal);
            $stmt->bindValue(':ville', $this->ville);
            $stmt->bindValue(':pays', $this->pays);

            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false;
            }
            else {
                return true;
            }
        }
    }

    public function getAgenceById($id){
        $sql = '
                SELECT `id`,
                    `nom`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`
                FROM `agence`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $userObject = new User(
                $data['id'],
                $data['nom'],
                $data['telephone'],
                $data['adresse'],
                $data['code_postal'],
                $data['ville'],
                $data['pays']
            );
        }
        return $userObject ;
    }



    public static function deleteById($id){
        $sql = '
                DELETE
                FROM `agence`
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

    public static function get($id){

        $sql = '
                SELECT `id`,
                    `nom`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`
                FROM `agence`
                where id= :id
                ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $agenceObject = new Agence(
                $data['id'],
                $data['nom'],
                $data['telephone'],
                $data['adresse'],
                $data['code_postal'],
                $data['ville'],
                $data['pays']
            );
        }
        return $agenceObject ;
    }


    /* return DbObject[]*/
    public static function getAll(){
        $sql=' SELECT * FROM agence
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allAgences = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allAgences as $row) {

                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['telephone'] = $row['telephone'];
                $returnList[$row['id']]['adresse'] = $row['adresse'];
                $returnList[$row['id']]['code_postal'] = $row['code_postal'];
                $returnList[$row['id']]['ville'] = $row['ville'];
                $returnList[$row['id']]['pays'] = $row['pays'];
            }
        }
        return $returnList;
    }
    /*return array */
    public static function getAllForSelect(){
        $sql = '
            SELECT
                `agence`.`id`,
                `agence`.`nom`,
                `agence`.`telephone`,
                `agence`.`adresse`,
                `agence`.`code_postal`,
                `agence`.`ville`,
                `agence`.`pays`
            FROM `agence`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['nom'].' '.$row['ville'].' '.$row['pays'];
            }
        }

        return $returnList;
    }

    public static function getAllForSelect2(){
        $sql = '
            SELECT
                `agence`.`id`,
                `agence`.`nom`,
                `agence`.`telephone`,
                `agence`.`adresse`,
                `agence`.`code_postal`,
                `agence`.`ville`,
                `agence`.`pays`
            FROM `agence`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']]['nom'] = $row['nom'];
                $returnList[$row['id']]['adresse'] = $row['adresse'];
                $returnList[$row['id']]['code_postal'] = $row['code_postal'];
                $returnList[$row['id']]['telephone'] = $row['telephone'];
                $returnList[$row['id']]['ville'] = $row['ville'];
                $returnList[$row['id']]['pays'] = $row['pays'];
            }
        }
        return $returnList;
    }

    public function agenceCreate(){
        $sql = 'INSERT INTO `agence`
                    (`nom`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`)
                VALUES
                (:nom,
                 :telephone,
                 :adresse,
                 :code_postal,
                 :ville,
                 :pays
            )';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':nom', $this->nom);
        $stmt->bindValue(':telephone', $this->telephone, \PDO::PARAM_INT);
        $stmt->bindValue(':adresse', $this->adresse);
        $stmt->bindValue(':code_postal', $this->code_postal);
        $stmt->bindValue(':ville', $this->ville);
        $stmt->bindValue(':pays', $this->pays);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
            return false;
        } else {
            return true;
        }
    }


}