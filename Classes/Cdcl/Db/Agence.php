<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 25/08/2017
 * Time: 13:25
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;


class Agence {
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

    function __construct($nom='', $telephone=0, $adresse='', $code_postal='', $ville='', $pays='', $created=0)
    {
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->created = $created;
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
        return $data ;
    }

    public static function getAllAgence(){
        $sql=' SELECT * FROM agence
        ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allUsers = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allUsers as $row) {

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

    public function deleteAgence($id){
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
            $isDeleted = true;
        }
        return $isDeleted ;
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