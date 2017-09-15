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
    public $indicatif;
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
    /**
     * @var bool
     */
    public $actif;

    function __construct($id=0, $nom='',$indicatif=0, $telephone=0, $adresse='', $code_postal='', $ville='', $pays='', $actif=0, $created=0)
    {
        $this->nom = $nom;
        $this->indicatif = $indicatif;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->created = $created;
        $this->actif = $actif;
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
    public function getIndicatif()
    {
        return $this->indicatif;
    }

    /**
     * @param int $indicatif
     */
    public function setIndicatif($indicatif)
    {
        $this->indicatif = $indicatif;
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

    /**
     * @return boolean
     */
    public function isActif()
    {
        return $this->actif;
    }

    /**
     * @param boolean $actif
     */
    public function setActif($actif)
    {
        $this->actif = $actif;
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
                `indicatif` = :indicatif,
                `telephone` = :telephone,
                `adresse` = :adresse,
                `code_postal` = :code_postal,
                `ville` = :ville,
                `pays` = :pays,
                `actif` = :actif
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':indicatif', $this->indicatif, \PDO::PARAM_INT);
            $stmt->bindValue(':telephone', $this->telephone, \PDO::PARAM_INT);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':code_postal', $this->code_postal);
            $stmt->bindValue(':ville', $this->ville);
            $stmt->bindValue(':pays', $this->pays);
            $stmt->bindValue(':actif', $this->actif);

            var_dump($stmt);

            //exit;

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
                    `indicatif`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`,
                    `actif`)
                VALUES
                (:nom,
                 :indicatif,
                 :telephone,
                 :adresse,
                 :code_postal,
                 :ville,
                 :pays,
                 :actif
            )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':nom', $this->nom);
            $stmt->bindValue(':indicatif', $this->indicatif, \PDO::PARAM_INT);
            $stmt->bindValue(':telephone', $this->telephone, \PDO::PARAM_INT);
            $stmt->bindValue(':adresse', $this->adresse);
            $stmt->bindValue(':code_postal', $this->code_postal);
            $stmt->bindValue(':ville', $this->ville);
            $stmt->bindValue(':pays', $this->pays);
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

    public function getAgenceById($id){
        $sql = '
                SELECT `id`,
                    `nom`,
                    `indicatif`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`,
                    `actif`
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
            $agenceObject = new User(
                $data['id'],
                $data['nom'],
                $data['indicatif'],
                $data['telephone'],
                $data['adresse'],
                $data['code_postal'],
                $data['ville'],
                $data['pays'],
                $data['actif']
            );
        }
        return $agenceObject ;
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
                    `indicatif`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`,
                    `actif`
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
                $data['indicatif'],
                $data['telephone'],
                $data['adresse'],
                $data['code_postal'],
                $data['ville'],
                $data['pays'],
                $data['actif']
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
                $returnList[$row['id']]['indicatif'] = $row['indicatif'];
                $returnList[$row['id']]['telephone'] = $row['telephone'];
                $returnList[$row['id']]['adresse'] = $row['adresse'];
                $returnList[$row['id']]['code_postal'] = $row['code_postal'];
                $returnList[$row['id']]['ville'] = $row['ville'];
                $returnList[$row['id']]['pays'] = $row['pays'];
                $returnList[$row['id']]['actif'] = $row['actif'];
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
                `agence`.`indicatif`,
                `agence`.`telephone`,
                `agence`.`adresse`,
                `agence`.`code_postal`,
                `agence`.`ville`,
                `agence`.`pays`,
                `agence`.`actif`
            FROM `agence`
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

    public static function getAllForSelect2(){
        $sql = '
            SELECT
                `agence`.`id`,
                `agence`.`nom`,
                `agence`.`indicatif`,
                `agence`.`telephone`,
                `agence`.`adresse`,
                `agence`.`code_postal`,
                `agence`.`ville`,
                `agence`.`pays`,
                `agence`.`actif`
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
                $returnList[$row['id']]['indicatif'] = $row['indicatif'];
                $returnList[$row['id']]['telephone'] = $row['telephone'];
                $returnList[$row['id']]['ville'] = $row['ville'];
                $returnList[$row['id']]['pays'] = $row['pays'];
                $returnList[$row['id']]['actif'] = $row['actif'];
            }
        }
        return $returnList;
    }

    public function agenceCreate(){
        $sql = 'INSERT INTO `agence`
                    (`nom`,
                    `indicatif`,
                    `telephone`,
                    `adresse`,
                    `code_postal`,
                    `ville`,
                    `pays`,
                    `actif`)
                VALUES
                (:nom,
                 :indicatif,
                 :telephone,
                 :adresse,
                 :code_postal,
                 :ville,
                 :pays,
                 :actif
            )';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':nom', $this->nom);
        $stmt->bindValue(':indicatif', $this->indicatif, \PDO::PARAM_INT);
        $stmt->bindValue(':telephone', $this->telephone, \PDO::PARAM_INT);
        $stmt->bindValue(':adresse', $this->adresse);
        $stmt->bindValue(':code_postal', $this->code_postal);
        $stmt->bindValue(':ville', $this->ville);
        $stmt->bindValue(':pays', $this->pays);
        $stmt->bindValue(':actif', $this->actif);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
            return false;
        } else {
            return true;
        }
    }


}