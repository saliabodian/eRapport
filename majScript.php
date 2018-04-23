<?php
/**
 * Created by PhpStorm.
 * User: sb_adm
 * Date: 27.02.2018
 * Time: 15:24
 */

spl_autoload_register(/**
 * @param $pClassName
 */
    function ($pClassName) {
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
use \Classes\Cdcl\Db\Interimaire;

$conf = Config::getInstance();


if(!empty($_SESSION)){

    $rslt = Interimaire::majScript();

    foreach($rslt as $r){
        $day= new DateTime($r['doy']);
        $id=$r['id'];
        $year = date('Y', strtotime($day->format('Y-m-d')));
        $sql = 'UPDATE interimaire_has_chantier SET year =:year WHERE id=:id';
        $stmt = Config::getInstance()->getPDO()->prepare($sql);
        $stmt->bindValue(':year', $year, \PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        if($stmt->execute()===false){
            print_r($stmt->errorInfo());
        }
    }
}else{
    header('Location: index.php');
}