<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 28/08/2017
 * Time: 16:42
 */

// spl_autoload_register();

spl_autoload_register(function ($pClassName) {
    if (strpos($pClassName, "\\")) {
        $namespaces = explode("\\", $pClassName);
        $classname = array_pop($namespaces);
        $includingClassname = __DIR__.'/'.join('/', $namespaces).'/'.$classname.'.php';
    }
    else {
        $includingClassname = __DIR__.'/'.$pClassName.'.php';
    }
    require $includingClassname;
});

use Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

$conf = Config::getInstance();

use Classes\Cdcl\Db\Post;


if(!empty($_SESSION)){

    $postId = isset($_GET['id'])? $_GET['id'] : '';

    $postObject = new Post();

    // var_dump($postObject);

    $postList = Post::getAllForSelect();



    if ($postId > 0) {
        $postObject = Post::get($postId);
        //print_r($postObject);
    }

    // var_dump($postObject->getId());

    // Si lien suppression
    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Post::deleteById(intval($_GET['delete']))) {
            header('Location: post.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        //var_dump($_POST);

        $postId = isset($_POST['post_id']) ? $_POST['post_id'] : '';
        $postCode = isset($_POST['code']) ? $_POST['code'] : '';
        $postName = isset($_POST['name']) ? $_POST['name'] : '';
        $formOk = true;

        // exit;

        if (empty($_POST['name'])) {
            $conf->addError('Veuillez renseigner le nom du rôle.');
            $formOk = false;
        }
        //var_dump($formOk);


        if (empty($_POST['code'])) {
            $conf->addError('Veuillez définir un code.');
            $formOk = false;
        }
        //var_dump($formOk);



        if ($formOk) {
            // Je remplis l'objet Post avec les valeurs récupérées en POST
            $postObject = new Post(
                $postId,
                $postCode,
                $postName
            );
        //    var_dump($postObject);

            //var_dump($postId);

            //exit;

            $postObject->saveDB();
            header('Location: post.php?success='.urlencode('Ajout/Modification effectuée').'&post_id='.$postObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectPost = new SelectHelper($postList, $postId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));


    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'post.php';
    include $conf->getViewsDir().'footer.php';

    /**
     *
     *
     * Gestion de la durée pendant laquelle un User peut être
     * sans activité avant que le système ne le déconncete
     * Cette durée a été mis à 15mn soit 900s
     *
     *
     */

    if (isset($_SESSION['LAST_REQUEST_TIME'])) {
        if (time() - $_SESSION['LAST_REQUEST_TIME'] > 900) {
            // session timed out, last request is longer than 3 minutes ago
            $_SESSION = array();
            session_destroy();
        }
    }
    $_SESSION['LAST_REQUEST_TIME'] = time();

}else{
    header('Location: index.php');
}
