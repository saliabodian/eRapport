<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 15/09/2017
 * Time: 17:19
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

use \Classes\Cdcl\Config\Config;

use \Classes\Cdcl\Helpers\SelectHelper;

use Classes\Cdcl\Db\Qualification;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $qualifId = isset($_GET['id'])? $_GET['id'] : '';

    // exit;

    $qualifObject = new Qualification();

    $qualifList = Qualification::getAllForSelect();





    if ($qualifId > 0)
    {
        $qualifObject = Qualification::get($qualifId);
    }

    if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {
        if (Qualification::deleteById(intval($_GET['delete']))) {
            header('Location: qualification.php?success='.urlencode('Suppression effectuée'));
            exit;
        }
    }


    if(!empty($_POST)) {
        // exit;
        $qualifId = isset($_POST['qualif_id']) ? $_POST['qualif_id'] : '';
        $nomQualif = isset($_POST['nom_qualif']) ? $_POST['nom_qualif'] : '';

        $formOk = true;


        if (empty($nomQualif)) {
            $conf->addError('Veuillez renseigner le champ qualification.');
            $formOk = false;
        }
        //var_dump($formOk);

        if ($formOk) {
            // Je remplis l'objet Interimaire avec les valeurs récupérées en POST
            $qualifObject = new Qualification
                            ($qualifId,
                            $nomQualif
                            );


            $qualifObject->saveDB();

            header('Location: qualification.php?success='.urlencode('Ajout/Modification effectuée').'&qualification_id='.$qualifObject->getId());
            exit;

        }else{
            $conf->addError('Erreur dans l\'ajout ou la modification');
        }
    }

    $selectQualif = new SelectHelper($qualifList, $qualifId, array(
        'name' => 'id',
        'id' => 'id',
        'class' => 'select2-container',
    ));

    include $conf->getViewsDir().'header.php';
    include $conf->getViewsDir().'sidebar.php';
    include $conf->getViewsDir().'qualification.php';
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
