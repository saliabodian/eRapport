<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
 */

spl_autoload_register();

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use \Classes\Cdcl\Db\User;

use \Classes\Cdcl\Db\Post;

use Classes\Cdcl\Db\Chantier;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $userId = isset($_GET['id'])? $_GET['id'] : '';

    // var_dump($userId);

    // exit;

    $userObject = new User();

    $userList = User::getAllForSelect();

    $postList = Post::getAllForSelect();

    $chantierActifs = Chantier::getAllForSelectActif();



    if ($userId > 0)
    {
        $userObject = User::get($userId);
        //    print_r($userObject);
    }

     // var_dump($userObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (User::deleteById(intval($_GET['delete']))) {
            header('Location: user.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
    //    var_dump($_POST);
    //    echo "<br>";
        //    exit;
        $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $registration_number = isset($_POST['$registration_number']) ? $_POST['$registration_number'] : '';
        $password1 = isset($_POST['password1']) ? $_POST['password1'] : '';
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
        $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $formOk = true;

        // exit;

        if (empty($_POST['username'])) {
            $conf->addError('Veuillez donner un login.');
            $formOk = false;
        }else{
            if($userId <= 0){
                $sql='SELECT * FROM user WHERE username=:username';
                $stmt = Config::getInstance()->getPDO()->prepare($sql);
                $stmt->bindValue(':username', $_POST['username']);
                if ($stmt->execute() === false) {
                    print_r($stmt->errorInfo());
                    return false;
                }else {
                    $usernameExist = $stmt->rowCount();
                    if($usernameExist>0){
                        $conf->addError('Ce nom d\'utilisateur existe déjà');
                        $formOk = false;
                    }
                }
            }
        }

        if (empty($_POST['firstname'])) {
            $conf->addError('Veuillez renseigner le prénom.');
            $formOk = false;
        }
        //var_dump($formOk);

        if (empty($_POST['lastname'])) {
            $conf->addError('Veuillez renseigner le nom.');
            $formOk = false;
        }

        if (empty($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $conf->addError('Email non valide');
        }

        if (empty($_POST['password1'])) {
            $conf->addError('Veuillez renseigner le mot de passe');
            $formOk = false;
        }

        if ($_POST['password2'] != $_POST['password1']) {
            $conf->addError('Veuillez confirmer votre mot de passe');
            $formOk = false;
        }



        if ($formOk) {
            // Je remplis l'objet User avec les valeurs récupérées en POST
            $userObject = new User(
                $userId,
                $username,
                $firstname,
                $lastname,
                $email,
                $registration_number,
                $password1,
                new Post($post_id)
            );

            $userObject->saveDB();
            header('Location: user.php?success='.urlencode('Ajout/Modification effectuée').'&user_id='.$userObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectUser = new SelectHelper($userList, $userId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'form-control',
    ));

    $selectPost = new SelectHelper($postList, $userObject->getPostId()->getId(), array(
        'name' => 'post_id',
        'id' => 'id',
        'class' => 'form-control',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'user.php';
    include $conf->getViewsDir().'footer.php';
}else{
    header('Location: index.php');
}
