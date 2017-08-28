<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 21/08/2017
 * Time: 14:15
 */

namespace Classes\Cdcl\Db;

use Classes\Cdcl\Config\Config;

Class User {

    /*----------------Properties------------------*/
    /**
     * @var int
     */
    public $id;
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
     * @var timestamp
     */
    public $created;
    /**
     * @var int
     */
    public $password;
    /**
     * @var int
     */
    public $post_id;

    // Constructeur pour la classe User
    function __construct($id=0, $username='', $firstname='', $lastname='', $email='', $registration_number=0, $created='', $password='', $post_id=0)
    {
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->registration_number = $registration_number;
        $this->created = $created;
        $this->password = $password;
        $this->post_id = $post_id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getRegistrationNumber()
    {
        return $this->registration_number;
    }

    /**
     * @param int $registration_number
     */
    public function setRegistrationNumber($registration_number)
    {
        $this->registration_number = $registration_number;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param int $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }



    // Fonction pour récupérer un user par son user
    public static function get($id){
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
                where user.id= :id
                ';
        $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
        $pdoStmt->bindValue(':id', $id, \PDO::PARAM_INT);

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

    // Fonction pour récupérer tous les user
    public static function getAllUser(){
        $sql=' SELECT * FROM user
        ';
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
                $returnList[$row['id']]['password'] = $row['password'];
                $returnList[$row['id']]['registration_number'] = $row['registration_number'];
                $returnList[$row['id']]['post_id'] = $row['post_id'];
            }
        }
        return $returnList;
    }

    // Fonction
    public function loginPost(){
        // Get the config object
        $conf = Config::getInstance();
        if(!empty($_POST)){
            //var_dump($_POST);
            $login = isset($_POST['login']) ? $_POST['login'] : '';
            //var_dump($_POST['login']);
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            //var_dump($_POST['password']);
            $ok = true;
            if(empty($login)){
                $conf->addError('Veuillez renseigner le login');
                $ok = false;
            }else{

                $sql='SELECT * FROM user WHERE username= :username';

                //var_dump($errorList);
                //var_dump($ok);
                $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
                $pdoStmt->bindValue(':username', $login);

                if ($pdoStmt->execute() === false) {
                    print_r($pdoStmt->errorInfo());
                }
                else {
                    $loginExist = $pdoStmt->rowCount();
                }
            }

            if(empty($password)){
                $conf->addError('Veuillez renseigner le mot de passe');
                $ok = false;
            }else{
                $sql='SELECT * FROM user WHERE password= :password';

                $pdoStmt = Config::getInstance()->getPDO()->prepare($sql);
                $pdoStmt->bindValue(':password', md5($password));

                if ($pdoStmt->execute() === false) {
                    print_r($pdoStmt->errorInfo());
                }
                else {
                    $passwordExist = $pdoStmt->rowCount();
                }
            }

            //var_dump($loginExist);

           // var_dump($passwordExist);
            if($loginExist>0 && $passwordExist>0){
                $ok = true;
            }else{
                $ok = false;
                $conf->addError('Login ou mot de passe invalide !');
            }
           // var_dump($ok);
            if($ok==true){
            //    session_start();
                $userConnected = new User();
                $userSessionValues = $userConnected->getByUsername($login);
            //
            //    var_dump($userSessionValues);
                $_SESSION['id']=$userSessionValues['id'];
                $_SESSION['username']=$userSessionValues['username'];
                $_SESSION['lastname']=$userSessionValues['lastname'];
                $_SESSION['firstname']=$userSessionValues['firstname'];
                $_SESSION['email']=$userSessionValues['email'];
                header('Location:views\home.php');
            //    var_dump($_SESSION);
            }
        }
        return $conf;
    }

    public function userCreate(){
        if(!empty($_POST)) {
            $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
            $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
            $login = isset($_POST['login']) ? $_POST['login'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
            $role = isset($_POST['role']) ? $_POST['role'] : '';
            $formOk = true;

            if (empty($_POST['firstname'])) {
                $conf->addError('Veuillez renseigner le prénom');
                $formOk = false;
            }

            if (empty($_POST['lastname'])) {
                $conf->addError('Veuillez renseigner le nom');
                $formOk = false;
            }

            if (empty($_POST['login'])) {
                $conf->addError('Veuillez renseigner le login');
                $formOk = false;
            }else{
                $sql='SELECT * FROM user WHERE username=:username';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':username', $_POST['login']);
                if ($stmt->execute() === false) {
                    print_r($stmt->errorInfo());
                    return false;
                } else {
                    $usernameExist = $stmt->rowCount();
                    if($usernameExist>0){
                        $conf->addError('Ce nom d\'utilisateur existe déjà');
                        $formOk = false;
                    }
                }
            }

            if (empty($_POST['password'])) {
                $conf->addError('Veuillez renseigner le mot de passe');
                $formOk = false;
            }

            if ($_POST['password2'] != $_POST['password']) {
                $conf->addError('Veuillez confirmer votre mot de passe');
                $formOk = false;
            }

            if ($formOk = true) {
                $sql = 'INSERT INTO user
                        (`firstname`,
                        `lastname`,
                        `username`,
                        `created`,
                        `password`,
                        `post_id`)
                        VALUES
                        (:firstname,
                         :lastname,
                         :username,
                         :created,
                         :password,
                         :post_id
                    )';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':firstname', $this->firstname);
                $stmt->bindValue(':lastname', $this->lastname);
                $stmt->bindValue(':username', $this->username);
                $stmt->bindValue(':username', $this->age, \PDO::PARAM_INT);
                $stmt->bindValue(':friendliness', $this->friendliness->getId(), \PDO::PARAM_INT);
                $stmt->bindValue(':city', $this->city->getId(), \PDO::PARAM_INT);
                $stmt->bindValue(':training', $this->training->getId(), \PDO::PARAM_INT);

                if ($stmt->execute() === false) {
                    print_r($stmt->errorInfo());
                    return false;
                } else {
                    return true;
                    header('Location:views\userList.php');
                }
            }
        }
    }

    public function logout(){

    }

}