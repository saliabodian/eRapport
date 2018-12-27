<?php

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

require_once 'functions/functions.php';
use \Classes\Cdcl\Config\Config;
use Classes\Cdcl\Db\User;
use Classes\Cdcl\Db\Rapport;

$conf = Config::getInstance();

if(!empty($_SESSION)){

    $subject = "Rappel : Reaffectation des interimaires.";

    $message ='';
    $message .= "<table style=\"width: 694px; border-collapse: collapse\">";
    $message .= "<tbody align='center' >";
    $message .= "<tr style=\"height: 80px;\">";
    $message .= "<td colspan=\"2\" style=\" background-color: #FFFACD ;width: 523px; height: 80px; font-weight:  bolder; font-size: large ; border-top-right-radius: 20px; border-top-left-radius: 20px\"><center>eRapport</center></td>";
    $message .= "</tr>";
    $message .= "<tr style=\"height: 200px\">";
    $message .= "<td colspan=\"2\" style=\" width: 697px; height: 200px; \">";
    $message .= "<p><center>Bonjour,<br><br></center><center>Merci de proc&eacute;der &agrave; la r&eacute;affectation des int&eacute;rimaires.</center><br><center>Bien cordialement.</center><br><br></p>";
    $message .= "<center><a href=\"http://summerhill.lu/~cdcl-beta/index.php\" target=\"_blank\" style='background-color: #2a00ff; color: #ffffff;'>Connexion au eRapport</a></center>";
    $message .= "</td>";
    $message .= "</tr>";
    $message .= "<tr style=\"height: 80px;\">";
    $message .= "<td colspan=\"2\" style=\"background-color: #FFFACD; width: 697px; height: 80px; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px\">";
    $message .= "<center>2017 &copy; eRapport By CDCL <a href=\"http://www.cdclux.com/en\" target=\"_blank\">www.cdclux.com</a></center>";
    $message .= "</td>";
    $message .= "</tr>";
    $message .= "</tbody>";
    $message .= "</table>";

    $user = new User();
    $rapport = new Rapport();

    $date = new \DateTime();
    $actualDate = $date->format('Y-m-d');
    $day = intval($date->format('N'));
    $week = intval($date->format('W'));

    // var_dump($_SERVER);

    // exit;
    // var_dump($actualDate);
    // var_dump($week);

    // die;
    //var_dump($conducReminder);

    $rhReminder = $rapport->checkExecutedScript($week, 'rh_reminder');



    if(sizeof($rhReminder) <= 0){
        if($day === 1 || $day === 7){
            // recupération de la liste des RH
            $listRh = User::getAllRh();

            $nbEmailSent = 0;

            foreach($listRh as $rh){
                emailSent($rh['email'], $subject, $message);
                $nbEmailSent++ ;
            }
        }


        if($nbEmailSent > 0){
            Rapport::updateReminder($actualDate, $week, 'rh_reminder');
        }
    }

}




