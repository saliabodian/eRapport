<?php
    /**
     * Created by PhpStorm.
     * User: sb_adm
     * Date: 28/08/2017
     * Time: 09:43
     */
    spl_autoload_register();

    use Classes\Cdcl\Db\Agence;

    $errorList = array();
    $agence = new Agence();
    if(!empty($_POST)) {
        $agenceName = isset($_POST['agence']) ? $_POST['agence'] : '';
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
        $code_postal = isset($_POST['code_postal']) ? $_POST['code_postal'] : '';
        $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
        $pays = isset($_POST['pays']) ? $_POST['pays'] : '';
        $formOk = true;

        if (empty($_POST['agence'])) {
            $errorList[] = 'Veuillez renseigner le nom de l\'Agence';
            $formOk = false;
        }
        var_dump($formOk);


        if (!empty($_POST['telephone'])) {
            if (!is_numeric($_POST['telephone'])){
                $errorList[] ='Veuillez saisir des chiffres';
                $formOk = false;
            }
        }

        var_dump($formOk);



        if ($formOk) {
            $agence = new Agence(
                $agenceName,
                $telephone,
                $adresse,
                $code_postal,
                $ville,
                $pays
            );
            var_dump($agence);

            var_dump($formOk);

            $agence->agenceCreate();

        }else{
            $errorList[] = 'Erreur dans l\'ajout ou la modification';
        }
    }


    include 'views\agenceCreate.php';

