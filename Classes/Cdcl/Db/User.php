<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 21/08/2017
 * Time: 14:15
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

Class User extends DbObject{

    /*----------------Properties------------------*/

    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $firstname;
    /**
     * @var string
     */
    public $lastname;
    /**
     * @var string
     */
    public $email;
    /**
     * @var int
     */
    public $registration_number;
    /**
     * @var int
     */
    public $password;
    /**
     * @var Post
     */
    public $post_id;

    // Constructeur pour la classe User
    function __construct($id=0, $username='', $firstname='', $lastname='', $email='', $registration_number=0,  $password='', $post_id=null, $created=0)
    {
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->registration_number = $registration_number;
        $this->password = $password;
        $this->post_id = isset($post_id)? $post_id: new Post();
        parent::__construct($id, $created);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getRegistrationNumber()
    {
        return $this->registration_number;
    }

    /**
     * @return int
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return Post
     */
    public function getPostId()
    {
        return $this->post_id;
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
                `username`,
                `firstname`,
                `lastname`,
                `email`,
                `registration_number`,
                `created`,
                `password`,
                `post_id`
                FROM user where id= :id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $data = $stmt->fetch() ;
            $userObject = new User(
                $data['id'],
                $data['username'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['registration_number'],
                $data['password'],
                new Post($data['post_id']),
                $data['created']
            );
        }
        return $userObject ;
    }

    /**
     * @return DbObject[]
     * @throws InvalidSqlQueryException
     */
    public static function getAll()
    {
       $sql = 'SELECT * FROM user';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $allUsers = $pdoStmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allUsers as $row) {

                $returnList[$row['id']]['username'] = $row['username'];
                $returnList[$row['id']]['firstname'] = $row['firstname'];
                $returnList[$row['id']]['lastname'] = $row['lastname'];
                $returnList[$row['id']]['email'] = $row['email'];
                $returnList[$row['id']]['registration_number'] = $row['registration_number'];
                $returnList[$row['id']]['password'] = $row['password'];
                $returnList[$row['id']]['post_id'] = $row['post_id'];
                $returnList[$row['id']]['lastname'] = $row['lastname'];
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
                `username`,
                `firstname`,
                `lastname`,
                `email`
            FROM `user` ORDER BY `lastname`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['lastname'].' '.$row['firstname'];
            }
        }
        return $returnList;
    }

    public static function getAllForSelectChefDEquipe()
    {
        $sql = '
            SELECT
                `id`,
                `username`,
                `firstname`,
                `lastname`,
                `email`
            FROM `user`
            WHERE post_id = 1
            ORDER BY `lastname`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['username'].' '.$row['firstname'].' '.$row['lastname'];
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
                UPDATE user
                SET
                `username` = :username,
                `firstname` = :firstname,
                `lastname`= :lastname,
                `email`= :email,
                `registration_number`= :registration_number,
                `password`= :password,
                `post_id`= :post_id
                WHERE `id` = :id
                ';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':id', $this->id, \PDO::PARAM_INT);
            $stmt->bindValue(':username', $this->username);
            $stmt->bindValue(':firstname', $this->firstname);
            $stmt->bindValue(':lastname', $this->lastname);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':registration_number', $this->registration_number);
            $stmt->bindValue(':password', md5($this->password));
            $stmt->bindValue(':post_id', $this->post_id->getId(), \PDO::PARAM_INT);

            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
                return false ;
            }
            else {
                return true ;
            }

        }else{
            $sql='
                INSERT INTO `user`
                    (`username`,
                    `firstname`,
                    `lastname`,
                    `email`,
                    `registration_number`,
                    `password`,
                    `post_id`)
                VALUES(
                  :username,
                  :firstname,
                  :lastname,
                  :email,
                  :registration_number,
                  :password,
                  :post_id
              )';


            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':username', $this->username);
            $stmt->bindValue(':firstname', $this->firstname);
            $stmt->bindValue(':lastname', $this->lastname);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':registration_number', $this->registration_number);
            $stmt->bindValue(':password', md5($this->password));
            $stmt->bindValue(':post_id', $this->post_id->getId(), \PDO::PARAM_INT);



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
        $sql = '
        DELETE FROM user WHERE id= :id';

        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            return true;
        }
    }


    // Fonction pour récupérer un user par son username
    public static function getByUsername($username){

        $sql = '
                SELECT
                        id,
                        username,
                        firstname,
                        lastname,
                        email,
                        registration_number,
                        created,
                        password,
                        post_id
                    FROM
                        user
                where user.username= :username
                ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        $pdoStmt->bindValue(':username', $username, \PDO::PARAM_INT);

        if ($pdoStmt->execute() === false) {
            print_r($pdoStmt->errorInfo());
        }
        else {
            $data = $pdoStmt->fetch() ;
            $userObject = new User(
                $data['id'],
                $data['username'],
                $data['firstname'],
                $data['lastname'],
                $data['email'],
                $data['registration_number'],
                $data['created'],
                $data['password'],
                $data['post_id']
            );
        }
        return $data ;
    }

    // Fonction de connexion et de gestion des sessions
    public static function loginPost(){
        // Get the config object

        $conf = Config::getInstance();
        $formOk = true;
        if(!empty($_POST)){
            //var_dump($_POST);
            $login = isset($_POST['login']) ? $_POST['login'] : '';
            //var_dump($_POST['login']);
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            //
            $formOk = true;

            if(empty($login)){
                $conf->addError('Veuillez renseigner le login');
                $formOk = false;
            }else{
                if(empty($password)){
                    $conf->addError('Veuillez renseigner le mot de passe');
                    $formOk = false;
                }else{
                    $sql='SELECT * FROM user WHERE username= :username AND password= :password';

                    $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
                    $pdoStmt->bindValue(':password', md5($password));
                    $pdoStmt->bindValue(':username', $login);

                    if ($pdoStmt->execute() === false) {
                        print_r($pdoStmt->errorInfo());
                    }
                    else {
                        $passwordExist = $pdoStmt->rowCount();
                    }
                }
            }



            //var_dump($loginExist);

           // var_dump($passwordExist);
            if($passwordExist>0){
                $formOk = true;
            }else{
                $formOk = false;
                $conf->addError('Login ou mot de passe invalide !');
            }
           // var_dump($formOk);
            if($formOk===true){
                session_start();
                $user = new User();
                $userSessionValues = $user->getByUsername($login);


            //($id=0, $username='', $firstname='', $lastname='', $email='', $registration_number=0, $created='', $password='', $post_id=0)

            //   var_dump($userSessionValues);
                $_SESSION['id']=$userSessionValues['id'];
                $_SESSION['username']=$userSessionValues['username'];
                $_SESSION['lastname']=$userSessionValues['lastname'];
                $_SESSION['firstname']=$userSessionValues['firstname'];
                $_SESSION['email']=$userSessionValues['email'];
                $_SESSION['post_id']=$userSessionValues['post_id'];
            //    var_dump($_SESSION);
                header('Location:home.php');
            }
        }
        return $formOk;
    }

    function userHasChantierSaveDb($user_id, $chantiers){
        $sql='DELETE FROM chantier_has_user WHERE user_id= :user_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }

        foreach($chantiers as $chantier_id){
            $sql= 'INSERT INTO `chantier_has_user`
                (`chantier_id`,
                `user_id`)
                VALUES(
                :chantier_id,
                :user_id
                )';
            $stmt = Config::getInstance()->getPDO()->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
            if ($stmt->execute() === false) {
                print_r($stmt->errorInfo());
            }
        }
    }

    public static function listChantierByUser($user_id){
        $sql='SELECT chantier_id FROM chantier_has_user WHERE user_id= :user_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $listChantiers = $stmt->fetchAll(\PDO::FETCH_ASSOC); ;
            return $listChantiers;
        }
    }

    public static function listChantierByUserForSelect($user_id){
        $sql='SELECT chantier_has_user.chantier_id, chantier.id, chantier.nom, chantier.code FROM chantier_has_user
              INNER JOIN
              chantier ON chantier.id = chantier_has_user.chantier_id
              WHERE user_id= :user_id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $listChantiers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($listChantiers as $row) {
                $returnList[$row['id']] = $row['code'].' '.$row['nom'];
            }
            return $returnList;
        }
    }

    public static function getAllForSelectChefDEquipebyChantier($chantier_id)
    {
        $sql = '
            SELECT
                `user`.`id`,
                `user`.`username`,
                `user`.`firstname`,
                `user`.`lastname`,
                `user`.`email`
            FROM `user` INNER JOIN
            chantier_has_user ON chantier_has_user.user_id = user.id
            WHERE post_id = 1
            AND chantier_has_user.chantier_id = :chantier_id
            ORDER BY `lastname`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['username'].' '.$row['firstname'].' '.$row['lastname'];
            }
        }
        return $returnList;
    }

    public static function getChefDEquipeForSelectbyChantier($chantier_id, $user_id)
    {
        $sql = '
            SELECT
                `user`.`id`,
                `user`.`username`,
                `user`.`firstname`,
                `user`.`lastname`,
                `user`.`email`
            FROM `user` INNER JOIN
            chantier_has_user ON chantier_has_user.user_id = user.id
            WHERE post_id = 1
            AND chantier_has_user.chantier_id = :chantier_id
            AND user.id = :user_id
            ORDER BY `lastname`
            ';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':chantier_id', $chantier_id, \PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        if ($stmt->execute() === false) {
            print_r($stmt->errorInfo());
        }
        else {
            $allDatas = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($allDatas as $row) {
                $returnList[$row['id']] = $row['username'].' '.$row['firstname'].' '.$row['lastname'];
            }
        }
        return $returnList;
    }


}