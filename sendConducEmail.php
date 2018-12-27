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

    $subject = "eRapports en attente de validation.";
    $message .= "<table style=\"width: 694px; border-collapse: collapse\">";
    $message .= "<tbody align='center' >";
    $message .= "<tr style=\"height: 80px;\">";
    $message .= "<td colspan=\"2\" style=\" background-color: #FFFACD ;width: 523px; height: 80px; font-weight:  bolder; font-size: large ; border-top-right-radius: 20px; border-top-left-radius: 20px\"><center>eRapport</center></td>";
    $message .= "</tr>";
    $message .= "<tr style=\"height: 200px\">";
    $message .= "<td colspan=\"2\" style=\" width: 697px; height: 200px; \">";
    $message .= "<p><center>Vous avez un certain nombre de rapports en attente de traitement.<br><br></center><center>Veuillez les valider !</center><br><center>Bien cordialement.</center><br><br></p>";
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

    $actualDate = date('Y-m-d', time());

    $week = date('W', time());

    $conducReminder = $rapport->checkReminder($actualDate, 'conduc_reminder');



    if(empty($conducReminder)){
        $listConduc = User::getAllConducteurs();

        $nbEmailSent ;
        foreach($listConduc as $conduc){
            $reportsToValidate = $user->reportsLeftToBeValidated($conduc['id']);
            $nbReports = sizeof($reportsToValidate);

        //    var_dump($conduc['id']);
        //    var_dump($conduc['email']);
        //    var_dump($nbReports);
            if($nbReports >= 3){
                emailSent($conduc['email'], $subject, $message);
                $nbEmailSent++ ;

            }

        }
    }

    if($nbEmailSent > 0){
        Rapport::updateReminder($actualDate, $week, 'conduc_reminder');
    }

}




